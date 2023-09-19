<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Modules;
use App\Models\Packages;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use App\Models\UserInType;
use App\Models\UserRole;
use App\Models\UserType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'display_picture' => 'profileimage/test.png',
            'user_name' => 'User',
            'first_name' => 'User',
            'last_name' => 'User',
            'gender' => 'male',
            'email' => 'user@test.com',
            'phone' => '123456789',
            'dob' => date('Y-m-d h:i:s'),
            'password' => Hash::make('123456'),
            'user_type' => 'user',
            'is_active' => '1'
        ]);
        User::create([
            'display_picture' => 'profileimage/test.png',
            'user_name' => 'Admin',
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'gender' => 'male',
            'email' => 'admin@test.com',
            'phone' => '123456789',
            'dob' => date('Y-m-d h:i:s'),
            'password' => Hash::make('123456'),
            'user_type' => 'admin',
            'is_active' => '1'
        ]);

        $modules = ['Users', 'Roles', 'Clients', 'Modules'];
        foreach ($modules as  $module) {
            Modules::create([
                'name' => $module,
            ]);
        }

        Role::create([
            'role_name' => 'Super Admin',
        ]);
        Role::create([
            'role_name' => 'Admin',
        ]);
        Permission::create([
            'permission_name' => 'Modules.view',
            'module_id' => 4,
        ]);
        Permission::create([
            'permission_name' => 'Modules.create',
            'module_id' => 4,
        ]);
        Permission::create([
            'permission_name' => 'Modules.update',
            'module_id' => 4,
        ]);
        Permission::create([
            'permission_name' => 'Users.view',
            'module_id' => 1,
        ]);
        Permission::create([
            'permission_name' => 'Users.create',
            'module_id' => 1,
        ]);
        Permission::create([
            'permission_name' => 'Users.update',
            'module_id' => 1,
        ]);
        Permission::create([
            'permission_name' => 'Users.delete',
            'module_id' => 1,
        ]);
        Permission::create([
            'permission_name' => 'Roles.view',
            'module_id' => 2,
        ]);
        Permission::create([
            'permission_name' => 'Roles.create',
            'module_id' => 2,
        ]);
        Permission::create([
            'permission_name' => 'Roles.update',
            'module_id' => 2,
        ]);
        Permission::create([
            'permission_name' => 'Clients.view',
            'module_id' => 3,
        ]);

        $rolePermissions = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
        foreach ($rolePermissions as  $rolePermission) {
            RolePermission::create([
                'role_id' => 1,
                'permission_id' => $rolePermission,
            ]);
        }

        UserRole::create([
            'user_id' => 1,
            'role_id' => 1,
        ]);

        $UserTypes = ['Super Admin', 'System User', 'User', 'Moderator'];
        foreach ($UserTypes as  $UserType) {
            UserType::create([
                'name' => $UserType,
            ]);
        }

        UserInType::create([
            'user_id' => 1,
            'user_type' => 1,
        ]);

        UserInType::create([
            'user_id' => 1,
            'user_type' => 2,
        ]);

        // $packages = [[
        //     'name' => 'Packages 1',
        //     'no_of_session' => '1 Session',
        //     'total_time' => '30',
        //     'session_time' => '30 Minute',
        //     'price' => '10',
        // ], [
        //     'name' => 'Packages 2',
        //     'no_of_session' => '2 Session',
        //     'total_time' => '60',
        //     'session_time' => '30 Minute',
        //     'price' => '20',
        // ]];
        // Packages::insert($packages);
    }
}
