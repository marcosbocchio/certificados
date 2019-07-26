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
            'codigo'              =>'SE 75',
            'descripcion'         =>'Fuente SE 75',
            'fabricante'          =>'POLYTEC'       
        ]);

        Fuentes::create([
            'codigo'              =>'IR 192',
            'descripcion'         =>'CaFuente IR 192',
            'fabricante'          =>'POLYTEC'       
        ]);

        Fuentes::create([
            'codigo'              =>'SE 75',
            'descripcion'         =>'Fuente SE 75',
            'fabricante'          =>'QSA GLOBAL'       
        ]);

        Fuentes::create([
            'codigo'              =>'IR 192',
            'descripcion'         =>'CaFuente IR 192',
            'fabricante'          =>'QSA GLOBAL'       
        ]);
    }
}
