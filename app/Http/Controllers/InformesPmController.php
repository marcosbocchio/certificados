<?php

namespace App\Http\Controllers;

use App\Ots;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\Documentaciones\DocumentacionesRepository;
use App\Http\Requests\InformePmRequest;
use App\Informe;
use App\InformesPm;
use App\Materiales;
use App\DiametroView;
use App\DiametrosEspesor;
use App\InternoEquipos;
use App\Tecnicas;
use App\TipoPeliculas;
use App\NormaEvaluaciones;
use App\NormaEnsayos;
use App\MetodosTrabajoPm;
use App\TiposMagnetizacion;
use App\Corrientes;
use App\ColorParticulas;
use App\Iluminaciones;
use App\DetallesPm;
use App\DetallesPmReferencias;

class InformesPmController extends Controller
{
    public function __construct()
    {
        $this->middleware('ddppi')->only('create');
        $this->middleware(['role_or_permission:Super Admin|T_informes_edita'],['only' => ['create','edit']]);  

    }


    public function create($ot_id)
    {
        $metodo = 'PM';    
        $user = auth()->user();
        $header_titulo = "Informe";
        $header_descripcion ="Crear";         
        $ot = Ots::findOrFail($ot_id);      

        return view('informes.pm.index', compact('ot',
                                                 'metodo',
                                                 'user',                                              
                                                 'header_titulo',
                                                 'header_descripcion'));
    }

    public function store(InformePmRequest $request)
    {
        $informe  = new Informe;          
        $informePm  = new InformesPm;  

        DB::beginTransaction();
        try {          
        
          $informe = (new \App\Http\Controllers\InformesController)->saveInforme($request,$informe);
          $informePm = $this->saveInformePm($request,$informe,$informePm);
       
          $this->saveDetalle($request,$informePm);
    
          DB::commit(); 
    
        } catch (Exception $e) {
    
          DB::rollback();
          throw $e;      
          
        }
    }

    public function update(InformePmRequest $request, $id){

      $informe  = Informe::find($id);
      $informePm =InformesPm::where('informe_id',$informe->id)->first();
      DB::beginTransaction();
      try {
  
          $informe = (new \App\Http\Controllers\InformesController)->saveInforme($request,$informe);
          $this->saveInformePm($request,$informe,$informePm);       
          DetallesPm::where('informe_pm_id',$informePm->id)->delete();
          $this->saveDetalle($request,$informePm);
          DB::commit();
          
        } catch (Exception $e) {
  
          DB::rollback();
          throw $e;      
          
        }
  
    }

    public function saveInformePm($request,$informe,$informePm){      

   
      $informePm->informe_id = $informe->id;
      $informePm->metodo_trabajo_pm_id = $request->metodo_trabajo_pm['id'];
      $informePm->voltaje = $request->voltaje;
      $informePm->amperaje  = $request->am;
      $informePm->vehiculo = $request->vehiculo;
      $informePm->aditivo = $request->aditivo;
      $informePm->concentracion = $request->concentracion;
      $informePm->tipo_magnetizacion_id = $request->tipo_magnetizacion['id'];
      $informePm->corriente_magnetizacion_id = $request->magnetizacion['id'];
      $informePm->desmagnetizacion_sn    = $request->desmagnetizacion_sn;
      $informePm->color_particula_id = $request->color_particula['id'];
      $informePm->iluminacion_id = $request->iluminacion['id'];
  
      $informePm->save();     
      
      return $informePm;
  
    }

    public function saveDetalle($request,$informePm){


      foreach ($request->detalles as $detalle){    
        
        $referencia_id = $this->saveReferencia($detalle);

        $detallePm  = new DetallesPm; 
        $detallePm->informe_pm_id = $informePm->id;
        $detallePm->pieza = $detalle['pieza'];
        $detallePm->cm = $detalle['cm'];
        $detallePm->detalle = $detalle['detalle'];
        $detallePm->aceptable_sn = $detalle['aceptable_sn'];
        $detallePm->detalle_pm_referencia_id = $referencia_id;
        $detallePm->save();           

      } 

    }

    public function saveReferencia($detalle){
 
      if (($detalle['observaciones'])||
          ($detalle['path1']) ||
          ($detalle['path2']) ||
          ($detalle['path3']) ||
          ($detalle['path4'])){
  
            $detalle_pm_referencia                     = new DetallesPmReferencias;
            $detalle_pm_referencia->descripcion        = $detalle['observaciones'];
            $detalle_pm_referencia->path1              = $detalle['path1'];
            $detalle_pm_referencia->path2              = $detalle['path2'];
            $detalle_pm_referencia->path3              = $detalle['path3'];
            $detalle_pm_referencia->path4              = $detalle['path4'];
            $detalle_pm_referencia->save();
  
            return $detalle_pm_referencia->id;
         }
         else{
            return null;
         }
  
    }     
    

    public function edit($ot_id,$id)
    {
        $header_titulo = "Informe";
        $header_descripcion ="Editar";  
        $metodo = 'PM';    
        $accion = 'edit';      
        $user = auth()->user();
        $ot = Ots::findOrFail($ot_id);
        $informe = Informe::findOrFail($id);
        $informe_pm =InformesPm::where('informe_id',$informe->id)->first();     
        $informe_material = Materiales::find($informe->material_id);
        $informe_diametroEspesor = DiametrosEspesor::find($informe->diametro_espesor_id);
        $informe_diametro = DiametroView::where('diametro',$informe_diametroEspesor->diametro)->first();       
        $informe_interno_equipo = internoEquipos::where('id',$informe->interno_equipo_id)->with('equipo')->first();
        $informe_tecnica = Tecnicas::find($informe->tecnica_id);
        $documetacionesRepository = new DocumentacionesRepository;
        $informe_procedimiento = (new DocumentacionesController($documetacionesRepository))->ProcedimientoInformeId($informe->procedimiento_informe_id);    
        $informe_norma_evaluacion = NormaEvaluaciones::find($informe->norma_evaluacion_id);
        $informe_norma_ensayo = NormaEnsayos::find($informe->norma_ensayo_id);
        $informe_ejecutor_ensayo =(new OtOperariosController())->getEjecutorEnsayo($informe->ejecutor_ensayo_id);
        $informe_pm_metodo_trabajo_pm = MetodosTrabajoPm::find($informe_pm->metodo_trabajo_pm_id);
        $informe_pm_tipo_magnetizacion = TiposMagnetizacion::find($informe_pm->tipo_magnetizacion_id);
        $informe_pm_magnetizacion = Corrientes::find($informe_pm->corriente_magnetizacion_id);
        $informe_pm_desmagnetizacion_sn = $informe_pm->desmagnetizacion_sn;
        $infome_pm_color_particula = ColorParticulas::find($informe_pm->color_particula_id);
        $informe_pm_iluminacion = Iluminaciones::find($informe_pm->iluminacion_id);

        $informe_detalle = $this->getDetalle($informe_pm->id);

        return view('informes.pm.edit', compact('ot',
                                                 'metodo',
                                                 'user',
                                                 'informe',
                                                 'informe_pm',  
                                                 'informe_material',  
                                                 'informe_diametro',
                                                 'informe_diametroEspesor',                                                                            
                                                 'informe_tecnica_grafico',
                                                 'informe_interno_equipo',   
                                                 'informe_tecnica', 
                                                 'informe_procedimiento',                                              
                                                 'informe_norma_evaluacion',
                                                 'informe_norma_ensayo',
                                                 'informe_ejecutor_ensayo',     
                                                 'informe_pm_metodo_trabajo_pm',    
                                                 'informe_pm_tipo_magnetizacion',
                                                 'informe_pm_magnetizacion',
                                                 'informe_pm_desmagnetizacion_sn',
                                                 'infome_pm_color_particula',
                                                 'informe_pm_iluminacion',
                                                 'informe_detalle',
                                                 'header_titulo',
                                                 'header_descripcion'));
    }

    public function getDetalle($id){

      $informe_detalle = DB::table('detalles_pm')
                             ->leftjoin('detalles_pm_referencias','detalles_pm_referencias.id','=','detalles_pm.detalle_pm_referencia_id')                      
                             ->where('detalles_pm.informe_pm_id',$id)
                             ->selectRaw('detalles_pm.detalle as detalle,
                                        detalles_pm.cm as cm,
                                        detalles_pm.pieza as pieza,
                                        detalles_pm.aceptable_sn as aceptable_sn,
                                        detalles_pm_referencias.descripcion as observaciones,
                                        detalles_pm_referencias.path1 as path1,
                                        detalles_pm_referencias.path2 as path2,
                                        detalles_pm_referencias.path3 as path3,
                                        detalles_pm_referencias.path4 as path4')
                              ->orderBy('detalles_pm.id','asc')
                              ->get();  
   
      return $informe_detalle;

  }

    
}
