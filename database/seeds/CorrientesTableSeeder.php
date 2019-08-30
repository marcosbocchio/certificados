<?php

use Illuminate\Database\Seeder;
use App\Corrientes;

class CorrientesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Corrientes::create([

            'codigo'                =>'CC',
            'fuerza_portante'       =>'22.5',  
          
        ]);

        Corrientes::create([

            'codigo'                =>'CA',
            'fuerza_portante'       =>'4.5',  
          
        ]);
    }
}
