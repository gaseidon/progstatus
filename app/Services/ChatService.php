<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
// $data['choices'][0]['message']['content'] = 'Хм, пользователь спрашивает про интегралы, но это явно математическая тема, а не юридическая. 

// В предыдущем взаимодействии я четко обозначил свою специализацию — только юридические вопросы. Пользователь либо не заметил это, либо проверяет границы моей компетенции. 

// Интересно, возможно, он перепутал юридические термины с математическими? Например, мог иметь в виду "интеграцию" в контексте международного права или миграционного законодательства. Но сам запрос слишком краток и не содержит уточнений. 

// Лучший подход — вежливо напомнить о своей специализации, не делая предположений. Если пользователь действительно имел в виду правовой аспект, он уточнит. Важно сохранить нейтральный тон, без раздражения. 

// Кстати, запрос написан с опечатками ("а инртегралы"), что может указывать на спешку или мобильный ввод. Возможно, пользователь просто ошибся разделом. 

// Ответ должен быть однозначным, но оставляющим пространство для уточнения — вдруг за этим стоит какой-то неочевидный правовой вопрос?
// </think>
// Я могу отвечать только на юридические вопросы. Интегралы относятся к области математического анализа, и я не обладаю компетенцией для консультаций по этой теме. 

// Если у вас есть вопрос в сфере права (законодательство, судебная практика, договоры, права граждан и т.п.) — задайте его, и я постараюсь помочь.';
// dd(explode("</think>\n", $data['choices'][0]['message']['content'], 2));
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
