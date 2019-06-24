<?php

use Illuminate\Database\Seeder;
use App\NormaEnsayos;
class NormaEnsayosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NormaEnsayos::create([
            'codigo'            =>'1',
            'descripcion'       =>'ASME B31.8/API 1104',          
        ]);

    }
}
