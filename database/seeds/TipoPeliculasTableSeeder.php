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
            'codigo'        =>'D2',
            'descripcion'   =>''           
        ]);

        TipoPeliculas::create([
            'fabricante'    =>'AGFA',
            'codigo'        =>'D3',
            'descripcion'   =>''           
        ]);

        TipoPeliculas::create([
            'fabricante'    =>'AGFA',
            'codigo'        =>'D4',
            'descripcion'   =>''           
        ]);

        TipoPeliculas::create([
            'fabricante'    =>'AGFA',
            'codigo'        =>'D5',
            'descripcion'   =>''           
        ]);      

        TipoPeliculas::create([
            'fabricante'    =>'AGFA',
            'codigo'        =>'D7',
            'descripcion'   =>''           
        ]);

        TipoPeliculas::create([
            'fabricante'    =>'AGFA',
            'codigo'        =>'D8',
            'descripcion'   =>''           
        ]);

        TipoPeliculas::create([
            'fabricante'    =>'KODAK',
            'codigo'        =>'DR50',
            'descripcion'   =>''           
        ]);

        TipoPeliculas::create([
            'fabricante'    =>'KODAK',
            'codigo'        =>'M100',
            'descripcion'   =>''           
        ]);

        TipoPeliculas::create([
            'fabricante'    =>'KODAK',
            'codigo'        =>'MX125',
            'descripcion'   =>''           
        ]);

        TipoPeliculas::create([
            'fabricante'    =>'KODAK',
            'codigo'        =>'T200',
            'descripcion'   =>''           
        ]);

        TipoPeliculas::create([
            'fabricante'    =>'KODAK',
            'codigo'        =>'AA400',
            'descripcion'   =>''           
        ]);

        TipoPeliculas::create([
            'fabricante'    =>'KODAK',
            'codigo'        =>'CX',
            'descripcion'   =>''           
        ]);

        TipoPeliculas::create([
            'fabricante'    =>'FOMADUK',
            'codigo'        =>'R2',
            'descripcion'   =>''           
        ]);

        TipoPeliculas::create([
            'fabricante'    =>'FOMADUK ',
            'codigo'        =>'R3',
            'descripcion'   =>''           
        ]);

        TipoPeliculas::create([
            'fabricante'    =>'FOMADUK',
            'codigo'        =>'R4',
            'descripcion'   =>''           
        ]);

        TipoPeliculas::create([
            'fabricante'    =>'FOMADUK',
            'codigo'        =>'R5',
            'descripcion'   =>''           
        ]);

        TipoPeliculas::create([
            'fabricante'    =>'FOMADUK',
            'codigo'        =>'R7',
            'descripcion'   =>''           
        ]);

        TipoPeliculas::create([
            'fabricante'    =>'FOMADUK',
            'codigo'        =>'R8',
            'descripcion'   =>''           
        ]);
    }
}
