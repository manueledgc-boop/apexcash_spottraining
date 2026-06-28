<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\AiUsageLog;

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

        $models = array_values(array_filter(array_unique([
            env('GEMINI_MODEL', 'gemini-2.5-flash'),
            env('GEMINI_FALLBACK_MODEL', 'gemini-2.5-flash-lite'),
        ])));

        $key = env('GEMINI_API_KEY');

        if (!$key) {

            return response()->json([
                'status' => 'ai_error',
                'message' => 'API key missing.',
            ], 500);
        }

        $user = $request->user();

        if (! $user?->hasPremiumAccess()) {
            $usedLast24Hours = AiUsageLog::query()
                ->where('user_id', $user->id)
                ->where('feature', 'hand_lab_ai')
                ->where('created_at', '>=', now()->subDay())
                ->count();

            if ($usedLast24Hours >= 5) {
                return response()->json([
                    'status' => 'free_limit_reached',
                    'message' => 'Has alcanzado el límite gratuito de Hand Lab por 24 horas. Vuelve más tarde o actualiza a Premium para análisis ilimitados.',
                ]);
            }
        }

        $response = null;
        $lastProviderError = null;
        $lastProviderStatus = null;

        foreach ($models as $model) {
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

            if ($response->successful()) {
                break;
            }

            $lastProviderStatus = $response->status();
            $lastProviderError = $response->json();

            if (! in_array($response->status(), [429, 503], true)) {
                break;
            }
        }

        if (! $response || ! $response->successful()) {
            if ($lastProviderStatus === 429) {
                return response()->json([
                    'status' => 'ai_quota_exceeded',
                    'message' => 'AI quota exceeded.',
                    'provider_status' => $lastProviderStatus,
                    'provider_error' => $lastProviderError,
                ], 200);
            }

            if ($lastProviderStatus === 503) {
                return response()->json([
                    'status' => 'ai_busy',
                    'message' => 'AI provider busy.',
                    'provider_status' => $lastProviderStatus,
                    'provider_error' => $lastProviderError,
                ], 200);
            }

            return response()->json([
                'status' => 'ai_error',
                'message' => 'AI analysis failed.',
                'provider_status' => $lastProviderStatus,
                'provider_error' => $lastProviderError,
            ], 500);
        }

        $raw = $response->json('candidates.0.content.parts.0.text');

        $analysis = json_decode($raw, true);

        if (! is_array($analysis)) {
            return response()->json([
                'status' => 'ai_busy',
                'message' => 'La IA devolvió una respuesta incompleta. Intenta nuevamente.',
            ], 200);
        }

        $allowedGrades = ['best', 'good', 'marginal', 'mistake'];

        $options = $validated['options'];

        $heroChoice = $analysis['hero_choice'] ?? $validated['selected_action'];
        $bestAction = $analysis['best_action'] ?? null;
        $grade = $analysis['grade'] ?? 'marginal';

        if ($heroChoice !== $validated['selected_action']) {
            $heroChoice = $validated['selected_action'];
        }

        if (! in_array($bestAction, $options, true)) {
            $bestAction = null;
            $grade = 'marginal';
            $analysis['confidence'] = 0;
        }

        if (! in_array($grade, $allowedGrades, true)) {
            $grade = 'marginal';
        }

        $confidence = max(0, min(100, (int) ($analysis['confidence'] ?? 70)));

        if (! $user?->hasPremiumAccess()) {
            AiUsageLog::create([
                'user_id' => $user->id,
                'feature' => 'hand_lab_ai',
                'used_on' => now()->toDateString(),
                'count' => 1,
            ]);
        }

        return response()->json([
            'status' => 'ai_analysis',
            'hero_choice' => $heroChoice,
            'best_action' => $bestAction,
            'grade' => $grade,
            'gto' => $analysis['gto'] ?? '',
            'micro' => $analysis['micro'] ?? '',
            'feedback' => $analysis['feedback'] ?? '',
            'confidence' => $confidence,
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

        // NOTA: El texto del prompt se alinea a la izquierda para evitar espacios basura
        return <<<PROMPT
Hand History Data:
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
No inventes datos. Tu objetivo es evaluar la acción de Hero en microlímites (NL2-NL10), explicando 
la teoría GTO de forma extremadamente simple y aportando adaptaciones explotativas claras, sencillas 
y realistas para batir estos niveles.

REGLAS DE RESPUESTA (ESTRICTO JSON):
1. Los valores de los campos "gto", "micro" y "feedback" deben estar escritos obligatoriamente en ESPAÑOL.
2. Si falta información crucial para analizar el spot, devuelve el JSON con los campos de texto vacíos y 
    "confidence": 0.
3. Los campos "gto", "micro" y "feedback" tienen un límite ESTRICTO de 20 palabras cada uno. Sé conciso y 
    directo al grano.

Campos del JSON que debes rellenar:
- "hero_choice": (String) Debe ser exactamente el valor recibido en 'hero_choice'.
- "best_action": (String) La mejor opción estratégica entre las opciones de 'available_options'.
- "grade": (String) Evalúa 'hero_choice' respecto a 'best_action'. Valores permitidos: "best", "good", "marginal" o "mistake".
- "feedback": (String) Crítica u opinión directa y concisa sobre la decisión de Hero. MÁXIMO 20 PALABRAS.
- "gto": (String) Explicación GTO ultra-simplificada. Analiza con precisión la fuerza real de la mano según la calle actual (preflop o postflop). MÁXIMO 20 PALABRAS.
- "micro": (String) Explicación explotativa simple para NL2-NL10. Indica cómo explotar las tendencias del rival en esta calle (ej. pagan de más, no farolean). MÁXIMO 20 PALABRAS.
- "confidence": (Integer) Número entero de 0 a 100 que indique tu certeza matemática sobre este análisis.

JSON format structure:
{"hero_choice":"","best_action":"","grade":"","feedback":"","gto":"","micro":"","confidence":0}
PROMPT;
    }
}