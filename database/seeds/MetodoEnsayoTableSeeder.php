<?php

use Illuminate\Database\Seeder;
use App\MetodoEnsayos;

class MetodoEnsayoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MetodoEnsayos::create([
            'metodo'            =>'RI',
            'descripcion'       =>'Descripción metodo de ensayo RI',          
        ]);

        MetodoEnsayos::create([
            'metodo'            =>'EA',
            'descripcion'       =>'Descripción metodo de ensayo EA',          
        ]);

        MetodoEnsayos::create([
            'metodo'            =>'PM',
            'descripcion'       =>'Descripción metodo de ensayo PM',          
        ]);

        MetodoEnsayos::create([
            'metodo'            =>'LP',
            'descripcion'       =>'Descripción metodo de ensayo LP',          
        ]);

        MetodoEnsayos::create([
            'metodo'            =>'US',
            'descripcion'       =>'Descripción metodo de ensayo US',          
        ]);
        
        MetodoEnsayos::create([
            'metodo'            =>'II',
            'descripcion'       =>'Descripción metodo de ensayo II',          
        ]);

    }
}
