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
                'type' => 'text',
                'text' => "https://optomart24.kz?p={$chat->phone}"
            ],
        );
    }
}
