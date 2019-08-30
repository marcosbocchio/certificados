<?php

use Illuminate\Database\Seeder;
use App\ColorParticulas;

class ColorParticulasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ColorParticulas::create([

            'codigo'                =>'Negro',           
          
        ]);

        ColorParticulas::create([

            'codigo'                =>'Rojo',           
          
        ]);

        ColorParticulas::create([

            'codigo'                =>'Amarillo',           
          
        ]);

        ColorParticulas::create([

            'codigo'                =>'Amarillo Verdoso',           
          
        ]);
   
    }
}
