<?php

namespace App\Services\Whatsapp\Handlers;

use App\Services\Whatsapp\WhatsappService;
use Illuminate\Support\Facades\Log;

class TextHandler implements ContentHandler
{
    public function handle($chat, $content): void
    {

        Log::debug($content);
        $whatsappService = app(WhatsappService::class);

        Log::debug($chat);
        $whatsappService->sendMessage(
            phoneNumberId: $chat->phone_number_id,
            body: [
                'phone' => $chat->phone,
                'type' => 'text',
                'text' => "http://opto-market.test?p={$chat->phone}"
            ],
        );
    }
}
