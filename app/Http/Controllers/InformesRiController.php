<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection as Collection;
use App\User;
use App\Ots;
use App\Repositories\InformesRi\InformesRiRepository;
use App\Repositories\Documentaciones\DocumentacionesRepository;
use App\Http\Requests\InformeRiRequest;
use App\Informe;
use App\InformesRi;
use App\Materiales;
use App\DiametroView;
use App\DiametrosEspesor;
use App\Equipos;
use App\Fuentes;
use App\Tecnicas;
use App\TecnicasGraficos;
use App\TipoPeliculas;
use App\Icis;
use App\NormaEvaluaciones;
use App\NormaEnsayos;
use App\OtOperarios;
use App\Soldadores;
use App\TipoSoldaduras;

class InformesRiController extends Controller
{
    Protected $informesRi;

    public function __construct(InformesRiRepository $informesRiRepository)
    {
      $this->informesRi = $informesRiRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($ot_id)
    {
        $metodo = 'RI';
      //  $editmode = false;      
        $user = auth()->user()->name;
        $header_titulo = "Informe";
        $header_descripcion ="Crear";  

        $ot = Ots::findOrFail($ot_id);      

        return view('informes.ri.index', compact('ot',
                                                 'metodo',
                                                 'user',                                              
                                                 'header_titulo',
                                                 'header_descripcion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InformeRiRequest $request)
    {
        return $this->informesRi->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($ot_id,$id)
    {
        $header_titulo = "Informe";
        $header_descripcion ="Editar";  
        $metodo = 'RI';    
        $accion = 'edit';      
        $user = auth()->user()->name;
        $ot = Ots::findOrFail($ot_id);
        $informe = Informe::findOrFail($id);
        $informe_ri =InformesRi::where('informe_id',$informe->id)->first();
        $informe_material = Materiales::find($informe->material_id);
        $informe_diametroEspesor = DiametrosEspesor::find($informe->diametro_espesor_id);
        $informe_diametro = DiametroView::where('diametro',$informe_diametroEspesor->diametro)->first();
        $informe_fuente = Fuentes::find($informe_ri->fuente_id);
        if ($informe_fuente == null)
            $informe_fuente = new Fuentes();
        $informe_tecnica_grafico = (new TecnicasGraficosController)->show($informe_ri->tecnicas_grafico_id);
        $informe_equipo = Equipos::find($informe->equipo_id);
        $documetacionesRepository = new DocumentacionesRepository;
        $informe_procedimiento = (new DocumentacionesController($documetacionesRepository))->ProcedimientoInformeId($informe->procedimiento_informe_id);
        $infome_tipo_pelicula = TipoPeliculas::find($informe_ri->tipo_pelicula_id);
        $informe_ici = Icis::find($informe_ri->ici_id);
        $informe_norma_evaluacion = NormaEvaluaciones::find($informe->norma_evaluacion_id);
        $informe_norma_ensayo = NormaEnsayos::find($informe->norma_ensayo_id);
        $informe_ejecutor_ensayo =(new OtOperariosController())->getEjecutorEnsayo($informe->ejecutor_ensayo_id);
        $informe_detalle = $this->getDetalle($informe_ri->id);
     
      //  dd($informe_detalle);
        return view('informes.ri.edit', compact('ot',
                                                 'metodo',
                                                 'user',
                                                 'informe',
                                                 'informe_ri',  
                                                 'informe_material',  
                                                 'informe_diametro',
                                                 'informe_diametroEspesor',  
                                                 'informe_fuente',                                                
                                                 'informe_tecnica_grafico',
                                                 'informe_equipo',    
                                                 'informe_procedimiento',    
                                                 'infome_tipo_pelicula',                                
                                                 'informe_ici',
                                                 'informe_norma_evaluacion',
                                                 'informe_norma_ensayo',
                                                 'informe_ejecutor_ensayo',
                                                 'informe_detalle',
                                                 'header_titulo',
                                                 'header_descripcion'));
    }


    public function getDetalle($id){

        $informe_detalle = DB::table('informes_ri')
                               ->join('juntas','juntas.informe_ri_id','=','informes_ri.id')
                               ->join('posicion','posicion.junta_id','=','juntas.id')
                               ->join('pasadas_posicion','pasadas_posicion.posicion_id','=','posicion.id')
                               ->where('informes_ri.id',$id)
                               ->select('juntas.codigo as junta',
                                      'posicion.descripcion as observacion',
                                      'pasadas_posicion.numero as pasada',
                                      'pasadas_posicion.aceptable_sn as aceptable_sn',
                                      'juntas.km as pk',
                                      'posicion.codigo as posicion')
                                ->get();

      
        foreach ($informe_detalle as $detalle_posicion) {

            $pasadas_posicion = DB::table('informes_ri')
                            ->join('juntas','juntas.informe_ri_id','=','informes_ri.id')
                            ->join('posicion','posicion.junta_id','=','juntas.id')
                            ->join('pasadas_posicion','pasadas_posicion.posicion_id','=','posicion.id')
                            ->where('informes_ri.id',$id)
                            ->where('juntas.codigo',$detalle_posicion->junta)
                            ->where('posicion.codigo',$detalle_posicion->posicion)
                            ->where('pasadas_posicion.numero',$detalle_posicion->pasada)
                            ->selectRaw('pasadas_posicion.*,IFNULL(juntas.tipo_soldadura_id,"") as tipo_soldadura_id')
                            ->first();

            $defecto_pasada_posicion = DB::table('pasadas_posicion')
                                           ->join('defectos_pasadas_posicion','defectos_pasadas_posicion.pasada_posicion_id','=','pasadas_posicion.id') 
                                           ->join('defectos_ri','defectos_ri.id','=','defectos_pasadas_posicion.defecto_ri_id')
                                           ->where('pasadas_posicion.id',$pasadas_posicion->id)
                                           ->select('defectos_ri.codigo','defectos_ri.descripcion','defectos_ri.id','defectos_pasadas_posicion.posicion')
                                           ->get();

            $soldador1 = Soldadores::find($pasadas_posicion->soldadorz_id);
            $soldador2 = Soldadores::find($pasadas_posicion->soldadorl_id) ? Soldadores::find($pasadas_posicion->soldadorl_id) : "";
            $soldador3 = Soldadores::find($pasadas_posicion->soldadorp_id);
            $tipo_soldadura = $pasadas_posicion->tipo_soldadura_id ? TipoSoldaduras::find($pasadas_posicion->tipo_soldadura_id) : "" ;


            $detalle_posicion->soldador1 = $soldador1;
            $detalle_posicion->soldador2 = $soldador2;
            $detalle_posicion->soldador3 = $soldador3;
            $detalle_posicion->tipo_soldadura = $tipo_soldadura;
            $detalle_posicion->defectosPosicion = $defecto_pasada_posicion;
          
        }


        return $informe_detalle; 


    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InformeRiRequest $request, $id)
    {
        return $this->informesRi->updateInforme($request,$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
