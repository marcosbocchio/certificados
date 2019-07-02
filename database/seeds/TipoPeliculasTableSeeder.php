<?php

use Illuminate\Database\Seeder;
use App\TipoPeliculas;
class TipoPeliculasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoPeliculas::create([
            'fabricante'    =>'AGFA',
            'codigo'        =>'D3',
            'descripcion'   =>'null'           
        ]);

        TipoPeliculas::create([
            'fabricante'    =>'AGFA',
            'codigo'        =>'D4',
            'descripcion'   =>'null'           
        ]);

        TipoPeliculas::create([
            'fabricante'    =>'AGFA',
            'codigo'        =>'D5',
            'descripcion'   =>'null'           
        ]);

        TipoPeliculas::create([
            'fabricante'    =>'AGFA',
            'codigo'        =>'D7',
            'descripcion'   =>'null'           
        ]);

        TipoPeliculas::create([
            'fabricante'    =>'KODAK',
            'codigo'        =>'AT100',
            'descripcion'   =>'null'           
        ]);

        TipoPeliculas::create([
            'fabricante'    =>'KODAK',
            'codigo'        =>'AA400',
            'descripcion'   =>'null'           
        ]);

        TipoPeliculas::create([
            'fabricante'    =>'KODAK',
            'codigo'        =>'AXXX',
            'descripcion'   =>'null'           
        ]);

        TipoPeliculas::create([
            'fabricante'    =>'FOMADUK',
            'codigo'        =>'R1',
            'descripcion'   =>'null'           
        ]);

        TipoPeliculas::create([
            'fabricante'    =>'FOMADUK ',
            'codigo'        =>'R2',
            'descripcion'   =>'null'           
        ]);

        TipoPeliculas::create([
            'fabricante'    =>'FOMADUK',
            'codigo'        =>'RX',
            'descripcion'   =>'null'           
        ]);
    }
}
