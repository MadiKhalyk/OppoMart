<?php

namespace App\Services\Whatsapp\Handlers;

use App\Services\Whatsapp\WhatsappService;
use Illuminate\Support\Facades\Log;

class TextHandler implements ContentHandler
{
    public function handle($chat, $content): void
    {
        $whatsappService = app(WhatsappService::class);

        $whatsappService->sendMessage(
            phoneNumberId: $chat->phone_number_id,
            body: [
                'phone' => $chat->phone,
                'type' => 'interactive',
                'interactive' => [
                    "type"     => "cta_url",
                    "body"     => [
                        "text" => 'Здравствуйте! Вы можете заказать продукты в нашем сайте.'
                    ],
                    "action"   => [
                        "name" => "cta_url",
                        "parameters" => [
                            "display_text" => "Заказать продукты",
                            "url" => "https://optomart24.kz?p={$chat->phone}"
                        ]
                    ]
                ],
            ],
        );
    }
}
