<?php

namespace App\Enum;

enum PurchaseStatus: string
{
    case NEW = 'new';
    case CONFIRMED = 'confirmed';
    case SHIPPED = 'shipped';
    case DELIVERED = 'delivered';
}
