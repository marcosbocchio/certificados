<?php

use Illuminate\Database\Seeder;
use App\TiposMagnetizacion;

class TiposMagnetizacionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TiposMagnetizacion::create([
            'codigo'    =>'Circular',         
        ]);

        TiposMagnetizacion::create([
            'codigo'    =>'Longitudinal',         
        ]);

        TiposMagnetizacion::create([
            'codigo'    =>'Directo',         
        ]);
    }
}
