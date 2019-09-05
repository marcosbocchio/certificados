<?php

use Illuminate\Database\Seeder;
use App\Servicios;
class ServiciosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Servicios::create([
            'codigo'             =>'codigo 1',
            'descripcion'        =>'Servicio diario de equipo externo de Gammagrafia indrustrial',
            'unidades_medida_id' =>'1',
            'metodo_ensayo_id'   =>'1'          
        ]);

        Servicios::create([
            'codigo'             =>'codigo 2',
            'descripcion'        =>'Servicio diario de equipo interno de Gammagrafia (Crawler)',
            'unidades_medida_id' =>'2',
            'metodo_ensayo_id'   =>'1'          
        ]);

        Servicios::create([
            'codigo'             =>'codigo 3',
            'descripcion'        =>'Servicio testing 3',
            'unidades_medida_id' =>'1',
            'metodo_ensayo_id'   =>'3'          
        ]);

        Servicios::create([
            'codigo'             =>'codigo 4',
            'descripcion'        =>'Servicio testing 4',
            'unidades_medida_id' =>'1',
            'metodo_ensayo_id'   =>'2'          
        ]);


    }
}
