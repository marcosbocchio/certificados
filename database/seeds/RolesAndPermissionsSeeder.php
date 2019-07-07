<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // crear permisos
        Permission::create(['name' => 'Navegar cliente']);
        Permission::create(['name' => 'Navegar operador']);


        Permission::create(['name' => 'clientes.show']);
        Permission::create(['name' => 'clientes.edit']);
        Permission::create(['name' => 'cliente.destroy']);
        Permission::create(['name' => 'cliente.store']);
        Permission::create(['name' => 'ots.store']);
        Permission::create(['name' => 'ots.edit']);

        // creo roles y se los asigno a un permiso creado        
        $role = Role::create(['name' => 'Super Admin']);

        $role = Role::create(['name' => 'Admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'Cliente']);
        $role->givePermissionTo('Navegar cliente');

        $role = Role::create(['name' => 'Operador']);
        $role->givePermissionTo('Navegar operador');
    }
}
