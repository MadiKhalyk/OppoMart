<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class FacebookService
{
    public function verifyWebhookUrl($request)
    {
        $mode         = $request->get('hub_mode');
        $verify_token = $request->get('hub_verify_token');
        $challenge    = $request->get('hub_challenge');
        if ($challenge) {
            if ($mode == 'subscribe' && $verify_token == 'uWmxhsJi') {
                Log::debug('WEBHOOK_VERIFIED');
                return $challenge;
            }
        }
        return null;
    }
}
