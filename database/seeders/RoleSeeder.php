<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'name' => 'user',
                'description' => 'Обычный пользователь'
            ],
            [
                'name' => 'admin',
                'description' => 'Администратор'
            ],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name' => $role['name']],
                $role
            );
        }

        $createdRoles = Role::all();
        foreach ($createdRoles as $role) {
            echo "Created role: ID {$role->id} - {$role->name}\n";
        }
    }
}
