<?php

use Illuminate\Database\Seeder;
Use App\Epps;

class EppsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Epps::create([
            'codigo'              =>'1',
            'descripcion'         =>'Casco'     
        ]);

        Epps::create([
            'codigo'              =>'2',
            'descripcion'         =>'Botines de seguridd'     
        ]);

        Epps::create([
            'codigo'              =>'3',
            'descripcion'         =>'Chaleco'     
        ]);

        Epps::create([
            'codigo'              =>'4',
            'descripcion'         =>'Guantes'     
        ]);
    }
}
