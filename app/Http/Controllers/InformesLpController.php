<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Ots;
use App\Informe;
use App\InformesLp;
use App\DetallesLp;
use App\DetallesLpReferencias;

class InformesLpController extends Controller
{
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
        $user = auth()->user()->name;
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
    public function store(Request $request)
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
    }

    public function saveInformeLp($request,$informe,$informeLp){      

   
        $informeLp->informe_id = $informe->id;
        $informeLp->metodo_trabajo_lp_id = $request->metodo_trabajo_lp['id'];
        $informeLp->tipo_penetrante = $request->tipo_penetrante;
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
          $detalleLp->numero = $detalle['numero'];
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
