<?php

use Illuminate\Database\Seeder;
use App\Iluminaciones;
class IluminacionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Iluminaciones::create([ 
            'codigo'              =>'1076 Lux',              
        ]);

        Iluminaciones::create([
            'codigo'              =>'1000 µv/cm2',              
        ]);
    }
}
