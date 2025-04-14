<?php

namespace App\Enum;

enum Role: string
{
    case ADMIN    = 'admin';
    case MANAGER  = 'manager';
    case WHATSAPP_CLIENT   = 'whatsapp_client';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => __('Администратор'),
            self::MANAGER => __('Менеджер'),
            self::WHATSAPP_CLIENT => __('Клиент (whatsapp)')
        };
    }

    public static function getRoles(): array
    {
        $cases = [];
        foreach (Role::cases() as $case) {
            $cases[$case->value] = Role::from($case->value)->label();
        }
        return $cases;
    }
}
