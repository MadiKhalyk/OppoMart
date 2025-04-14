<?php

namespace App\Enum;

enum WhatsappMessageType: string
{
    case TEXT         = 'text';
    case TEMPLATE     = 'template';
    case IMAGE        = 'image';
    case DOCUMENT     = 'document';
    case BUTTON       = 'button';
    case INTERACTIVE  = 'interactive';

    case BUTTON_REPLY = 'button_reply';

    case NFM_REPLY    = 'nfm_reply';


    case REPLY        = 'reply';
}
