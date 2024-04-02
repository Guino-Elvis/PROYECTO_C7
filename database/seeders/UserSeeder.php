<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder

{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Yujra Vargas Guino Elvis',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
        ]);

        $user = User::where('email', 'admin@gmail.com')->first();
        $listaRoles = Role::where('name', 'Administrador')->first()->id;
        $user->roles()->sync($listaRoles);
    }
}
