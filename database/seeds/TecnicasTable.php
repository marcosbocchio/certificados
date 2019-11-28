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
            'metodo_ensayo_id'  =>'1'                
        ]);

        Tecnicas::create([
            'codigo'        =>'DWE/SWV',          
            'descripcion'   =>'Doble Pared/Simple Imagen',   
            'metodo_ensayo_id'  =>'1'                          
        ]);

        Tecnicas::create([
            'codigo'        =>'DWE/DWV',          
            'descripcion'   =>'Doble Pared/Doble Imagen',      
            'metodo_ensayo_id'  =>'1'                 
        ]);

        Tecnicas::create([
            'codigo'        =>'Y',          
            'descripcion'   =>'Yugo',      
            'metodo_ensayo_id'  =>'3'                 
        ]);

        Tecnicas::create([
            'codigo'        =>'PC',          
            'descripcion'   =>'Puntas de contacto',      
            'metodo_ensayo_id'  =>'3'                 
        ]);

        Tecnicas::create([
            'codigo'        =>'B',          
            'descripcion'   =>'Bobina',      
            'metodo_ensayo_id'  =>'3'                 
        ]);

        Tecnicas::create([
            'codigo'        =>'CC',          
            'descripcion'   =>'Conducto Central',      
            'metodo_ensayo_id'  =>'3'                 
        ]);

        Tecnicas::create([
            'codigo'        =>'R',          
            'descripcion'   =>'Residual',      
            'metodo_ensayo_id'  =>'3'                 
        ]);

        Tecnicas::create([
            'codigo'        =>'US',          
            'descripcion'   =>'US convencional',      
            'metodo_ensayo_id'  =>'5'                 
        ]);

        Tecnicas::create([
            'codigo'        =>'PA',          
            'descripcion'   =>'Phased array',      
            'metodo_ensayo_id'  =>'5'                 
        ]);

        Tecnicas::create([
            'codigo'        =>'ME',          
            'descripcion'   =>'Medición de Espesores',      
            'metodo_ensayo_id'  =>'5'                 
        ]);
    }
}
