<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['role_name' => 'user'],
            ['role_name' => 'admin'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['role_name' => $role['role_name']],
                $role
            );
        }

        $createdRoles = Role::all();
        foreach ($createdRoles as $role) {
            echo "Created role: ID {$role->id} - {$role->role_name}\n";
        }
    }
}
