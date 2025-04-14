<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function createUserAndAssignRole(array $data, string $role)
    {
        $user = User::query()->create($data);
        $user->assignRole($role);

        return $user;
    }
}
