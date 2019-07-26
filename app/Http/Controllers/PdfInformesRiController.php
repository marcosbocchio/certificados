<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Informe;
use App\InformesRi;
use App\Ots;
use App\Clientes;
use App\Materiales;
use App\NormaEnsayos;
use App\NormaEvaluaciones;
use App\ProcedimientosInforme;
use App\Equipos;
use App\Fuentes;
use App\TipoPeliculas;
use App\DiametrosEspesor;
use App\Icis;
use App\Tecnicas;
use App\EjecutorEnsayo;
use App\User;

class PdfInformesRiController extends Controller
{

    public function inprimir($id){      

        $informe = Informe::findOrFail($id)->first();
        $informe_ri = InformesRi::where('informe_id',$informe->id)->first();        
        $ot = Ots::findOrFail($informe->ot_id)->first();
        $cliente = Clientes::findOrFail($ot->cliente_id)->first();
        $material = Materiales::findOrFail($informe_ri->material_id)->first();   
        $norma_ensayo = NormaEnsayos::findOrFail($informe_ri->norma_ensayo_id)->first();   
        $norma_evaluacion = NormaEvaluaciones::findOrFail($informe_ri->norma_evaluacion_id)->first(); 
        $procedimiento_inf = ProcedimientosInforme::findOrFail($informe_ri->procedimiento_informe_id)->first();
        $equipo = Equipos::findOrFail($informe_ri->equipo_id)->first();
        $fuente = Fuentes::findOrFail($informe_ri->fuente_id)->first();
        $tipo_pelicula = TipoPeliculas::findOrFail($informe_ri->tipo_pelicula_id)->first();
        $diametro_espesor = DiametrosEspesor::findOrFail($informe_ri->diametro_espesor_id)->first();
        $ici = Icis::findOrFail($informe_ri->ici_id)->first();
        $tecnica = Tecnicas::findOrFail($informe_ri->tecnica_id)->first();
       // $ejecutor_ensayo = User::findOrFail($informe_ri->ejecutor_ensayo_id)->first();

        $pdf = \PDF::loadView('reportes.informes.ri',compact('ot','norma_ensayo',
        'norma_evaluacion','procedimiento_inf','equipo','fuente','tipo_pelicula','diametro_espesor','ici','tecnica','ejecutor_ensayo',
                                                        'cliente','informe','informe_ri','material'));
        
        return $pdf->stream();
    }
}
