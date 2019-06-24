<?php

use Illuminate\Database\Seeder;
use App\NormaEvaluaciones;
class NormaEvaluacionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NormaEvaluaciones::create([
            'codigo'            =>'1',
            'descripcion'       =>'ASME B31.8/API 1104',          
        ]);
    }
}
