<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class ChatService
{
    public function getUserAgents()
    {
        return Auth::user()->agents()->get();
    }

    public function sendToExternalAI(string $userMessage, \App\Models\Chat $chat): ?string
    {
        $agent = $chat->agent;
        $systemPrompt = $agent->getSystemPrompt();

        $client = new \GuzzleHttp\Client();
        $body = [
            'model' => 'deepseek-ai/DeepSeek-R1-0528',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => "Инструкция: {$systemPrompt}\n\nСообщение пользователя: {$userMessage}"
                ],
                // [
                //     'role' => 'system',
                //     'content' => 'You are a helpful assistant.'
                // ],
            ],

        ];
        try {
            $response = $client->request('POST', 'https://api.intelligence.io.solutions/api/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer io-v2-eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJvd25lciI6ImQwMjg1YTM2LThhOWYtNGQ5NC1iZDQ1LWRhZjM4OWNkNjVkYiIsImV4cCI6NDkwNTE0MzUyN30.Iuq0i6St_gYKNUYQDs-9FeUPJlgK-8p4WQaUxg6pkKWpEgxYR_u_sdtmR4vLNEkeNI4SYj-co1VduvEfLLUtnA',
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                ],
                'json' => $body,
            ]);
            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['error'])) {
                return 'Ошибка API: ' . ($data['error']['message'] ?? json_encode($data['error'], JSON_UNESCAPED_UNICODE));
            }

            if (isset($data['choices'][0]['message']['content'])) {
                $content = $data['choices'][0]['message']['content'];
                $content = explode("</think>\n", $content);
                $content = array_pop($content);
                $content = str_replace('*', '', $content);
                return $content;
            }

            return 'Неожиданный ответ: ' . json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            return 'Ошибка: ' . $e->getMessage();
        }
    }
}
