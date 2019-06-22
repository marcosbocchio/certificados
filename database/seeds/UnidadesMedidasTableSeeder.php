<?php

use Illuminate\Database\Seeder;
use App\Unidades_medidas;
class UnidadesMedidasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Unidades_medidas::create([
            'codigo'            =>'Cm',
            'descripcion'       =>'Descripción para la unidad de medida cm',          
        ]);

        Unidades_medidas::create([
            'codigo'            =>'Pulgada',
            'descripcion'       =>'Descripción para la unidad de medida pulgada',          
        ]);

        Unidades_medidas::create([
            'codigo'            =>'Litro',
            'descripcion'       =>'Descripción para la unidad de medida Litro',          
        ]);
    }
}
