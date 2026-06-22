<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class GeminiTestController extends Controller
{
    public function test()
    {
        $prompt =$prompt = <<<PROMPT
Responde SOLO JSON válido. Sin markdown.

Eres coach de poker NL2-NL10.
No uses solver exacto. Usa GTO simplificado.
Street: TURN

Hero position: BB
Villain position: BTN

Hero cards:
Ah 9h

Board:
Ks 7d 2c 9s

Previous action:
BTN opens 2.5 BB
BB calls

Flop:
Ks 7d 2c

BB checks
BTN checks back

Turn:
9s

Action on Hero

Hero decision:
BET_66

Options:
CHECK
BET_33
BET_66

Reglas:
grade solo puede ser: best, good, marginal, mistake.
confidence debe ser número de 0 a 100.
gto máximo 18 palabras.
micro máximo 18 palabras.
feedback máximo 22 palabras.
best_action debe estar dentro de Options.

Formato exacto:
{"hero_choice":"","best_action":"","grade":"","gto":"","micro":"","feedback":"","confidence":0}
PROMPT;

        $model = env('GEMINI_MODEL', 'gemini-2.5-flash-lite');
        $key = env('GEMINI_API_KEY');

        $response = Http::timeout(30)->post(
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
                    'temperature' => 0,
                    'maxOutputTokens' => 250,
                    'responseMimeType' => 'application/json',
                ],
            ]
        );

        return response()->json($response->json(), $response->status());
    }
}