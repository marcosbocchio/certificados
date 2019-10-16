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
        $metodos_informe = DB::table('metodo_ensayos') 
                        ->join('informes','metodo_ensayos.id','=','informes.metodo_ensayo_id')  
                        ->join('parte_detalles','parte_detalles.informe_id','=','informes.id')
                        ->where('parte_detalles.parte_id',$id)
                        ->selectRaw('metodo_ensayos.metodo as metodo,CONCAT(metodo_ensayos.metodo,LPAD(informes.numero, 3, "0")) as numero_formateado')
                        ->groupBy('metodo','numero_formateado')
                        ->orderBy('numero_formateado','ASC')
                        ->get();

         $informes_detalle = DB::table('metodo_ensayos')
                        ->join('informes','metodo_ensayos.id','=','informes.metodo_ensayo_id')  
                        ->join('parte_detalles','parte_detalles.informe_id','=','informes.id')
                        ->where('parte_detalles.parte_id',$id)
                        ->selectRaw('metodo_ensayos.metodo as metodo,informes.id as informe_id,CONCAT(metodo_ensayos.metodo,LPAD(informes.numero, 3, "0")) as numero_formateado')
                        ->groupBy('informes.id','metodo','numero_formateado')                      
                        ->get();

        //    dd($metodos_informe);    

        $pdf = \PDF::loadView('reportes.partes.parte',compact('ot',
                                                            'cliente', 
                                                            'parte',
                                                            'metodos_informe',
                                                            'informes_detalle',
                                                            'responsables',
                                                            'parte_detalle'                                                              
                                                                ))->setPaper('a4','portrait')->setWarnings(false);
        return $pdf->stream();        
    
    
    }
}

