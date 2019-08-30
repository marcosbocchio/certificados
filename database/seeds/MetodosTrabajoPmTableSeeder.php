<?php

use Illuminate\Database\Seeder;
use App\MetodosTrabajoPm;
class MetodosTrabajoPmTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MetodosTrabajoPm::create([
            'codigo'                             =>'Húmedo-Visible',
            'requiere_vehiculo_aditivo_sn'       =>'1',   
            'concentracion_min'                  =>'1.2',
            'concentracion_max'                  =>'2.4'               
        ]);

        MetodosTrabajoPm::create([
            'codigo'                             =>'Húmedo-Fluorescente',
            'requiere_vehiculo_aditivo_sn'       =>'1',   
            'concentracion_min'                  =>'0.1',
            'concentracion_max'                  =>'0.4'               
        ]);

        MetodosTrabajoPm::create([
            'codigo'                             =>'Seco-Visible',
            'requiere_vehiculo_aditivo_sn'       =>'0',   
            'concentracion_min'                  =>'1.2',
            'concentracion_max'                  =>'2.4'                 
        ]);

        MetodosTrabajoPm::create([
            'codigo'                             =>'Seco- Fluorescente',
            'requiere_vehiculo_aditivo_sn'       =>'0',   
            'concentracion_min'                  =>'0.1',
            'concentracion_max'                  =>'0.4'                
        ]);
    }
}
