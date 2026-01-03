<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run()
    {
        Role::firstOrCreate(['name' => 'super-admin']);
        Role::firstOrCreate(['name' => 'administrador']);
        Role::firstOrCreate(['name' => 'enlace-dependencia']);
        Role::firstOrCreate(['name' => 'capturista']);
    }
}
