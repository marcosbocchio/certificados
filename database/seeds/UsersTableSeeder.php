<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Usuario con el rol administrador

        $administrador = User::create([
            'codigo'  => 'Aco80',
            'name'     => 'Marcos Alejandro Bocchio' ,
            'email'    => 'marcosbocchio@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        $administrador->assignRole('Administrador');


        // Usuario con el rol operador

        $operador = User::create([
            'codigo'  => 'Ruso74',
            'name'     => 'Pablo Martin Bocchio' ,
            'email'    => 'pablobocchio@hotmail.com',
            'password' => bcrypt('12345678'),
        ]);

        $operador->assignRole('Operador');

        // Usuario con el rol Cliente

        $cliente = User::create([
            'codigo'  => 'Sofita',
            'name'     => 'Sofia Ailín Battafarano' ,
            'email'    => 'sofia_battafarano@hotmail.com',
            'password' => bcrypt('12345678'),
        ]);

        $cliente->assignRole('Cliente');

        $cliente = User::create([
            'name'     => 'julian' ,
            'email'    => 'julian@hotmail.com',
            'password' => bcrypt('12345678'),
        ]);

        $cliente->givePermissionTo('Navegar cliente');

        $cliente = User::create([
            'name'     => 'Karem' ,
            'email'    => 'karem@hotmail.com',
            'password' => bcrypt('12345678'),
        ]);

        $cliente->givePermissionTo('Navegar cliente');

        $cliente = User::create([
            'name'     => 'Lautaro' ,
            'email'    => 'lautaro@hotmail.com',
            'password' => bcrypt('12345678'),
        ]);

        $cliente->givePermissionTo('Navegar cliente');

        $cliente = User::create([
            'name'     => 'Oscar' ,
            'email'    => 'oscar@hotmail.com',
            'password' => bcrypt('12345678'),
        ]);

        $cliente->givePermissionTo('Navegar cliente');

        $cliente = User::create([
            'name'     => 'Marianella' ,
            'email'    => 'Marianella@hotmail.com',
            'password' => bcrypt('12345678'),
        ]);

        $cliente->givePermissionTo('Navegar cliente');
    }
}
