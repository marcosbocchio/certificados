<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ots;
use Illuminate\Support\Facades\DB;
use App\Informe;
use App\InformesView;
use App\InformesRev;
use App\MetodoEnsayos;
use App\DiametrosEspesor;
use Illuminate\Support\Facades\Auth;
use App\OtProcedimientosPropios;
use App\InformesImportados;
use \stdClass;
use Illuminate\Support\Facades\Log;
use Exception as Exception;
use PhpParser\Node\Stmt\Else_;

class InformesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role_or_permission:Sistemas|T_informes_acceder'],['only' => ['index']]);
    }

    public function index($id)
    {
        $header_titulo = "Informes";
        $header_descripcion ="Alta | Modificación";
        $user = auth()->user();

        $ot = Ots::where('id',$id)->with('cliente')->first();
        $header_sub_titulo =' / ' .$ot->cliente->nombre_fantasia . ' / OT N°: ' . $ot->numero;

        $ot_metodos_ensayos = DB::table('ots')
                                   ->join('ot_servicios','ot_servicios.ot_id','=','ots.id')
                                   ->join('servicios','servicios.id','=','ot_servicios.servicio_id')
                                   ->join('metodo_ensayos','metodo_ensayos.id','=','servicios.metodo_ensayo_id')
                                   ->where('ots.id',$id)
                                   ->select('metodo_ensayos.*')
                                   ->distinct()
                                   ->get();

        $usuario_metodos = (new \App\Http\Controllers\UserController)->getUsuarioMetodos($user->id);


        return view('ot-informes.index',compact('ot',
                                        'ot_metodos_ensayos',
                                        'user',
                                        'usuario_metodos',
                                        'header_titulo',
                                        'header_sub_titulo',
                                        'header_descripcion'));

    }

    public function paginate(Request $request,$id){

        $filtro = $request->search;
        return InformesView::where('ot_id',$id)
                            ->Filtro($filtro)
                            ->orderBy('fecha','DESC')
                            ->orderBy('id','DESC')
                            ->paginate(10);

    }

    public function OtInformesTotal($ot_id){

        return InformesView::where('ot_id',$ot_id)->count();

    }

    public function create($ot_id,$metodo){


        switch ($metodo) {

            case 'RI':
                return redirect()->route('InformeRiCreate',array('ot_id' => $ot_id));
                break;

            case 'PM':
                return redirect()->route('InformePmCreate',array('ot_id' => $ot_id));
                break;

            case 'LP':
                return redirect()->route('InformeLpCreate',array('ot_id' => $ot_id));
                break;

            case 'US':
                return redirect()->route('InformeUsCreate',array('ot_id' => $ot_id));
                break;

        }

    }

    public function edit($ot_id,$id) {

        $metodo_ensayo = DB::table('informes')
                ->join('metodo_ensayos','metodo_ensayos.id','=','informes.metodo_ensayo_id')
                ->where('informes.id',$id)
                ->where('informes.ot_id',$ot_id)
                ->select('metodo_ensayos.*')
                ->first();

        switch ($metodo_ensayo->metodo) {

            case 'RI':
                return redirect()->route('InformeRiEdit',array('ot_id' => $ot_id, 'id' => $id));
                break;

            case 'PM':
                return redirect()->route('InformePmEdit',array('ot_id' => $ot_id, 'id' => $id));
                break;

            case 'LP':
                return redirect()->route('InformeLpEdit',array('ot_id' => $ot_id, 'id' => $id));
                break;

            case 'US':
                return redirect()->route('InformeUsEdit',array('ot_id' => $ot_id, 'id' => $id));
                break;
        }
    }

    public function GenerarNumeroInforme($ot_id,$metodo){

        $metodo_ensayo = MetodoEnsayos::where('metodo',$metodo)->first();

        if ($metodo_ensayo->importable_sn){

            $numero_informe = DB::table('informes_importados')
                                ->join('metodo_ensayos','metodo_ensayos.id','=','informes_importados.metodo_ensayo_id')
                                ->where('informes_importados.ot_id',$ot_id)
                                ->where('metodo_ensayos.metodo',$metodo)
                                ->orderBy('informes_importados.numero', 'DESC')
                                ->limit(1)
                                ->selectRaw('informes_importados.numero + 1 as numero_informe')
                                ->get();

        }else{

            $numero_informe = DB::table('informes')
                                ->join('metodo_ensayos','metodo_ensayos.id','=','informes.metodo_ensayo_id')
                                ->where('informes.ot_id',$ot_id)
                                ->where('metodo_ensayos.metodo',$metodo)
                                ->orderBy('informes.numero', 'DESC')
                                ->limit(1)
                                ->selectRaw('informes.numero + 1 as numero_informe')
                                ->get();
        }

        if (count($numero_informe) > 0){

            return $numero_informe[0]->numero_informe;

        }else{

            return 1;
        }

    }

    public function saveInforme($request,$informe,$EsRevision = false){

        DB::enableQueryLog();

        $user_id = null;

        if (Auth::check())
        {
            $user_id = Auth::id();
        }

        $metodo_ensayo = MetodoEnsayos::where('metodo',$request->metodo_ensayo)->first();

        $informe->ot_id  = $request->ot['id'];
        $informe->obra = $request->obra;

        $informe->espesor_especifico = null;
        $informe->diametro_especifico = null;

        if(!isset($request->procedimiento['ot_procedimientos_propios_id'])){

        $ot_procedimieto_propio = new OtProcedimientosPropios;
        (new \App\Http\Controllers\OtProcedimientosPropiosController)->store($request->procedimiento['id'],$ot_procedimieto_propio,$request->ot['id']);
        $informe->procedimiento_informe_id = $ot_procedimieto_propio->id;

        }else{

            $informe->procedimiento_informe_id = $request->procedimiento['ot_procedimientos_propios_id'];
        }

        if (($request->diametro['diametro'] =='CHAPA') || ($request->diametro['diametro'] =='VARIOS')){

          $diametro_espesor = DiametrosEspesor::where('diametro',$request->diametro['diametro'])
                                              ->first();

          $informe->diametro_espesor_id = $diametro_espesor['id'];


        }else{

            if (!isset($request->diametro['id'])){

                $informe->diametro_especifico = $request->diametro['diametro'];
            }

            if(!isset($request->espesor['id'])){

                // Esta linea la pongo por un problema con vue que cuando edito un espesor no me lo convierte en objeto.
                $informe->espesor_especifico = isset($request->espesor['espesor']) ? $request->espesor['espesor'] : $request->espesor ;

                $diametro_espesor = DiametrosEspesor::where('diametro',$request->diametro['diametro'])
                                                      ->first();
            }else {
                $diametro_espesor = DiametrosEspesor::where('diametro',$request->diametro['diametro'])
                                                    ->where('espesor',$request->espesor['espesor'])
                                                    ->first();
            }

            $informe->diametro_espesor_id = $diametro_espesor['id'];

        }

        $informe->espesor_chapa = $request->espesor_chapa;
        $informe->interno_equipo_id = $request->interno_equipo['id'];
        $informe->metodo_ensayo_id  = $metodo_ensayo['id'];
        $informe->norma_evaluacion_id = $request->norma_evaluacion['id'];
        $informe->norma_ensayo_id = $request->norma_ensayo['id'];
        $informe->tecnica_id = $request->tecnica['id'];
        $informe->ejecutor_ensayo_id = $request->ejecutor_ensayo['ot_operario_id'];
        $informe->material_id = $request->material['id'];
        $informe->material2_id = $request->material2 ? $request->material2['id'] : null;
        $informe->material2_tipo = $request->material2 ? $request->material2_tipo : null;
        $informe->fecha = date('Y-m-d',strtotime($request->fecha));
        $informe->km = $request->pk;
        $informe->ot_tipo_soldadura_id = $request->ot_tipo_soldadura ? $request->ot_tipo_soldadura['id'] : null;
        $informe->componente = $request->componente;
        $informe->linea = $request->linea;
        $informe->plano_isom = $request->plano_isom;
        $informe->hoja = $request->hoja;
        $informe->observaciones = $request->observaciones;

        if($request->isMethod('post')){

            $informe->numero = $this->GenerarNumeroInforme($request->ot['id'],$request->metodo_ensayo);

        }else{

            $informe->numero = $request->numero_inf;

        }

        if(isset($request->numero_offline)){

            $informe->numero_offline = $request->numero_offline;

        }


        if($request->isMethod('post') || ($EsRevision)){

            $informe->user_id = $user_id;
            $res = $this->getUltimaRevision($informe->ot_id,$informe->metodo_ensayo_id,$informe->numero);
            $revision_ant = $res[0]->valor;
            $informe->revision = (int)$revision_ant + 1 ;

         }

         if( $EsRevision){

              informe::where('ot_id',$informe->ot_id)
                       ->where('metodo_ensayo_id',$informe->metodo_ensayo_id)
                       ->where('numero',$informe->numero)
                       ->update(['ultima_revision_sn'=>0]);

              $informe->ultima_revision_sn = 1;

         }


        $informe->save();

        (new \App\Http\Controllers\InformeModelos3dController)->store($informe->id,$request->TablaModelos3d);

         return $informe;
      }

     public function OtInformesPendienteParteDiario($ot_id){

        $informes = DB::select('CALL InformesPendientesSinParteDiario(?,?)',array($ot_id,0));

        return $informes;

     }

     public function OtInformesPendienteEditableParteDiario($ot_id,$parte_id){

        $infomes_pendientes = DB::select('CALL InformesPendientesSinParteDiario(?,?)',array($ot_id,$parte_id));

        return $infomes_pendientes;
     }


     public function setParteId($parte_id,$informe_id){

        $informe  = Informe::find($informe_id);
        $informe->parte_id = $parte_id;
        $informe->save();
     }

     public function deleteParteId($parte_id){

        $informes  = Informe::where('parte_id',$parte_id)->get();
        foreach ($informes as $informe) {
            $informe->parte_id = null;
            $informe->save();
        }

        $informes_importados  = InformesImportados::where('parte_id',$parte_id)->get();
        foreach ($informes_importados as $informe) {
            $informe->parte_id = null;
            $informe->save();
        }

     }

    public function firmar($id){

        $user_id = null;

        if (Auth::check())
        {
             $user_id = $userId = Auth::id();
        }

        $informe = Informe::findOrFail($id);
        $informe->firma =  $user_id;
        $informe->save();

        return $informe;

    }

    public function clonar($id){

        $user_id = null;

        if (Auth::check())
        {
             $user_id = $userId = Auth::id();
        }

        $clonar = DB::select('CALL ClonarInforme(?,?)',array($id,$user_id));

        return $clonar;

    }

    public function getObraInforme($informe_id,$importado_sn){


       $valor = DB::select('CALL getObraInforme(?,?)',array($informe_id,$importado_sn));

       return $valor[0]->obra;

    }

    public function getInformesEstadisticasSoldaduras($ot_id,$obra,$componente,$fecha_desde,$fecha_hasta){

        if($obra == 'null'){
            $obra = '';
        }

        if($componente == 'null'){
            $componente = '';
        }

        if($fecha_desde == 'null'){
            $fecha_desde =  date('2000-01-01');
        }

        if($fecha_hasta == 'null'){
            $fecha_hasta =  date('2100-01-01');
        }

        $obra = str_replace('--','/',$obra);
        $componente = str_replace('--','/',$componente);
        $informes =  InformesView:: where('metodo','RI')
                            ->where('ot_id',$ot_id)
                            ->whereRaw("componente LIKE '%" . $componente . "%'")
                            ->Obra($obra)
                            ->where('importable_sn',0)
                            ->whereBetween('fecha',[$fecha_desde,$fecha_hasta])
                            ->get();
        return $informes;

    }

    public function EstaFirmada($informe_id){

        $informe  = Informe::find($informe_id);

        if ($informe->firma) {

          return true ;

        }else{

           return false ;
        }

    }

    public function getMetodoEnsayo($informe_id){

        $informe  = Informe::find($informe_id);
        $metodo = MetodoEnsayos::find($informe->metodo_ensayo_id);

        return $metodo;

    }

    /*
        Función llamada desde el update de los distintos informes, verifica si está firmado, si lo está
        guarda la revisión del mismo.
    */
    public function EsRevision($informe_id){

        $EsRevision = $this->EstaFirmada($informe_id);

        return $EsRevision;

    }


    public function getUltimaRevision($ot_id,$metodo_ensayo_id,$numero){

        return  DB::select('select getUltimaRevision(?,?,?) as valor',array($ot_id,$metodo_ensayo_id,$numero));

    }

    public function getInformeRevisiones($ot_id,$metodo,$numero){

        return informe::join('metodo_ensayos','metodo_ensayos.id','=','informes.metodo_ensayo_id')
                        ->join('users','users.id','=','informes.user_id')
                        ->where('informes.ot_id',$ot_id)
                        ->where('metodo_ensayos.metodo',$metodo)
                        ->where('informes.numero',$numero)
                        ->where('ultima_revision_sn',0)
                        ->selectRaw('informes.fecha,users.name,LPAD(informes.revision, 2, 0) as revision,informes.id')
                        ->paginate(10);

    }

}
