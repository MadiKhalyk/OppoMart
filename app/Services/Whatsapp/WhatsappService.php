<?php

namespace App\Services\Whatsapp;

use App\Enum\WhatsappMessageType;
use App\Models\Chat;
use App\Models\WhatsappChat;
use App\Services\OpenAIService;
use App\Services\Whatsapp\Handlers\ContentHandlerFactory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WhatsappService
{
    protected string $base_url = 'https://graph.facebook.com/v22.0';
    protected mixed $token;

    public function __construct()
    {
        $this->token = config('services.whatsapp.token');
    }

    public function sendMessage(string $phoneNumberId, array $body)
    {
        $_body = $this->transformMessageBody($body);

        try {
            return Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
                'Content-Type' => 'application/json',
            ])->post($this->base_url . "/{$phoneNumberId}/messages", $_body);
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
        }
        return null;
    }

    public function uploadMedia(string $phoneNumberId, array $data)
    {
        try {
            return Http::withToken($this->token)
                ->attach(
                    'file',
                    fopen($data['url'], 'r'),
                    basename($data['url'])
                )
                ->post("{$this->base_url}/{$phoneNumberId}/media", [
                    ['name' => 'messaging_product', 'contents' => 'whatsapp'],
                    ['name' => 'type', 'contents' => $data['mimeType']],
                ]);

//            return Http::withHeaders([
//                'Authorization' => 'Bearer ' . $this->token,
//                'Content-Type' => 'application/json',
//            ])->post($this->base_url . "/{$phoneNumberId}/media", [
//                    'messaging_product' => 'whatsapp',
//                    'type' => $data['mimeType'],
//                    'file' => $data['url'],
//                ]);
        } catch (\Exception $e) {
            Log::error('WhatsApp API Error: ' . $e->getTraceAsString());
        }
        return null;
    }

    public function getMedia($mediaId)
    {
        try {
            return Http::withToken($this->token)
                ->get("{$this->base_url}/{$mediaId}");
        } catch (\Exception $e) {
            Log::error('WhatsApp API Error: ' . $e->getTraceAsString());
            return null;
        }
    }

    public function getMediaContent($url): ?string
    {
        try {
            $imageContent = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
            ])->get($url);

            return $imageContent->getBody()->getContents();
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return null;
        }
    }

    public function processContent(string $type, WhatsappChat $chat, string|array $content): void
    {
        $handler = ContentHandlerFactory::getHandler($type);
        $handler->handle($chat, $content);
    }

    public function createChat(array $data)
    {
        $chat = WhatsappChat::query()
            ->create(
                [
                    'user_id' => $data['user_id'],
                    'phone' => $data['phone'],
                    'phone_number_id' => $data['phone_number_id'],
                    'username' => $data['username'] ?? null,
                    'assistant_id' => config('openai.assistant_id'),
                ]
            );

//        if (is_null($chat->thread_id)) {
//            $chat->thread_id = app(OpenAIService::class)->createThread()?->id;
//            $chat->save();
//        }

        return $chat;
    }

    public function getChatByPhone(string $phone)
    {
        return WhatsappChat::query()
            ->where('phone', $phone)
            ->first();
    }

    private function transformMessageBody(array $body): array
    {
        $messageType = $body['type'];

        $_body = [
            'messaging_product' => 'whatsapp',
            'recipient_type'    => 'individual',
            'to'                => $body['phone'],
            'type'              => $messageType,
        ];

        if (isset($body['context'])) {
            $_body['context'] = $body['context'];
        }

        switch ($messageType) {
            case WhatsappMessageType::TEXT->value:
                $_body['text'] = [
                    'body' => $body['text']
                ];
                break;
            case WhatsappMessageType::TEMPLATE->value:
                $_body['template'] = [
                    'name' => $body['template_name'],
                    'language' => [
                        'code' => $body['language_code']
                    ],
                ];
                if (!empty($body['components'])) {
                    $_body['template']['components'] = $body['components'];
                }
                break;
            case WhatsappMessageType::INTERACTIVE->value:
                $_body['interactive'] = $body['interactive'];
                break;
            case WhatsappMessageType::IMAGE->value:
                $_body['image'] = $body['image'];
                break;
            case WhatsappMessageType::DOCUMENT->value:
                $_body['document'] = $body['document'];
                break;
            default:
                break;
        }

        return $_body;
    }
}
