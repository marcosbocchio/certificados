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
        $this->call(DiametrosEspesorTableSeeder::class);
        $this->call(MaterialesTableSeeder::class);
        $this->call(MetodoEnsayoTableSeeder::class);
        $this->call(UnidadesMedidasTableSeeder::class);
        $this->call(ClientesTableSeeder::class);
        $this->call(ContactosTableSeeder::class);
        $this->call(ServiciosTableSeeder::class);
        $this->call(NormaEnsayosTableSeeder::class);
        $this->call(NormaEvaluacionesTableSeeder::class);
        $this->call(ProductoTableSeeder::class);
        $this->call(EppsTableSeeder::class);
        $this->call(RiesgosTableSeeder::class);
        $this->call(MedidasTableSeeder::class);
        $this->call(TipoPeliculasTableSeeder::class);
        $this->call(TecnicasTable::class);
        $this->call(FuentesTable::class);     
        $this->call(IcisTable::class);      
        $this->call(EquiposTableSeeder::class);     
        $this->call(TecnicasGraficoSeeder::class);    
        
       
       // factory('App\Clientes', 2500)->create();


    }
}
