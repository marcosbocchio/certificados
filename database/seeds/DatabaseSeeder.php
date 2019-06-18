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

        factory('App\Clientes', 50)->create();


    }
}
