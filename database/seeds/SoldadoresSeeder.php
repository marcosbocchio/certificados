<?php

use Illuminate\Database\Seeder;
use App\Soldadores;

class SoldadoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Soldadores::create([
            'cliente_id'   =>'1',                  
            'codigo'       =>'229',
            'nombre'       =>'Soldador 1'   
        ]);

        Soldadores::create([
            'cliente_id'   =>'1',                  
            'codigo'       =>'232',
            'nombre'       =>'Soldador 2'   
        ]);


        Soldadores::create([
            'cliente_id'   =>'1',                  
            'codigo'       =>'244',
            'nombre'       =>'Soldador 3'   
        ]);

        Soldadores::create([
            'cliente_id'   =>'1',                  
            'codigo'       =>'233',
            'nombre'       =>'Soldador 4'   
        ]);

        Soldadores::create([
            'cliente_id'   =>'2',                  
            'codigo'       =>'158',
            'nombre'       =>'Soldador 5'   
        ]);

        Soldadores::create([
            'cliente_id'   =>'2',                  
            'codigo'       =>'162',
            'nombre'       =>'Soldador 6'   
        ]);

        Soldadores::create([
            'cliente_id'   =>'2',                  
            'codigo'       =>'166',
            'nombre'       =>'Soldador 7'   
        ]);

        Soldadores::create([
            'cliente_id'   =>'2',                  
            'codigo'       =>'199',
            'nombre'       =>'Soldador 8'   
        ]);
    }
}
