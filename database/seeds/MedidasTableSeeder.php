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
            'codigo'            =>'1',
            'descripcion'       =>'20',
            'unidades_medida_id' =>'1'          
        ]);

        Medidas::create([
            'codigo'            =>'1',
            'descripcion'       =>'30',
            'unidades_medida_id' =>'1'          
        ]);

        Medidas::create([
            'codigo'            =>'1',
            'descripcion'       =>'10',
            'unidades_medida_id' =>'1'          

        ]);Medidas::create([
            'codigo'            =>'1',
            'descripcion'       =>'60',
            'unidades_medida_id' =>'1'          
        ]);

        Medidas::create([
            'codigo'            =>'1',
            'descripcion'       =>'2',
            'unidades_medida_id' =>'2'          
        ]);

        Medidas::create([
            'codigo'            =>'1',
            'descripcion'       =>'2.5',
            'unidades_medida_id' =>'2'          
        ]);

        Medidas::create([
            'codigo'            =>'1',
            'descripcion'       =>'6.5',
            'unidades_medida_id' =>'2'          
        ]);

        Medidas::create([
            'codigo'            =>'1',
            'descripcion'       =>'15',
            'unidades_medida_id' =>'2'          
        ]);

        Medidas::create([
            'codigo'            =>'1',
            'descripcion'       =>'1',
            'unidades_medida_id' =>'3'          
        ]);

        Medidas::create([
            'codigo'            =>'1',
            'descripcion'       =>'100',
            'unidades_medida_id' =>'3'          
        ]);

        Medidas::create([
            'codigo'            =>'1',
            'descripcion'       =>'250',
            'unidades_medida_id' =>'3'          
        ]);
    }
}
