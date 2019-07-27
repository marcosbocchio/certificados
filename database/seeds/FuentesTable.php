<?php

use Illuminate\Database\Seeder;
use App\Fuentes;

class FuentesTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Fuentes::create([
            'codigo'              =>'SE 75 - POLYTEC',            
             
        ]);

        Fuentes::create([
            'codigo'              =>'IR 192 - POLYTEC',          
           
        ]);

        Fuentes::create([
            'codigo'              =>'SE 75 - QSA GLOBAL',               
        ]);

        Fuentes::create([
            'codigo'              =>'IR 192 - QSA GLOBAL',
                         
        ]);
    }
}
