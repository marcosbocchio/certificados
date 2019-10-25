<?php

use Illuminate\Database\Seeder;
use App\TipoLiquidos;
class TipoLiquidosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoLiquidosTableSeeder::create([
            'tipo'                =>'AGUA',
            'marca'               =>'marca x',          
            'penetrante_sn'       =>'1',
            'revelador_sn'        =>'0',
            'removedor_sn'        =>'0',                
        ]);
    }
}
