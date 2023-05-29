<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Core\Entities\Role;
use Modules\User\Enum\UserType;

class RoleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            UserType::ADMIN->value,
            UserType::ORGANIZER->value,
            UserType::EMPLOYEE->value,
            UserType::MEMBER->value,
            UserType::SUPPLIER->value,
        ];
        foreach ($roles as $role) {
            Role::create([
                "name" => $role,
                "role_uuid" => Str::uuid(),
            ]);
        }
    }
}
