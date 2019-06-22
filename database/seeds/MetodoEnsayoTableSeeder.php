<?php

use Illuminate\Database\Seeder;
use App\Metodo_ensayos;

class MetodoEnsayoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Metodo_ensayos::create([
            'metodo'            =>'RI',
            'descripcion'       =>'Descripción metodo de ensayo RI',          
        ]);

        Metodo_ensayos::create([
            'metodo'            =>'EA',
            'descripcion'       =>'Descripción metodo de ensayo EA',          
        ]);
    }
}
