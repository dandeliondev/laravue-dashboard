<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $all = Role::allPermissionKeys();

        $roles = [
            ['name' => 'Administrator', 'description' => 'Full access to every part of the system', 'color' => 'primary', 'permissions' => $all],
            ['name' => 'Manager', 'description' => 'Manages users and content', 'color' => 'info', 'permissions' => ['users.view', 'users.create', 'users.edit', 'content.view', 'content.publish', 'settings.view']],
            ['name' => 'Editor', 'description' => 'Creates and edits content', 'color' => 'success', 'permissions' => ['users.view', 'content.view', 'content.publish']],
            ['name' => 'Author', 'description' => 'Writes content for review', 'color' => 'warning', 'permissions' => ['content.view']],
            ['name' => 'Viewer', 'description' => 'Read-only access', 'color' => 'secondary', 'permissions' => ['users.view', 'content.view', 'settings.view']],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['name' => $role['name']], $role);
        }

        // Assign a role to any user that doesn't have one yet.
        $roleIds = Role::pluck('id')->all();
        User::whereNull('role_id')->each(function (User $user) use ($roleIds) {
            $user->update(['role_id' => $roleIds[array_rand($roleIds)]]);
        });
    }
}
