<?php

use Illuminate\Database\Seeder;
use App\Riesgos;

class RiesgosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Riesgos::create([
            'codigo'              =>'1',
            'descripcion'         =>'Espacio refinado'     
        ]);

        Riesgos::create([
            'codigo'              =>'2',
            'descripcion'         =>'Altura'     
        ]);

        Riesgos::create([
            'codigo'              =>'3',
            'descripcion'         =>'Cables Electricos'     
        ]);
    }
}
