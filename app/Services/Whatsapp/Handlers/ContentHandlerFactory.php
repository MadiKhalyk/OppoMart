<?php

namespace App\Services\Whatsapp\Handlers;


use App\Enum\WhatsappMessageType;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class ContentHandlerFactory
{
    public static function getHandler(string $type): ContentHandler
    {
        return match ($type) {
            WhatsappMessageType::TEXT->value => new TextHandler(),
            WhatsappMessageType::DOCUMENT->value => new DocumentHandler(),
            WhatsappMessageType::IMAGE->value => new ImageHandler(),
            default => self::logAndThrow($type),
        };
    }

    protected static function logAndThrow(string $type): never
    {
        Log::error("Unsupported content type: $type");
        throw new InvalidArgumentException("Unsupported content type: $type");
    }
}
