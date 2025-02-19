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

        Role::create(['name' => 'user']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'owner']);

        $user = new User;
        $user->name = 'Admin';
        $user->email = 'admin@agile.nl';
        $user->password = '$2y$12$RRFILOFFad.VuxS44qX7I.mUJxb1cqlO8exnjs9oqXRGpZi0XIqJW';
        $user->save();
        $user->assignRole('admin');
    }
}
