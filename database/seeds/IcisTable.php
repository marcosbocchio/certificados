<?php

use Illuminate\Database\Seeder;
use App\Icis;

class IcisTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Icis::create([
            'codigo'              =>'ASTM 1A',              
        ]);

        Icis::create([
            'codigo'              =>'ASTM 1B',        
        ]);

        Icis::create([
            'codigo'              =>'ASTM 1C',             
        ]);

        Icis::create([
            'codigo'              =>'ASTM 1D',                
        ]);
    }
}
