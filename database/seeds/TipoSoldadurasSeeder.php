<?php

use Illuminate\Database\Seeder;
use App\TipoSoldaduras;

class TipoSoldadurasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoSoldaduras::create([
            'codigo'        =>'LR',          
            'descripcion'   =>'Línea regular',                  
        ]);

        TipoSoldaduras::create([
            'codigo'        =>'EM',          
            'descripcion'   =>'Empalme',                  
        ]);
        
    }
}
