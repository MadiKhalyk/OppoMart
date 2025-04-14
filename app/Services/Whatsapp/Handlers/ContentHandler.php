<?php

namespace App\Services\Whatsapp\Handlers;

interface ContentHandler
{
    public function handle($chat, $content): void;
}
