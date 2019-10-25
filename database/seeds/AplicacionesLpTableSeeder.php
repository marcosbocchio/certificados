<?php

use Illuminate\Database\Seeder;
use App\AplicacionesLp;
class AplicacionesLpTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AplicacionesLp::create([

            'codigo'              =>'AEROSOL',                 
        ]);

        AplicacionesLp::create([

            'codigo'              =>'PINCEL',                 
        ]);

        AplicacionesLp::create([

            'codigo'              =>'INMERSION',                 
        ]);

        AplicacionesLp::create([

            'codigo'              =>'PULVERIZADO',                 
        ]);
    }
}
