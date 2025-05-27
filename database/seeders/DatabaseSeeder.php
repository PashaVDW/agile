<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Role::firstOrCreate(['name' => 'user']);
        Role::firstOrCreate(['name' => 'admin']);

        $user = User::firstOrCreate(
            ['email' => 'admin@agile.nl'],
            [
                'name' => 'admin',
                'major' => 'SO',
                'phone' => '0612345678',
                'password' => '$2y$12$RRFILOFFad.VuxS44qX7I.mUJxb1cqlO8exnjs9oqXRGpZi0XIqJW', // pre-hashed password
            ]
        );

        if (Role::where('name', 'admin')->exists() && !$user->hasRole('admin')) {
            $user->assignRole('admin');
        }

    }
}
