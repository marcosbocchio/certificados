<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Partes;
use App\Ots;
use App\Clientes;

class PdfPartesController extends Controller
{
 

    public function imprimir($id,$estado){ 
    
        
        $parte = Partes::find($id)->first();             
        $ot = Ots::find($parte->ot_id);   
        $cliente = Clientes::find($ot->cliente_id);   
        $responsables = DB::table('parte_operadores')
                          ->join('users','users.id','=','parte_operadores.user_id')
                          ->where('parte_operadores.parte_id',$id)
                          ->select('users.name as nombre','parte_operadores.responsabilidad')
                          ->get();     
        
    //    dd($responsables);
        $parte_detalle = DB::select('CALL ParteDetalle(?,?)',array($id,$estado));
      //  dd($parte_detalle);
        

            $pdf = \PDF::loadView('reportes.partes.parte',compact('ot',
                                                                'cliente', 
                                                                'parte',
                                                                'responsables',
                                                                'parte_detalle'                                                              
                                                                    ))->setPaper('a4','portrait')->setWarnings(false);
            return $pdf->stream();        
    
    
    }
}

