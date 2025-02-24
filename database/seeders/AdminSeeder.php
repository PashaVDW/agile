<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'password' => bcrypt('password123'),
            ]
        );

        // Assign the admin role to the user
        if (! $admin->hasRole('admin')) {
            $admin->assignRole($adminRole);
        }
    }
}
