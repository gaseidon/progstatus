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

    public function sendToExternalAI(string $userMessage): ?string
    {
        $client = new \GuzzleHttp\Client();
        $body = [
            'model' => 'deepseek-ai/DeepSeek-R1-0528',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $userMessage
                ],
                [
                    'role' => 'system',
                    'content' => "Вы — специализированный юридический ассистент. Отвечайте исключительно на юридические вопросы. Если вопрос не касается права, законодательства, судебной практики или правовых норм — сообщите, что вы не можете помочь в этом направлении."
                ],
                ],  
                '{"max_tokens":100}',
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
            // Проверяем наличие ошибок в ответе
            if (isset($data['error'])) {
                return 'Ошибка API: ' . ($data['error']['message'] ?? json_encode($data['error'], JSON_UNESCAPED_UNICODE));
            }
            // Проверяем стандартную структуру ответа
            if (isset($data['choices'][0]['message']['content'])) {
                $content = $data['choices'][0]['message']['content'];
                // Разбиваем по </think>, выводим только то, что после
                $parts = explode('</think>', $content, 2);
                if (count($parts) === 2) {
                    return ltrim($parts[1]);
                }
                return $content;
            }
            // Если структура другая, возвращаем весь ответ для отладки
            return 'Неожиданный ответ: ' . json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            return 'Ошибка: ' . $e->getMessage();
        }
    }
} 