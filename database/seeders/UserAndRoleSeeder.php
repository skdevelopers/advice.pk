<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserAndRoleSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Create the initial admin user
        $user = User::factory()->create([
            'name'     => 'Admin User',
            'email'    => 'admin@advice.pk',
            'password' => Hash::make('password'), // please change!
        ]);

        // 2) Define all permissions your app needs
        $resources = [
            'users',
            'cities',
            'societies',
            'sub_societies',
            'sub_sectors',
            'properties',
        ];

        $actions = ['view', 'create', 'edit', 'delete'];

        $allPermissions = [];
        foreach ($resources as $res) {
            foreach ($actions as $act) {
                $allPermissions[] = "{$act} {$res}";
            }
        }

        // 3) Create or fetch each permission
        foreach (array_unique($allPermissions) as $permissionName) {
            Permission::firstOrCreate([
                'name'       => $permissionName,
                'guard_name' => 'web',
            ]);
        }

        // 4) Create “admin” role and sync all permissions to it
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin', 'guard_name' => 'web']
        );
        $adminRole->syncPermissions(Permission::all());

        // 5) Assign the admin role to our user
        $user->assignRole($adminRole);
    }
}
