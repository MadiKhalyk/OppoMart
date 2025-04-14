<?php

namespace App\Enum;

enum WhatsappMessageStatus: string
{
    case FAILED    = 'failed';
    case DELIVERED = 'delivered';
    case SENT      = 'sent';
}
