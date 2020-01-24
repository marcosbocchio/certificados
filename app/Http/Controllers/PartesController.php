<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ParteRequest;
use App\helpers;
use App\Ots;
use App\Partes;
use App\ParteDetalles;
use App\ParteOperadores;
use App\Medidas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection as Collection;
use App\Informe;
use App\Tecnicas;
use \stdClass;
use App\ParametrosGenerales;
use App\InformesImportados;
use App\ParteServicios;

class PartesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($ot_id)
    {
      $header_titulo = "Partes OT";
      $header_descripcion ="Alta | Modificación";          
      $user = auth()->user()->name;

      return view('ot-partes.index',compact('ot_id',
                                             'user',                                                                   
                                             'header_titulo',
                                             'header_descripcion'));

    }

    public function paginate(Request $request,$ot_id){

     return DB::table('partes')
                    ->where('ot_id','=',$ot_id)
                    ->selectRaw('id,ot_id,DATE_FORMAT(partes.fecha,"%d/%m/%Y")as fecha,tipo_servicio,firma')
                    ->orderBy('id','DESC')           
                    ->paginate(10);
      }

    public function getPartesOt($ot_id){


        return DB::table('partes')
                   ->where('ot_id','=',$ot_id)
                   ->selectRaw('id,ot_id,DATE_FORMAT(partes.fecha,"%d/%m/%Y")as fecha,tipo_servicio,firma')
                   ->get();
      }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($ot_id)
    {
        $user = auth()->user()->name;
        $header_titulo = "Parte Diario";
        $header_descripcion ="Crear";         
        $ot = Ots::findOrFail($ot_id);      

        return view('partes.index', compact('ot',                                            
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
    public function store(ParteRequest $request)
    {
        $parte  = new Partes;          
       

        DB::beginTransaction();
        try {          
        
          $parte  = $this->saveParte($request,$parte);
          $this->saveResponsables($request->responsables,$parte);
          $this->saveParteDetalleRi($request->informes_ri,$parte);
          $this->saveParteDetallePm($request->informes_pm,$parte);
          $this->saveParteDetalleLp($request->informes_lp,$parte);
          $this->saveParteDetalleUs($request->informes_us,$parte);
          $this->saveParteDetalleInformesImportados($request->informes_importados,$parte);
          $this->saveParteServicios($request->servicios,$parte);
         
          DB::commit(); 
    
        } catch (Exception $e) {
    
          DB::rollback();
          throw $e;      
          
        }
    }

    public function saveResponsables($responsables, $parte){

          $parte_id = $parte->id;
             
                $ot_operarios = ParteOperadores::where('parte_id',$parte_id)->get();

                foreach ($ot_operarios as $ot_operario) {
                  $existe = false;
                    foreach ($responsables as $responsable) {

                        if( ($ot_operario['user_id'] == $responsable['user']['id'])){
                          $existe = true;
                        }
                  
                    }

                  if (!$existe){
                    ParteOperadores::where('parte_id',$parte_id)
                                    ->where('user_id',$ot_operario['user_id'])
                                    ->delete();
                    }
                }
             
               foreach ( $responsables as $responsable) {

                    $ot_operarios_update =ParteOperadores::firstOrCreate(
                        ['parte_id' =>  $parte_id,'user_id' => $responsable['user']['id'],'responsabilidad'=>$responsable['responsabilidad']],
                        ['parte_id' =>  $parte_id,'user_id' => $responsable['user']['id'],'responsabilidad'=>$responsable['responsabilidad']]

                    );
       
                $ot_operarios_update->save();
                }

    }

    public function saveParte($request,$parte){

        $user_id = null;
        
        if (Auth::check())
        {
             $user_id = $userId = Auth::id();    
        }

        $parte->ot_id = $request->ot['id'];
        $parte->fecha = date('Y-m-d',strtotime($request->fecha));
        $parte->tipo_servicio = $request->tipo_servicio;
        $parte->horario = $request->horario;
        $parte->movilidad_propia_sn = $request->movilidad_propia_sn;
        $parte->patente = $request->patente;
        $parte->km_inicial = $request->km_inicial;
        $parte->km_final = $request->km_final;
        $parte->user_id = $user_id;
        $parte->observaciones = $request->observaciones;
        $parte->save();

        return $parte;
    }

    public function saveParteDetalleRi($informes_ri,$parte){

        foreach ($informes_ri as $informe) {
            
            $parteDetalle  = new ParteDetalles;
            $parteDetalle->parte_id = $parte->id;            
            $parteDetalle->informe_id =$informe['id'];   
            $parteDetalle->costura_original = $informe['costura_original'];      
            $parteDetalle->costura_final = $informe['costura_final'];
            $parteDetalle->pulgadas_original = $informe['pulgadas_original'];
            $parteDetalle->pulgadas_final = $informe['pulgadas_final'];          
            $parteDetalle->placas_original = $informe['placas_original']; 
            $parteDetalle->placas_final = $informe['placas_final'];            
            $parteDetalle->cm = $informe['cm']['codigo'];      
     
            $parteDetalle->save();

            (new \App\Http\Controllers\InformesController)->setParteId($parte->id,$informe['id']);
           
        }

    }

    public function saveParteDetallePm($informes_pm,$parte){

        
        foreach ($informes_pm as $informe) {
            
            $parteDetalle  = new ParteDetalles;
            $parteDetalle->parte_id = $parte->id;            
            $parteDetalle->informe_id =$informe['id'];   
            $parteDetalle->pieza_original = $informe['pieza_original'];      
            $parteDetalle->pieza_final = $informe['pieza_final'];      
            $parteDetalle->metros_lineales = $informe['metros_lineales'];
            $parteDetalle->save();

            (new \App\Http\Controllers\InformesController)->setParteId($parte->id,$informe['id']);
           
        }

    }

    public function saveParteDetalleLp($informes_lp,$parte){

        
        foreach ($informes_lp as $informe) {
            
            $parteDetalle  = new ParteDetalles;
            $parteDetalle->parte_id = $parte->id;            
            $parteDetalle->informe_id =$informe['id'];   
            $parteDetalle->pieza_original = $informe['pieza_original'];      
            $parteDetalle->pieza_final = $informe['pieza_final'];       
            $parteDetalle->metros_lineales = $informe['metros_lineales'];
            $parteDetalle->save();

            (new \App\Http\Controllers\InformesController)->setParteId($parte->id,$informe['id']);
           
        }
    }
    
    public function saveParteDetalleUs($informes_us,$parte){

    
        foreach ($informes_us as $informe) {
            
            $parteDetalle  = new ParteDetalles;
            $parteDetalle->parte_id = $parte->id;            
            $parteDetalle->informe_id =$informe['id'];   
            $parteDetalle->pieza_original = $informe['pieza_original'];      
            $parteDetalle->pieza_final = $informe['pieza_final'];
            $parteDetalle->costura_original = $informe['costura_original'];      
            $parteDetalle->costura_final = $informe['costura_final'];   
            $parteDetalle->pulgadas_original = $informe['pulgadas_original'];
            $parteDetalle->pulgadas_final = $informe['pulgadas_final'];               
            $parteDetalle->save();

            (new \App\Http\Controllers\InformesController)->setParteId($parte->id,$informe['id']);
            
        }

    }

    public function saveParteDetalleInformesImportados($informes_importados,$parte){

    
        foreach ($informes_importados as $informe) {
            
            $parteDetalle  = new ParteDetalles;
            $parteDetalle->parte_id = $parte->id;            
            $parteDetalle->informe_importado_id =$informe['id'];   
            $parteDetalle->observaciones_original = $informe['observaciones_original'];      
            $parteDetalle->observaciones_final = $informe['observaciones_final'];
            
            $parteDetalle->save();

            (new \App\Http\Controllers\InformesImportadosController)->setParteId($parte->id,$informe['id']);
            
        }

    }

    public function saveParteServicios($servicios,$parte){

        foreach ($servicios as $servicio) {
           
            $parteServicio = new ParteServicios;
            $parteServicio->parte_id = $parte->id;
            $parteServicio->servicio_id = $servicio['servicio_id'];       
            $parteServicio->cant_original = $servicio['cant_original'];
            $parteServicio->cant_final = $servicio['cant_final'];
            $parteServicio->save();
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
        $header_titulo = "Parte Diario";
        $header_descripcion ="Editar";       
        $accion = 'edit';      
        $user = auth()->user()->name;
        $parte = Partes::findOrFail($id);
        $ot = Ots::findOrFail($ot_id);

        
        $responsables = ParteOperadores::where('parte_operadores.parte_id',$id)
                                        ->select('parte_operadores.*')
                                        ->with('user')
                                        ->get();

        $informes_ri  = DB::table('parte_detalles')
                            ->join('informes','informes.id','=','parte_detalles.informe_id')
                            ->join('metodo_ensayos','metodo_ensayos.id','=','informes.metodo_ensayo_id')                            
                             ->where('parte_detalles.parte_id',$id)
                             ->where('metodo_ensayos.metodo','RI')
                             ->selectRaw('parte_detalles.* , 0 as informe_sel,CONCAT(metodo_ensayos.metodo,LPAD(informes.numero, 3, "0")) as numero_formateado,DATE_FORMAT(informes.fecha,"%d/%m/%Y")as fecha_formateada')
                             ->get();
        
      
    
        $informes_pm  = DB::table('parte_detalles')
                             ->join('informes','informes.id','=','parte_detalles.informe_id')          
                             ->join('metodo_ensayos','metodo_ensayos.id','=','informes.metodo_ensayo_id')    
                             ->where('metodo_ensayos.metodo','PM')                                              
                              ->where('parte_detalles.parte_id',$id)
                              ->selectRaw('parte_detalles.* , 0 as informe_sel,CONCAT(metodo_ensayos.metodo,LPAD(informes.numero, 3, "0")) as numero_formateado,DATE_FORMAT(informes.fecha,"%d/%m/%Y")as fecha_formateada')
                              ->get();

        $informes_lp  = DB::table('parte_detalles')
                              ->join('informes','informes.id','=','parte_detalles.informe_id')          
                              ->join('metodo_ensayos','metodo_ensayos.id','=','informes.metodo_ensayo_id')    
                              ->where('metodo_ensayos.metodo','LP')                                              
                               ->where('parte_detalles.parte_id',$id)
                               ->selectRaw('parte_detalles.* , 0 as informe_sel,CONCAT(metodo_ensayos.metodo,LPAD(informes.numero, 3, "0")) as numero_formateado,DATE_FORMAT(informes.fecha,"%d/%m/%Y")as fecha_formateada')
                               ->get();

       $informes_us  = DB::table('parte_detalles')
                               ->join('informes','informes.id','=','parte_detalles.informe_id')          
                               ->join('metodo_ensayos','metodo_ensayos.id','=','informes.metodo_ensayo_id')   
                               ->join('tecnicas','tecnicas.id','=','informes.tecnica_id') 
                               ->where('metodo_ensayos.metodo','US')                                              
                               ->where('parte_detalles.parte_id',$id)
                               ->selectRaw('parte_detalles.* , 0 as informe_sel,CONCAT(metodo_ensayos.metodo,LPAD(informes.numero, 3, "0")) as numero_formateado,DATE_FORMAT(informes.fecha,"%d/%m/%Y")as fecha_formateada,tecnicas.codigo as tecnica')
                               ->get();
                               

        $informes_importados = DB::table('parte_detalles')
                                        ->join('informes_importados','informes_importados.id','=','parte_detalles.informe_importado_id')          
                                        ->join('metodo_ensayos','metodo_ensayos.id','=','informes_importados.metodo_ensayo_id')                                  
                                        ->where('parte_detalles.parte_id',$id)
                                        ->selectRaw('parte_detalles.* , 0 as informe_sel,CONCAT(metodo_ensayos.metodo,LPAD(informes_importados.numero, 3, "0")) as numero_formateado,DATE_FORMAT(informes_importados.fecha,"%d/%m/%Y")as fecha_formateada,metodo_ensayos.metodo as metodo')
                                        ->get();

        $servicios = DB::table('parte_servicios')
                               ->join('servicios','servicios.id','=','parte_servicios.servicio_id')
                               ->join('metodo_ensayos','metodo_ensayos.id','=','servicios.metodo_ensayo_id')   
                                ->join('unidades_medidas','unidades_medidas.id','=','servicios.unidades_medida_id')
                                ->where('parte_servicios.parte_id',$id)
                                ->selectRaw('metodo_ensayos.id as metodo_ensayo_id,metodo_ensayos.metodo,unidades_medidas.id as unidad_medida_id,unidades_medidas.codigo as unidad_medida,servicios.id as servicio_id,servicios.descripcion as servicio_descripcion,cant_original,cant_final')
                                ->get();
                             
         foreach ($informes_ri as $informe_ri) {

            $obj = new stdClass();
            $obj = Medidas::where('codigo',$informe_ri->cm)->first();
            if($obj){

                $informe_ri->cm = $obj;
                
            }else if($informe_ri->cm){

                $obj->codigo = $informe_ri->cm;
                $informe_ri->cm = '20';
            }
            
         }               
        

        return view('partes.edit', compact('parte',
                                            'responsables',
                                            'informes_ri',
                                            'informes_pm',
                                            'informes_lp',
                                            'informes_us',
                                            'informes_importados',
                                            'servicios',
                                            'ot',                                            
                                            'user',                                              
                                            'header_titulo',
                                            'header_descripcion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ParteRequest $request, $id)
    {
        $parte  = Partes::find($id);  
        DB::beginTransaction();
      
        try {    
           
            $parte  = $this->saveParte($request,$parte);
            $this->saveResponsables($request->responsables,$parte);
            $this->saveParteDetalleRi($request->informes_ri,$parte);
            ParteDetalles::where('parte_id',$parte->id)->delete();
            ParteServicios::where('parte_id',$parte->id)->delete();
            (new \App\Http\Controllers\InformesController)->deleteParteId($parte->id);
            (new \App\Http\Controllers\InformesImportadosController)->deleteParteId($parte->id);
            $this->saveParteDetalleRi($request->informes_ri,$parte);
            $this->saveParteDetallePm($request->informes_pm,$parte);
            $this->saveParteDetalleLp($request->informes_lp,$parte);
            $this->saveParteDetalleUs($request->informes_us,$parte);
            $this->saveParteDetalleInformesImportados($request->informes_importados,$parte);
            $this->saveParteServicios($request->servicios,$parte);

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

    public function getInformeImportado($id){

        return InformesImportados::find($id);
    }
    

    public function getInformeRiParte($id){

        $informe_ri = DB::select('select
                                    COUNT(DISTINCT(juntas.codigo)) as costuras,
                                    diametros_espesor.diametro as pulgadas,       
                                    COUNT(posicion.id) as placas,
                                    "RI" as metodo
                                    FROM informes 
                                    
                                    inner join informes_ri on informes.id = informes_ri.informe_id
                                    left join juntas on juntas.informe_ri_id = informes_ri.id
                                    left join posicion on posicion.junta_id = juntas.id
                                    inner join diametros_espesor on informes.diametro_espesor_id = diametros_espesor.id
                                    WHERE
                                    informes.id=:id group by diametro',['id' => $id ]);

      $informe_ri = Collection::make($informe_ri);


      return $informe_ri;

    }

    public function getInformePmParte($id){

        $informe_pm = DB::select('select
                                    detalles_pm.pieza ,
                                    detalles_pm.cm,
                                    "PM" as metodo
                                    FROM informes
                                    
                                    inner join informes_pm on informes.id = informes_pm.informe_id
                                    left join detalles_pm on detalles_pm.informe_pm_id = informes_pm.id
                                    WHERE
                                    informes.id =:id',['id' => $id ]);

      $informe_pm = Collection::make($informe_pm);


      return $informe_pm;

    }

    public function getInformeLpParte($id){

        $informe_lp = DB::select('select
                                    detalles_lp.pieza ,
                                    detalles_lp.cm,
                                    "LP" as metodo
                                    FROM informes
                                    
                                    inner join informes_lp on informes.id = informes_lp.informe_id
                                    left join detalles_lp on detalles_lp.informe_lp_id = informes_lp.id
                                    WHERE
                                    informes.id =:id',['id' => $id ]);

      $informe_lp = Collection::make($informe_lp);


      return $informe_lp;

    }

    public function getInformeUsParte($id){
   
        $informe =  Informe::find($id);
        $tecnica = Tecnicas::find($informe->tecnica_id);
       
        if($tecnica->codigo == 'US' || $tecnica->codigo =='PA')
        {
            $informe_us= Informe:: join('informes_us','informes.id','=','informes_us.informe_id')
                                   ->leftJoin('detalle_us_pa_us','detalle_us_pa_us.informe_us_id','=','informes_us.id')
                                   ->where('informes.id',$id)
                                   ->selectRaw('  COUNT(detalle_us_pa_us.elemento) as costuras,
                                                detalle_us_pa_us.diametro as pulgadas,  
                                                "US" as metodo')                               
                                ->groupBy('diametro')                                                       
                                ->get();

        }elseif($tecnica->codigo == 'ME'){

            $informe_us= Informe::join('informes_us','informes.id','=','informes_us.informe_id')
                                  ->leftJoin('informes_us_me','informes_us_me.informe_us_id','=','informes_us.id')
                                  ->where('informes.id',$id)
                                  ->selectRaw('   informes_us_me.elemento as pieza,
                                                  informes_us_me.diametro as pulgadas, 
                                                  "US" as metodo')            
                                 
                                  ->get();


        }

        foreach ($informe_us as $item) {
            
             $item->tecnica = $tecnica;
        } 

      return $informe_us;

    }

    public function PartesTotal($ot_id){

        return Partes::where('ot_id',$ot_id)->count(); 
  
    }

    public function firmar($id){

        $user_id = null;
        
        if (Auth::check())
        {
                $user_id = $userId = Auth::id();    
        }

        $parte = Partes::findOrFail($id);
        $parte->firma =  $user_id;
        $parte->save();

        return $parte;

    } 

    public function ddppi($ot_id){

        return PuedeCrearInforme($ot_id);
        
    }

}
