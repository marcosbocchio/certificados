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
use \stdClass;

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
                               ->where('informes_ri.id',$id)
                               ->select('juntas.codigo as junta',
                                      'posicion.descripcion as observacion',                                   
                                      'posicion.aceptable_sn as aceptable_sn',                                     
                                      'juntas.km as pk',
                                      'posicion.codigo as posicion',
                                      'posicion.id as posicion_id',
                                      'juntas.tipo_soldadura_id')
                                ->orderBy('posicion.id','asc')
                                ->get();

      
        foreach ($informe_detalle as $detalle_posicion) {
            
            
            $defecto_posicion = DB::table('posicion')
                                            ->join('defectos_posicion','defectos_posicion.posicion_id','=','posicion.id') 
                                            ->join('defectos_ri','defectos_ri.id','=','defectos_posicion.defecto_ri_id')                                           
                                            ->where('posicion.id',$detalle_posicion->posicion_id)
                                            ->select('defectos_ri.codigo','defectos_ri.descripcion','defectos_ri.id','defectos_posicion.posicion')
                                            ->get();


            $pasadas_posicion = DB::table('informes_ri')
                                            ->join('juntas','juntas.informe_ri_id','=','informes_ri.id')
                                            ->join('posicion','posicion.junta_id','=','juntas.id')
                                            ->join('pasadas_posicion','pasadas_posicion.posicion_id','=','posicion.id')
                                            ->where('informes_ri.id',$id)
                                            ->where('juntas.codigo',$detalle_posicion->junta)
                                            ->where('posicion.codigo',$detalle_posicion->posicion)
                                            ->selectRaw('pasadas_posicion.*,IFNULL(juntas.tipo_soldadura_id,"") as tipo_soldadura_id')
                                            ->get();

            $pasadas = array();

             foreach ( $pasadas_posicion as $pasada_posicion) {          

                $obj = new stdClass();
                $obj->pasada = $pasada_posicion->numero ;

                $obj->soldador1 = DB::table('soldadores')
                                            ->join('ot_soldadores','ot_soldadores.soldadores_id','=','soldadores.id')  
                                            ->where('ot_soldadores.id',$pasada_posicion->soldadorz_id)
                                            ->select('soldadores.codigo','soldadores.nombre','ot_soldadores.*')
                                            ->first();

                $obj->soldador2 = DB::table('soldadores')
                                            ->join('ot_soldadores','ot_soldadores.soldadores_id','=','soldadores.id')  
                                            ->where('ot_soldadores.id',$pasada_posicion->soldadorl_id)
                                            ->select('soldadores.codigo','soldadores.nombre','ot_soldadores.*')
                                            ->first();
                                            
                $obj->soldador2 =   $obj->soldador2 ? $obj->soldador2 : "";    

                $obj->soldador3 = DB::table('soldadores')
                                            ->join('ot_soldadores','ot_soldadores.soldadores_id','=','soldadores.id')  
                                            ->where('ot_soldadores.id',$pasada_posicion->soldadorp_id)
                                            ->select('soldadores.codigo','soldadores.nombre','ot_soldadores.*')
                                            ->first();
                $obj->soldador3 = $obj->soldador3 ? $obj->soldador3 : "";    

                array_push($pasadas,$obj);
             }

             
            $tipo_soldadura = TipoSoldaduras::find($detalle_posicion->tipo_soldadura_id) ? TipoSoldaduras::find($detalle_posicion->tipo_soldadura_id) : "";           
         

            $detalle_posicion->defectos = $defecto_posicion;
            $detalle_posicion->pasadas = $pasadas;       
            $detalle_posicion->tipo_soldadura = $tipo_soldadura;
          
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
