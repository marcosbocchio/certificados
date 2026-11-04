<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class CreatePermisoOTodasLasOts extends Migration
{
    public function up()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permiso = Permission::firstOrCreate(['name' => 'O_todas_las_ots', 'guard_name' => 'web']);
        $rol = Role::firstOrCreate(['name' => 'Ve-todas-las-OT', 'guard_name' => 'web']);

        if (!$rol->hasPermissionTo($permiso)) {
            $rol->givePermissionTo($permiso);
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }

    public function down()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Role::where('name', 'Ve-todas-las-OT')->where('guard_name', 'web')->delete();
        Permission::where('name', 'O_todas_las_ots')->where('guard_name', 'web')->delete();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
