<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HandLabAiController extends Controller
{
    public function analyze(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'format' => ['nullable', 'string', 'max:40'],
            'street' => ['required', 'string', 'max:20'],
            'spot_type' => ['nullable', 'string', 'max:120'],
            'spot_label' => ['nullable', 'string', 'max:120'],
            'hero_position' => ['required', 'string', 'max:10'],
            'villain_position' => ['required', 'string', 'max:10'],
            'hero_cards' => ['required', 'array', 'size:2'],
            'hero_cards.*' => ['required', 'string', 'max:3'],
            'board_cards' => ['nullable', 'array'],
            'board_cards.*' => ['nullable', 'string', 'max:3'],
            'pot_bb' => ['nullable', 'numeric'],
            'spr' => ['nullable', 'numeric'],
            'effective_stack_bb' => ['nullable', 'numeric'],
            'actions' => ['nullable', 'array'],
            'options' => ['required', 'array', 'min:2'],
            'selected_action' => ['required', 'string', 'max:40'],
        ]);

        $prompt = $this->buildPrompt($validated);

        $model = env('GEMINI_MODEL', 'gemini-2.5-flash-lite');
        $key = env('GEMINI_API_KEY');

        if (!$key) {
            return response()->json([
                'status' => 'ai_error',
                'message' => 'Gemini API key missing.',
            ], 500);
        }

        $response = Http::timeout(35)->post(
            "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$key}",
            [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt],
                        ],
                    ],
                ],
                'generationConfig' => [
                    'temperature' => 0.1,
                    'topP' => 0.1,
                    'maxOutputTokens' => 350,
                    'responseMimeType' => 'application/json',
                ],
            ]
        );

        if (!$response->successful()) {
            return response()->json([
                'status' => 'ai_error',
                'message' => 'AI analysis failed.',
                'provider_status' => $response->status(),
                'provider_error' => $response->json(),
            ], 500);
        }

        $raw = $response->json('candidates.0.content.parts.0.text');

        $analysis = json_decode($raw, true);

        if (!is_array($analysis)) {
            return response()->json([
                'status' => 'ai_error',
                'message' => 'AI returned invalid JSON.',
                'raw' => $raw,
            ], 500);
        }

        return response()->json([
            'status' => 'ai_analysis',
            'hero_choice' => $analysis['hero_choice'] ?? $validated['selected_action'],
            'best_action' => $analysis['best_action'] ?? null,
            'grade' => $analysis['grade'] ?? 'marginal',
            'concept' => $analysis['concept'] ?? null,
            'gto' => $analysis['gto'] ?? '',
            'micro' => $analysis['micro'] ?? '',
            'feedback' => $analysis['feedback'] ?? '',
            'confidence' => (int) ($analysis['confidence'] ?? 70),
        ]);
    }

    private function buildPrompt(array $payload): string
    {
        $actions = collect($payload['actions'] ?? [])
            ->map(function ($action) {
                if (is_array($action)) {
                    return strtoupper($action['street'] ?? '') . ' - '
                        . strtoupper($action['actor'] ?? '') . ' '
                        . strtolower($action['type'] ?? '')
                        . (isset($action['size']) && $action['size'] ? ' ' . $action['size'] . ' BB' : '');
                }

                return (string) $action;
            })
            ->values()
            ->implode("\n");

        $board = implode(' ', $payload['board_cards'] ?? []);
        $heroCards = implode(' ', $payload['hero_cards']);
        $options = implode(', ', $payload['options']);

        return <<<PROMPT
            Return valid JSON only. No markdown.

            Hand:
            street={$payload['street']}
            spot_type={$payload['spot_type']}
            spot_label={$payload['spot_label']}
            hero_position={$payload['hero_position']}
            villain_position={$payload['villain_position']}
            hero_cards={$heroCards}
            board_cards={$board}
            pot_bb={$payload['pot_bb']}
            spr={$payload['spr']}
            effective_stack_bb={$payload['effective_stack_bb']}
            previous_action:
            {$actions}

            hero_choice={$payload['selected_action']}
            available_options={$options}

            Reglas de Rol:
            Eres un coach profesional de póker analítico y riguroso. Tu tono es serio, directo y estratégico. 
            No inventes datos ni alucines. Tu objetivo es evaluar la acción de Hero en microlímites (NL2-NL10), 
            equilibrando la teoría GTO con adaptaciones explotativas reales para batir estos niveles.

            REGLAS DE RESPUESTA:
            1. Responde ÚNICA Y EXCLUSIVAMENTE con el objeto JSON solicitado. No incluyas texto antes, ni después, 
                ni bloques de código markdown (prohibido usar ```json). Solo el JSON plano.
            2. Los valores de los campos "gto", "micro" y "feedback" deben estar escritos OBLIGATORIAMENTE en idioma: ESPAÑOL.
            3. Si falta información crucial para analizar el spot, devuelve el JSON con los campos de texto vacíos y "confidence": 0.
            4. Los campos "gto", "micro" y "feedback" tienen un límite ESTRICTO de 20 palabras cada uno. Sé conciso y directo al grano.

            Campos del JSON que debes rellenar:
            - "hero_choice": (String) Debe ser exactamente el valor recibido en la variable 'hero_choice'.
            - "best_action": (String) La mejor opción estratégica entre las opciones enviadas en 'available_options'.
            - "grade": (String) Evalúa 'hero_choice' respecto a 'best_action'. Debe ser exactamente uno de estos cuatro 
                valores: "best", "good", "marginal" o "mistake".
            - "feedback": (String) Una crítica u opinión directa y concisa del coach sobre la decisión de Hero. 
                MÁXIMO 20 PALABRAS.
            - "gto": (String) Explicación teórica/GTO simplificada de este spot. MÁXIMO 20 PALABRAS.
            - "micro": (String) Explicación explotativa para NL2-NL10, indicando cómo desviarse para explotar 
                las tendencias del nivel. MÁXIMO 20 PALABRAS.
            - "confidence": (Integer) Número entero de 0 a 100 que indique tu certeza matemática sobre este análisis.

            JSON format:
            {"hero_choice":"","best_action":"","grade":"","feedback":"","gto":"","micro":"","confidence":0}
        PROMPT;
    }
}