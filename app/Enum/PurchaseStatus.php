<?php

namespace App\Enum;

enum PurchaseStatus: string
{
    case NEW = 'new';
    case SHIPPED = 'shipped';
    case DELIVERED = 'delivered';
}
