<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'Administrador')->first();

        $user = User::firstOrCreate(
            ['email' => 'peraltagendealex@gmail.com'],
            [
                'name' => 'admin',
                'last_name' => 'admin',
                'phone_number' => '+593995031599',
                'password' => bcrypt('Final123.'),
                'is_active' => true,
            ]
        );

        if ($adminRole && !$user->roles()->where('role_id', $adminRole->id)->exists()) {
            $user->roles()->attach($adminRole->id);
        }
    }
}
