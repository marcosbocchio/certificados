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
use App\Documentaciones;
use App\Equipos;
use App\Fuentes;
use App\TipoPeliculas;
use App\DiametrosEspesor;
use App\Icis;
use App\Tecnicas;
use App\EjecutorEnsayo;
use App\User;
use App\TecnicasGraficos;

class PdfInformesRiController extends Controller
{

    public function inprimir($id){      

        $informe = Informe::findOrFail($id);
        $informe_ri = InformesRi::where('informe_id',$informe->id)->firstOrFail();
        $ot = Ots::findOrFail($informe->ot_id);
        $cliente = Clientes::findOrFail($ot->cliente_id);
        $material = Materiales::findOrFail($informe->material_id);   
        $norma_ensayo = NormaEnsayos::findOrFail($informe->norma_ensayo_id);   
        $norma_evaluacion = NormaEvaluaciones::findOrFail($informe->norma_evaluacion_id); 
        $procedimiento_inf = Documentaciones::findOrFail($informe->procedimiento_informe_id);
        $equipo = Equipos::findOrFail($informe->equipo_id);
        $fuente = Fuentes::find($informe_ri->fuente_id);
        $tipo_pelicula = TipoPeliculas::findOrFail($informe_ri->tipo_pelicula_id);
        $diametro_espesor = DiametrosEspesor::findOrFail($informe->diametro_espesor_id);
        $ici = Icis::findOrFail($informe_ri->ici_id);
        $tecnica = Tecnicas::findOrFail($informe->tecnica_id);
        $ejecutor_ensayo = User::findOrFail($informe->ejecutor_ensayo_id);
        $tecnicas_grafico = TecnicasGraficos::findOrFail($informe_ri->tecnicas_grafico_id);
        
      
        
        $pdf = \PDF::loadView('reportes.informes.ri-test',compact('ot',
                                                             'norma_ensayo',
                                                             'norma_evaluacion',
                                                             'procedimiento_inf',
                                                             'equipo',
                                                             'fuente',
                                                             'tipo_pelicula',
                                                             'diametro_espesor',
                                                             'ici',
                                                             'tecnica',
                                                             'ejecutor_ensayo',
                                                             'cliente',
                                                             'informe',
                                                             'informe_ri',
                                                             'material',
                                                             'tecnicas_grafico'));
        
        return $pdf->stream();
    }
}
