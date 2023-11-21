<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Categories;
use App\Models\Modules;
use App\Models\Packages;
use App\Models\Permission;
use App\Models\RentalImages;
use App\Models\Rentals;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\Tours;
use App\Models\ToursImages;
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

        Categories::create([
            'image' => 'profileimage/c1.png',
            'title' => 'ATVs',
        ]);
        Categories::create([
            'image' => 'profileimage/c2.png',
            'title' => 'Jetski',
        ]);
        Categories::create([
            'image' => 'profileimage/c3.png',
            'title' => 'Dirt Bike / Motorcycles',
        ]);
        Categories::create([
            'image' => 'profileimage/c4.png',
            'title' => 'Snow Mobile',
        ]);
        Categories::create([
            'image' => 'profileimage/c5.png',
            'title' => 'UTVs',
        ]);
        Categories::create([
            'image' => 'profileimage/c6.png',
            'title' => 'Boats',
        ]);
        Categories::create([
            'image' => 'profileimage/c7.png',
            'title' => 'Surf Boards',
        ]);
        Categories::create([
            'image' => 'profileimage/c8.png',
            'title' => 'Snow Borads / Skis',
        ]);
        Categories::create([
            'image' => 'profileimage/c9.png',
            'title' => 'RV',
        ]);
        Categories::create([
            'image' => 'profileimage/c10.png',
            'title' => 'Kayaks /Canoes',
        ]);

        Tours::create([
            'user_id' => '1',
            'locations' => 'Karachi',
            'title' => 'Kati Pahari',
            'price' => '10',
            'desc' => 'Pathan live in this area',
            'start_date' => '2023-10-01',
            'end_date' => '2023-10-10',
            'age' => '25',
            'capacity' => '50',
            'reviews' => 'Paktoons',
            'whats_include' => 'Lalas',
            'recommended' => '1',
        ]);
        Tours::create([
            'user_id' => '1',
            'locations' => 'Lahore',
            'title' => 'Hunza',
            'price' => '100',
            'desc' => 'Great place to enjoy vacations',
            'start_date' => '2023-10-11',
            'end_date' => '2023-10-20',
            'age' => '28',
            'capacity' => '100',
            'reviews' => 'Kashmiri',
            'whats_include' => 'Jahaz',
            'recommended' => '1',
        ]);

        ToursImages::create([
            'tour_id' => '1',
            'image' => 'profileimage/dt1.jpg',
        ]);
        ToursImages::create([
            'tour_id' => '1',
            'image' => 'profileimage/dt1.jpg',
        ]);

        Rentals::create([
            'user_id' => '1',
            'category_id' => '1',
            'title' => 'Yamaha Jet Ski',
            'price' => '100',
            'price_type' => 'cash',
            'locations' => 'Karachi',
            'desc' => 'Comfortable Bike',
            'capacity' => '2',
            'skills' => 'advanced',
            'cancel_days' => '2',
            'cancel_percent' => '80%',
        ]);
        Rentals::create([
            'user_id' => '1',
            'category_id' => '1',
            'title' => 'Yamaha Dirt Bike',
            'price' => '200',
            'price_type' => 'cash',
            'locations' => 'Lahore',
            'desc' => 'Heavy Bike',
            'capacity' => '2',
            'skills' => 'advanced',
            'cancel_days' => '2',
            'cancel_percent' => '80%',
        ]);

        RentalImages::create([
            'rental_id' => '1',
            'image' => 'profileimage/dt1.jpg',
        ]);
        RentalImages::create([
            'rental_id' => '1',
            'image' => 'profileimage/dt1.jpg',
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
    }
}
