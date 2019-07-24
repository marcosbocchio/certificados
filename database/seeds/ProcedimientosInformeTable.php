<?php

use Illuminate\Database\Seeder;
use App\ProcedimientosInforme;

class ProcedimientosInformeTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProcedimientosInforme::create([
            'codigo'                   =>'Proc 1',
            'descripcion'              =>'Descripcion procedimientos 1',  
            'metodo_ensayo_id'         =>'1'   
        ]);

        ProcedimientosInforme::create([
            'codigo'                   =>'Proc 2',
            'descripcion'              =>'Descripcion procedimientos 2',  
            'metodo_ensayo_id'         =>'1'   
        ]);

        ProcedimientosInforme::create([
            'codigo'                   =>'Proc 3',
            'descripcion'              =>'Descripcion procedimientos 3', 
            'metodo_ensayo_id'         =>'1'   
        ]);

     
    }
}
