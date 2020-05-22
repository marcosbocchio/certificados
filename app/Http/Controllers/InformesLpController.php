<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\InformeLpRequest;
use App\Repositories\Documentaciones\DocumentacionesRepository;
use App\Ots;
use App\Informe;
use App\InformesLp;
use App\Materiales;
use App\DiametroView;
use App\DiametrosEspesor;
use App\NormaEvaluaciones;
use App\NormaEnsayos;
use App\InternoEquipos;
use App\TipoLiquidos;
use App\AplicacionesLp;
use App\DetallesLp;
use App\MetodosTrabajoLp;
use App\Iluminaciones;
use App\DetallesLpReferencias;
use App\OtTipoSoldaduras;

class InformesLpController extends Controller
{

    public function __construct()
    {
        $this->middleware('ddppi')->only('create');
        $this->middleware(['role_or_permission:Super Admin|T_informes_edita'],['only' => ['create','edit']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($ot_id)
    {
        $metodo = 'LP';    
        $user = auth()->user();
        $header_titulo = "Informe";
        $header_descripcion ="Crear";         
        $ot = Ots::findOrFail($ot_id);      

        return view('informes.lp.index', compact('ot',
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
    public function store(InformeLpRequest $request)
    {
        $informe  = new Informe;          
        $informeLp  = new InformesLp;  

        DB::beginTransaction();
        try {          
        
          $informe = (new \App\Http\Controllers\InformesController)->saveInforme($request,$informe);
          $informeLp = $this->saveinformeLp($request,$informe,$informeLp);
       
          $this->saveDetalle($request,$informeLp);
    
          DB::commit(); 
    
        } catch (Exception $e) {
    
          DB::rollback();
          throw $e;      
          
        }

        return $informe;
    }

    public function saveInformeLp($request,$informe,$informeLp){    
   
        $informeLp->informe_id = $informe->id;
        $informeLp->metodo_trabajo_lp_id = $request->metodo_trabajo_lp['id'];
        $informeLp->penetrante_tipo_liquido_id = $request->penetrante_tipo_liquido['id'];
        $informeLp->penetrante_aplicacion_lp_id = $request->penetrante_aplicacion['id'];
        $informeLp->tiempo_penetracion = $request->tiempo_penetracion;
        $informeLp->revelador_tipo_liquido_id = $request->revelador_tipo_liquido['id'];
        $informeLp->revelador_aplicacion_lp_id = $request->revelador_aplicacion['id'];
        $informeLp->removedor_tipo_liquido_id = $request->removedor_tipo_liquido['id'];
        $informeLp->removedor_aplicacion_lp_id = $request->removedor_aplicacion['id'];
        $informeLp->limpieza_previa = $request->limpieza_previa;
        $informeLp->limpieza_intermedia = $request->limpieza_intermedia;
        $informeLp->limpieza_final = $request->limpieza_final;
        $informeLp->iluminacion_id = $request->iluminacion['id'];
    
        $informeLp->save();     
        
        return $informeLp;
    
      }

    public function saveDetalle($request,$informeLp){

        foreach ($request->detalles as $detalle){    
          
          $referencia_id = $this->saveReferencia($detalle);
  
          $detalleLp  = new DetallesLp; 
          $detalleLp->informe_lp_id = $informeLp->id;
          $detalleLp->pieza = $detalle['pieza'];
          $detalleLp->cm = $detalle['cm'];
          $detalleLp->detalle = $detalle['detalle'];
          $detalleLp->aceptable_sn = $detalle['aceptable_sn'];
          $detalleLp->detalle_lp_referencia_id = $referencia_id;
          $detalleLp->save();           
  
        } 
  
      }
  
    public function saveReferencia($detalle){
   
        if (($detalle['observaciones'])||
            ($detalle['path1']) ||
            ($detalle['path2']) ||
            ($detalle['path3']) ||
            ($detalle['path4'])){
    
              $detalle_lp_referencia                     = new DetallesLpReferencias;
              $detalle_lp_referencia->descripcion        = $detalle['observaciones'];
              $detalle_lp_referencia->path1              = $detalle['path1'];
              $detalle_lp_referencia->path2              = $detalle['path2'];
              $detalle_lp_referencia->path3              = $detalle['path3'];
              $detalle_lp_referencia->path4              = $detalle['path4'];
              $detalle_lp_referencia->save();
    
              return $detalle_lp_referencia->id;
           }
           else{
              return null;
           }
    
      } 

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $metodo = 'LP';    
        $accion = 'edit';      
        $user = auth()->user();
        $ot = Ots::findOrFail($ot_id);
        $informe = Informe::findOrFail($id);
        $informe_lp =InformesLp::where('informe_id',$informe->id)->first();     
        $informe_material = Materiales::find($informe->material_id);
        $informe_material_accesorio = Materiales::find($informe->material_accesorio_id);
        $informe_diametroEspesor = DiametrosEspesor::find($informe->diametro_espesor_id);
        $informe_diametro = DiametroView::where('diametro',$informe_diametroEspesor->diametro)->first();       
        $informe_interno_equipo = internoEquipos::where('id',$informe->interno_equipo_id)->with('equipo')->first();
        $documetacionesRepository = new DocumentacionesRepository;
        $informe_procedimiento = (new DocumentacionesController($documetacionesRepository))->ProcedimientoInformeId($informe->procedimiento_informe_id);    
        $informe_norma_evaluacion = NormaEvaluaciones::find($informe->norma_evaluacion_id);
        $informe_norma_ensayo = NormaEnsayos::find($informe->norma_ensayo_id);
        $informe_ejecutor_ensayo =(new OtOperariosController())->getEjecutorEnsayo($informe->ejecutor_ensayo_id);
        $informe_metodo_trabajo_lp = MetodosTrabajoLp::where('id',$informe_lp->metodo_trabajo_lp_id)->SelectRaw('metodos_trabajo_lp.*,CONCAT(tipo,"-",metodo) as tipo_metodo')->first(); 
        $penetrante_tipo_liquido = TipoLiquidos::findOrFail($informe_lp->penetrante_tipo_liquido_id);
        $revelador_tipo_liquido  = TipoLiquidos::findOrFail($informe_lp->revelador_tipo_liquido_id);
        $removedor_tipo_liquido  = TipoLiquidos::findOrFail($informe_lp->removedor_tipo_liquido_id);
        $penetrante_aplicacion = AplicacionesLp::findOrFail($informe_lp->penetrante_aplicacion_lp_id);         
        $revelador_aplicacion  = AplicacionesLp::findOrFail($informe_lp->revelador_aplicacion_lp_id);
        $removedor_aplicacion  = AplicacionesLp::findOrFail($informe_lp->removedor_aplicacion_lp_id);   
        $informe_lp_iluminacion = Iluminaciones::find($informe_lp->iluminacion_id);
        
        if ($informe_material_accesorio == null)
             $informe_material_accesorio = new Materiales();  

        $informe_ot_tipo_soldadura = OtTipoSoldaduras::join('tipo_soldaduras','tipo_soldaduras.id','=','ot_tipo_soldaduras.tipo_soldadura_id')
        ->where('ot_tipo_soldaduras.id',$informe->ot_tipo_soldadura_id)->with('tipoSoldadura')->select('ot_tipo_soldaduras.*','tipo_soldaduras.codigo')->first();

        if ($informe_ot_tipo_soldadura == null)
              $informe_ot_tipo_soldadura = new OtTipoSoldaduras();

        $informe_detalle = $this->getDetalle($informe_lp->id);

     //   dd($informe_detalle);
        return view('informes.lp.edit', compact('ot',
                                                 'metodo',
                                                 'user',
                                                 'informe',
                                                 'informe_lp',  
                                                 'informe_material',  
                                                 'informe_material_accesorio',
                                                 'informe_diametro',
                                                 'informe_ot_tipo_soldadura',
                                                 'informe_diametroEspesor',                                                                            
                                                 'informe_tecnica_grafico',
                                                 'informe_interno_equipo',                                                   
                                                 'informe_procedimiento',                                              
                                                 'informe_norma_evaluacion',
                                                 'informe_norma_ensayo',
                                                 'informe_ejecutor_ensayo',     
                                                 'informe_metodo_trabajo_lp',   
                                                 'penetrante_tipo_liquido',
                                                 'revelador_tipo_liquido',
                                                 'removedor_tipo_liquido',
                                                 'penetrante_aplicacion',
                                                 'revelador_aplicacion',
                                                 'removedor_aplicacion',
                                                 'informe_lp_iluminacion',
                                                 'informe_detalle',
                                                 'header_titulo',
                                                 'header_descripcion'));
    }

    public function getDetalle($id){

      $informe_detalle = DB::table('detalles_lp')
                             ->leftjoin('detalles_lp_referencias','detalles_lp_referencias.id','=','detalles_lp.detalle_lp_referencia_id')                      
                             ->where('detalles_lp.informe_lp_id',$id)
                             ->selectRaw('detalles_lp.detalle as detalle,
                                        detalles_lp.cm as cm,
                                        detalles_lp.pieza as pieza,
                                        detalles_lp.aceptable_sn as aceptable_sn,
                                        detalles_lp_referencias.descripcion as observaciones,
                                        detalles_lp_referencias.path1 as path1,
                                        detalles_lp_referencias.path2 as path2,
                                        detalles_lp_referencias.path3 as path3,
                                        detalles_lp_referencias.path4 as path4')
                              ->orderBy('detalles_lp.id','asc')
                              ->get();  
   
      return $informe_detalle;

  }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InformeLpRequest $request, $id){

      $informe  = Informe::find($id);
      $informeLp =InformesLp::where('informe_id',$informe->id)->first();
      DB::beginTransaction();
      try {
  
          $informe = (new \App\Http\Controllers\InformesController)->saveInforme($request,$informe);
          $this->saveInformeLp($request,$informe,$informeLp);       
          DetallesLp::where('informe_lp_id',$informeLp->id)->delete();
          $this->saveDetalle($request,$informeLp);
          DB::commit();
          
        } catch (Exception $e) {
  
          DB::rollback();
          throw $e;      
          
        }
  
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
