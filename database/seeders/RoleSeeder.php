<?php

namespace Database\Seeders;

use App\Enum\Role as RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            RoleEnum::ADMIN->value,
            RoleEnum::MANAGER->value,
            RoleEnum::WHATSAPP_CLIENT->value,
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}
