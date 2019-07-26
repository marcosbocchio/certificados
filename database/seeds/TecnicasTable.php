<?php

use Illuminate\Database\Seeder;
use App\Tecnicas;

class TecnicasTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tecnicas::create([
            'codigo'        =>'SWE/SWV',          
            'descripcion'   =>'Simple Pared/Simple Imagen',
            'path_grafico'  =>'img/tecnicas/captura1.jpg'           
        ]);

        Tecnicas::create([
            'codigo'        =>'DWE/SWV',          
            'descripcion'   =>'Doble Pared/Simple Imagen',
            'path_grafico'  =>'img/tecnicas/captura3.jpg'           
        ]);

        Tecnicas::create([
            'codigo'        =>'DWE/DWV',          
            'descripcion'   =>'Doble Pared/Doble Imagen',  
            'path_grafico'  =>'img/tecnicas/captura7.jpg'           
        ]);
    }
}
