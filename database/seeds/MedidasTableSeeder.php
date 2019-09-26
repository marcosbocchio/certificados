<?php

use Illuminate\Database\Seeder;
use App\Medidas;

class MedidasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Medidas::create([
            'codigo'            =>'20',
            'descripcion'       =>'',
            'unidades_medida_id' =>'1'          
        ]);

        Medidas::create([
            'codigo'            =>'30',
            'descripcion'       =>'',
            'unidades_medida_id' =>'1'          
        ]);

        Medidas::create([
            'codigo'            =>'10',
            'descripcion'       =>'',
            'unidades_medida_id' =>'1'          

        ]);Medidas::create([
            'codigo'            =>'60',
            'descripcion'       =>'',
            'unidades_medida_id' =>'1'          
        ]);

        Medidas::create([
            'codigo'            =>'2',
            'descripcion'       =>'',
            'unidades_medida_id' =>'2'          
        ]);

        Medidas::create([
            'codigo'            =>'2.5',
            'descripcion'       =>'',
            'unidades_medida_id' =>'2'          
        ]);

        Medidas::create([
            'codigo'            =>'6.5',
            'descripcion'       =>'',
            'unidades_medida_id' =>'2'          
        ]);

        Medidas::create([
            'codigo'            =>'15',
            'descripcion'       =>'',
            'unidades_medida_id' =>'2'          
        ]);

        Medidas::create([
            'codigo'            =>'1',
            'descripcion'       =>'',
            'unidades_medida_id' =>'3'          
        ]);

        Medidas::create([
            'codigo'            =>'100',
            'descripcion'       =>'',
            'unidades_medida_id' =>'3'          
        ]);

        Medidas::create([
            'codigo'            =>'250',
            'descripcion'       =>'',
            'unidades_medida_id' =>'3'          
        ]);
    }
}
