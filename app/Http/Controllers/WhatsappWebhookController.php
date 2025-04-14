<?php

namespace App\Http\Controllers;

use App\Enum\WhatsappMessageType;
use App\Services\FacebookService;
use App\Services\UserService;
use App\Services\Whatsapp\WhatsappService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class WhatsappWebhookController extends Controller
{
    public function __construct(
        public WhatsappService $whatsappService,
        public FacebookService $facebookService,
        public UserService $userService,
    )
    {
    }

    public function __invoke(Request $request)
    {
        if ($request->isMethod('GET')){
            return $this->facebookService->verifyWebhookUrl($request);
        }
        elseif ($request->isMethod('POST')){
            $response = json_decode($request->getContent(), true);
            if (isset($response['object']) && $response['object'] == 'whatsapp_business_account') {
                $entry   = $response['entry'][0] ?? null;
                $changes = $entry['changes'][0] ?? null;
                $value   = $changes['value'] ?? null;

                if ($changes && $value) {
                    $metadata = $value['metadata'] ?? null;
                    $contacts = $value['contacts'][0] ?? null;
                    $messages = $value['messages'][0] ?? null;

                    if ($messages) {
                        $phone         = $contacts['wa_id'] ?? null;
                        $phoneNumberId = $metadata['phone_number_id'] ?? null;
                        $messageType   = $messages['type'] ?? null;

                        if (!$phone || !$phoneNumberId || !$contacts) return null;

                        $chat = $this->whatsappService->getChatByPhone($phone);

                        if ( !$chat) {
                            $client = $this->userService->createUserAndAssignRole(
                                data: [
                                    'name'  => $contacts['profile']['name'] ?? null,
                                    'phone' => $phone,
                                    'email' => "$phone@gmail.com",
                                    'password' => Hash::make(Str::random()),
                                ],
                                role: 'whatsapp_client'
                            );

                            $chat = $this->whatsappService->createChat(
                                data: [
                                    'user_id'         => $client->id,
                                    'phone'           => $phone,
                                    'phone_number_id' => $phoneNumberId,
                                    'username'        => $contacts['profile']['name'] ?? null
                                ]
                            );
                        }

                        if ($messageType == WhatsappMessageType::TEXT->value) {
                            $messageText = $messages['text']['body'];

                            $content = [
                                'type' => 'root',
                                'text' => $messageText,
                            ];

                            $this->whatsappService->processContent(
                                WhatsappMessageType::TEXT->value,
                                $chat,
                                $content
                            );
                        }
                    }
                }
            }
        }

        return null;
    }
}
