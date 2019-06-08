<?php

use Illuminate\Database\Seeder;
use App\Materiales;

class MaterialesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Materiales::create([
            'codigo'            =>'5487545',
            'descripcion'       =>'placas para radiografias',          
        ]);

        Materiales::create([
            'codigo'            =>'55555',
            'descripcion'       =>'Gel para tubos',          
        ]);
    }
}
