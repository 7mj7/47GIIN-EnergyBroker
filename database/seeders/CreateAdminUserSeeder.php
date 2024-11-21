<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Crear rol de administrador
        //$adminRole = Role::create(['name' => 'admin']);

        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // bcrypt('password'),
        ]);

        // Asignar rol de administrador
        // $admin->assignRole($adminRole);
    }
}
