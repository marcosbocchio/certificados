<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(EspesorTubosTableSeeder::class);
        $this->call(MaterialesTableSeeder::class);
        $this->call(MetodoEnsayoTableSeeder::class);
        $this->call(UnidadesMedidasTableSeeder::class);
        $this->call(ClientesTableSeeder::class);
        $this->call(ContactosTableSeeder::class);
        $this->call(ServiciosTableSeeder::class);


       // factory('App\Clientes', 50)->create();


    }
}
