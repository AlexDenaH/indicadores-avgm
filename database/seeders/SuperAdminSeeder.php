<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        /*
         |--------------------------------------------------------------------------
         | 1. ROLES BASE DEL SISTEMA
         |--------------------------------------------------------------------------
         */
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        Role::firstOrCreate(['name' => 'administrador']);
        Role::firstOrCreate(['name' => 'enlace']);
        Role::firstOrCreate(['name' => 'capturista']);

        /*
         |--------------------------------------------------------------------------
         | 2. CREACIÓN DEL USUARIO SUPER ADMIN
         |--------------------------------------------------------------------------
         */
        $user = User::firstOrCreate(
            ['email' => 'dna_a@hotmail.com'], // email único
            [
                'name'              => 'Alejandro',
                'first_last_name'   => 'Dena',
                'second_last_name'  => 'Herrera',
                'email_verified_at' => Carbon::now(), // marcado como verificado
                'password'          => Hash::make('qwer1234'),
            ]
        );

        /*
         |--------------------------------------------------------------------------
         | 3. ASIGNACIÓN DE ROL SUPER ADMIN
         |--------------------------------------------------------------------------
         */
        if (!$user->hasRole('super-admin')) {
            $user->assignRole($superAdminRole);
        }
    }
}
