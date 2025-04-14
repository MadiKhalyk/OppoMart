<?php

namespace App\Enum;

enum WhatsappStatusCode: string
{
    case MESSAGE_UNDELIVERABLE         = '131026'; // Невозможно доставить сообщение
    case MESSAGE_REENGAGEMENT_REQUIRED = '131047'; // Более 24 часов, требуется шаблонное сообщение
}
