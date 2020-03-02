<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CertificadoRequest;
use App\helpers;
use App\Ots;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Certificados;
use App\CertificadoServicios;
use App\CertificadoProductos;
use App\Productos;
class CertificadosController extends Controller
{

    public function __construct()
    {
  
        $this->middleware(['role_or_permission:Super Admin|T_certif_acceder'],['only' => ['index']]);  
        $this->middleware(['role_or_permission:Super Admin|T_certif_edita'],['only' => ['create','store','update','edit']]);  
    
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($ot_id)
    {
        $header_titulo = "Certificados";
        $header_descripcion ="Alta | Modificación";          
        $user = auth()->user();
  
        $ot = Ots::where('id',$ot_id)->with('cliente')->first();
        $header_sub_titulo =' / ' .$ot->cliente->nombre_fantasia . ' / OT N°: ' . $ot->numero;
        
        return view('ot-certificados.index',compact('ot_id',
                                               'user',                                                                   
                                               'header_titulo',
                                               'header_sub_titulo',
                                               'header_descripcion'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($ot_id)
    {
        $user = auth()->user();
        $header_titulo = "Certificados";
        $header_descripcion ="Crear";         
        $ot = Ots::findOrFail($ot_id);      

        return view('certificados.index', compact('ot',                                            
                                                   'user',                                              
                                                   'header_titulo',
                                                   'header_descripcion'));
    }

    public function paginate(Request $request,$ot_id){

        return DB::table('certificados')
                       ->where('ot_id','=',$ot_id)
                       ->selectRaw('id,ot_id,numero,DATE_FORMAT(certificados.fecha,"%d/%m/%Y")as fecha,firma,LPAD(certificados.numero, 8, "0") as numero_formateado')
                       ->orderBy('id','DESC')           
                       ->paginate(10);
         }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CertificadoRequest $request)
    {
        $certificado  = new certificados;       
       

        DB::beginTransaction();
        try {          
        
          $certificado  = $this->saveCertificado($request,$certificado);
          $this->saveCertificadoServicios($request->TablaPartesServicios,$certificado);
          $this->saveCertificadoProductosPorPlaca($request->TablaPartesProductosPorPlacas,$certificado);
          $this->saveCertificadoProductosPorCosturas($request->TablaPartesProductosPorCosturas,$certificado);

         
          DB::commit(); 
    
        } catch (Exception $e) {
    
          DB::rollback();
          throw $e;      
          
        }

        return $certificado;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(CertificadoRequest $request, $id)
    {
        $certificado  = Certificados::find($id);  
        DB::beginTransaction();
      
        try {    
           
            $certificado  = $this->saveCertificado($request,$certificado);
            CertificadoServicios::where('certificado_id',$certificado->id)->delete();
            CertificadoProductos::where('certificado_id',$certificado->id)->delete();
            (new \App\Http\Controllers\PartesController)->deleteCertificadosId($certificado->id);
            $this->saveCertificadoServicios($request->TablaPartesServicios,$certificado);
            $this->saveCertificadoProductosPorPlaca($request->TablaPartesProductosPorPlacas,$certificado);
            $this->saveCertificadoProductosPorCosturas($request->TablaPartesProductosPorCosturas,$certificado);
            DB::commit();
            
            } catch (Exception $e) {
    
            DB::rollback();
            throw $e;      
            
            }
    }

    public function saveCertificado($request,$certificado){

        $user_id = null;
        
        if (Auth::check())
        {
             $user_id = $userId = Auth::id();    
        }

        $certificado->ot_id = $request->ot['id'];
        $certificado->fecha = date('Y-m-d',strtotime($request->fecha));
        $certificado->numero = $request->numero;
        $certificado->titulo = $request->titulo;
        $certificado->info_pedido_cliente = $request->info_pedido_cliente;
        $certificado->user_id = $user_id;
        $certificado->save();
     
        return $certificado;

    }

    public function saveCertificadoServicios($servicios,$certificado){

        foreach ($servicios as $servicio) { 

            $certificadoServicios  = new CertificadoServicios;
            $certificadoServicios->certificado_id = $certificado->id;
            $certificadoServicios->parte_id = $servicio['parte_id'];
            $certificadoServicios->servicio_id = $servicio['servicio_id'];
            $certificadoServicios->cant_original = $servicio['cant_original'];
            $certificadoServicios->cant_final = $servicio['cant_final'];
            $certificadoServicios->nro_combinacion = $servicio['nro_combinacion'];
            $certificadoServicios->combinacion = $servicio['combinacion'];
            $certificadoServicios->save();

            (new \App\Http\Controllers\PartesController)->setCertificadoId($certificado->id,$servicio['parte_id']);

        }

    }

    public function saveCertificadoProductosPorPlaca($productos,$certificado){

      
        foreach ($productos as $producto) {

            $certificadoProductos  = new CertificadoProductos;
            $certificadoProductos->certificado_id = $certificado->id;
            $certificadoProductos->parte_id = $producto['parte_id'];
            $certificadoProductos->placas_original = $producto['placas_original'];
            $certificadoProductos->placas_final = $producto['placas_final'];
            $certificadoProductos->cm = $producto['cm'];         
            $certificadoProductos->save();

            (new \App\Http\Controllers\PartesController)->setCertificadoId($certificado->id,$producto['parte_id']);
        } 

    }

    public function saveCertificadoProductosPorCosturas($productos,$certificado){
      
        foreach ($productos as $producto) {

            $certificadoProductos  = new CertificadoProductos;
            $certificadoProductos->certificado_id = $certificado->id;
            $certificadoProductos->parte_id = $producto['parte_id'];
            $certificadoProductos->costuras_original = $producto['costuras_original'];
            $certificadoProductos->costuras_final = $producto['costuras_final'];
            $certificadoProductos->pulgadas = $producto['pulgadas'];         
            $certificadoProductos->save();

            (new \App\Http\Controllers\PartesController)->setCertificadoId($certificado->id,$producto['parte_id']);

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

    public function GenerarNumeroCertificado(){

        return DB::table('certificados')                  
                    ->orderBy('certificados.numero', 'DESC')   
                    ->limit(1) 
                    ->selectRaw('certificados.numero + 1 as numero_certificado')                    
                    ->get();  

    }

    public function getParteServicios($parte_id){

        return DB::select('CALL CertificadosParteServicios(?)',array($parte_id));   
    }

    public function getParteProductos($parte_id,$modo_cobro){
        
        if($modo_cobro =='PLACAS'){

              $productos = DB::select('CALL CertificadosParteProductosPorPlaca(?)',array($parte_id));  

        }elseif($modo_cobro =='COSTURAS'){    

              $productos = DB::select('CALL CertificadosParteProductosPorCosturas(?)',array($parte_id)); 

        }
        return $productos;
    }

    public function getModalidadCobro($ot_id){

        // SI LA OT TIENE UN PRODUCTO RALACIONADO A PLACAS DEFINIDO POR " (PULGADAS) SE COBRA POR COSTURAS, SINO SE COBRA POR PLACAS

        return Productos::join('ot_productos','ot_productos.producto_id','=','productos.id')       
                            ->join('unidades_medidas','unidades_medidas.id','=','productos.unidades_medida_id')                        
                            ->Where('ot_productos.ot_id',$ot_id)                               
                            ->Where('relacionado_a_placas_sn',1)
                            ->Where('unidades_medidas.codigo','"')
                            ->get();
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($ot_id,$id)
    {
        $header_titulo = "Certificados";
        $header_descripcion ="Crear";      
        $accion = 'edit';      
        $user = auth()->user();
        $certificado = Certificados::where('id',$id)
                                    ->where('ot_id',$ot_id)
                                    ->firstOrFail();

        $ot = Ots::findOrFail($ot_id);

      //  DB::enableQueryLog();
        $servicios= CertificadoServicios::join('certificados','certificados.id','=','certificado_servicios.certificado_id')
                                          ->join('ots','ots.id','=','certificados.ot_id')
                                          ->join('partes','partes.id','=','certificado_servicios.parte_id')  
                                          ->join('servicios','servicios.id','=','certificado_servicios.servicio_id')     
                                          ->join('ot_servicios','ot_servicios.servicio_id','=','servicios.id')                                      
                                          ->where('certificados.id',$id)
                                          ->whereRaw('ot_servicios.ot_id = ots.id')
                                          ->selectRaw('certificado_servicios.*,LPAD(partes.id, 8, "0") as numero_formateado,DATE_FORMAT(partes.fecha,"%d/%m/%Y")as fecha_formateada,ot_servicios.combinado_sn,
                                          servicios.abreviatura,servicios.descripcion as servicio_descripcion,(SELECT DISTINCT(informes.obra) from informes WHERE informes.parte_id =partes.id ) as obra')                                       
                                          ->orderBy('certificado_servicios.id','ASC')
                                          ->get();

       // dd(DB::getQueryLog()); 

        $productos_placas=CertificadoProductos::where('certificado_productos.certificado_id',$id)
                                                ->join('partes','partes.id','=','certificado_productos.parte_id')
                                                ->whereNotNull('certificado_productos.cm')    
                                                ->selectRaw('certificado_productos.*,LPAD(partes.id, 8, "0") as numero_formateado')                                       
                                                ->get();

       
        $productos_costuras=CertificadoProductos::where('certificado_productos.certificado_id',$id)
                                               ->join('partes','partes.id','=','certificado_productos.parte_id')
                                                ->whereNotNull('certificado_productos.pulgadas')    
                                                ->selectRaw('certificado_productos.*,LPAD(partes.id, 8, "0") as numero_formateado')                                       
                                                ->get();    

        return view('certificados.edit', compact('certificado',                       
                                                'servicios',
                                                'productos_placas',
                                                'productos_costuras',  
                                                'ot',                                            
                                                'user',                                              
                                                'header_titulo',
                                                'header_descripcion'));
    }

    public function CertificadosTotal($ot_id){

        return Certificados::where('ot_id',$ot_id)->count(); 
  
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
