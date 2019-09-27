<?php

use Illuminate\Database\Seeder;
use App\UnidadesMedidas;
class UnidadesMedidasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UnidadesMedidas::create([
            'codigo'            =>'Cm',
            'descripcion'       =>'Descripción para la unidad de medida cm',          
        ]);

        UnidadesMedidas::create([
            'codigo'            =>'"',
            'descripcion'       =>'Descripción para la unidad de medida pulgada',          
        ]);

        UnidadesMedidas::create([
            'codigo'            =>'Lts',
            'descripcion'       =>'Descripción para la unidad de medida Litro',          
        ]);
    }
}
