<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        // Resetear caché de roles y permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Definir todos los permisos según tu lista
        $permisos = [
            'ver-usuario', 'crear-usuario', 'editar-usuario', 'borrar-usuario',
            'ver-rol', 'crear-rol', 'editar-rol', 'borrar-rol',
            'actualizar-datos', 
            'ver-admin-programa', 'crear-admin-programa', 'editar-admin-programa', 'borrar-admin-programa',
            'ver-enlaces-prog-ind', 'crear-enlaces-prog-ind', 'editar-enlaces-prog-ind', 'borrar-enlaces-prog-ind',
            'ver-periodo-prog-ind', 'crear-periodo-prog-ind', 'editar-periodo-prog-ind', 'borrar-periodo-prog-ind'
        ];

        foreach ($permisos as $permiso) {
            Permission::create(['name' => $permiso]);
        }

        // 2. Crear Roles y asignar permisos específicos
        
        // SUPER-ADMIN: Todo lo puede, incluido borrar
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $superAdmin->givePermissionTo(Permission::all());

        // ADMINISTRADOR: Crea enlaces/capturistas, programa periodos, edita pero no borra usuarios raíz
        $admin = Role::firstOrCreate(['name' => 'administrador']);
        $admin->givePermissionTo([
            'ver-usuario', 'crear-usuario', 'editar-usuario',
            'ver-admin-programa', 'crear-admin-programa', 'editar-admin-programa',
            'ver-periodo-prog-ind', 'crear-periodo-prog-ind', 'editar-periodo-prog-ind'
        ]);


    }
}
