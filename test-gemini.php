<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class GeminiTestController extends Controller
{
    public function test()
    {
        $prompt = <<<PROMPT
Eres un coach de poker.

Hero:
UTG
AA

Accion elegida:
RAISE

Opciones:
FOLD
CALL
RAISE

Responde SOLO JSON:

{
  "best_action":"",
  "grade":"",
  "gto":"",
  "micro":""
}
PROMPT;

        $response = Http::post(
            'https://generativelanguage.googleapis.com/v1beta/models/'
            . env('GEMINI_MODEL')
            . ':generateContent?key='
            . env('GEMINI_API_KEY'),
            [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $prompt,
                            ],
                        ],
                    ],
                ],
            ]
        );

        return $response->json();
    }
}