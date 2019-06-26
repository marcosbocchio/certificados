<?php

use Illuminate\Database\Seeder;
use App\Productos;

class ProductoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Productos::create([
            'codigo'              =>'Placa 1',
            'descripcion'         =>'Placa revelada e informada por Costura',   
            'unidades_medida_id'  =>'2'     
        ]);
    }
}
