<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RemitoRequest;
use App\Ots;
use App\Remitos;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\DetalleRemitos;
use App\InternoEquipos;
use App\TrazabilidadEquipo;
use App\RemitoInternoEquipos;

class RemitosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($ot_id)
    {
      $header_titulo = "Remitos OT";
      $header_descripcion ="Alta | Modificación";          
      $user = auth()->user()->name;

      return view('ot-remitos.index',compact('ot_id',
                                             'user',                                            
                                             'header_titulo',
                                             'header_descripcion'));

    }

    public function paginate(Request $request,$ot_id){

      return DB::table('remitos')
                  ->where('ot_id','=',$ot_id)
                  ->selectRaw('id,ot_id,LPAD(prefijo, 4, "0") as prefijo_formateado,LPAD(numero, 8, "0") as numero_formateado,DATE_FORMAT(remitos.created_at,"%d/%m/%Y")as fecha,receptor,destino,interno_sn')
                  ->orderBy('id','DESC')           
                  ->paginate(10);
    }

    public function getRemitosOt($ot_id){


      return DB::table('remitos')
                 ->where('ot_id','=',$ot_id)
                 ->selectRaw('id,ot_id,LPAD(prefijo, 4, "0") as prefijo_formateado,LPAD(numero, 8, "0") as numero_formateado,DATE_FORMAT(remitos.created_at,"%d/%m/%Y")as fecha,receptor,destino,interno_sn')
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
        $header_titulo = "Remito";
        $header_descripcion ="Crear";         
        $ot = Ots::findOrFail($ot_id);      

        return view('remitos.index', compact('ot',                                            
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
    public function store(RemitoRequest $request)
    {
     

     
      $detalles = $request->detalles;
      $interno_equipos = $request->interno_equipos;
      

        $remito = new Remitos;

      DB::beginTransaction();
        try {          
        
          $remito = $this->saveRemito($request,$remito);           
          $this->saveDetalle($detalles,$remito);
          $this->saveInternoEquipos($interno_equipos,$remito);
          $this->updateInternoEquipos($interno_equipos,$remito);
          DB::commit(); 
    
        } catch (Exception $e) {
           
          DB::rollback();
          throw $e;      
          
        }
    }

    public function saveRemito($request,$remito){

        $user_id = null;
        
        if (Auth::check())
        {
             $user_id = $userId = Auth::id();    
        }

        $remito->ot_id    = $request->ot['id'];
        $remito->interno_sn = $request->interno_sn;
        $remito->prefijo  = $request->prefijo;
        $remito->numero   = $request->numero;
        $remito->fecha    = date('Y-m-d',strtotime($request->fecha));
        $remito->receptor = $request->receptor;
        $remito->destino  = $request->destino;
        $remito->user_id  =  $user_id;
        $remito->save();

        return $remito;
     }

     public function saveDetalle($detalles,$remito){

         
         foreach ($detalles as $detalle ) {
             
             
             $detalle_remito                       = new DetalleRemitos;
             $detalle_remito->remito_id            = $remito->id;
             $detalle_remito->producto_id          = $detalle['producto']['id'];       
             $detalle_remito->medida_id            = $detalle['medida']['id'];
             $detalle_remito->cantidad             = $detalle['cantidad_productos'];         
             $detalle_remito->save();           
      
           }

     }

     public function saveInternoEquipos($interno_equipos,$remito){

      foreach ($interno_equipos as $item ) {
       
        $remito_interno_equipo = new RemitoInternoEquipos;                
        $remito_interno_equipo->interno_equipo_id  = $item['id'];
        $remito_interno_equipo->remito_id  = $remito->id;    
        $remito_interno_equipo->save();          

      }
 }

     public function updateInternoEquipos($interno_equipos,$remito){

          foreach ($interno_equipos as $item ) {
           
            $interno_equipo = InternoEquipos::find($item['id']);                
            $interno_equipo->ot_id  = $remito->ot_id;;     
            $interno_equipo->save();  
            
            $this->saveTrazabilidadEquipo($interno_equipo,$remito);

    
          }
     }

     public function saveTrazabilidadEquipo($interno_equipo,$remito){

         $trazabilidad_equipo = new TrazabilidadEquipo;

         $trazabilidad_equipo->ot_id = $remito->ot_id;
         $trazabilidad_equipo->interno_equipo_id = $interno_equipo->id;
         $trazabilidad_equipo->user_id = $remito->user_id;
         $trazabilidad_equipo->save();      
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
        $header_titulo = "Remitos";
        $header_descripcion ="Editar";  
        $user = auth()->user()->name;
        $ot = Ots::findOrFail($ot_id);
        $remito = Remitos::findOrFail($id);

        $detalle_remito = $this->getDetalle($remito->id);
        $remito_interno_equipos = $this->getRemitoInternoEquipos($remito->id);
        
     
        return view('remitos.edit', compact('ot',                                        
                                            'user',   
                                            'remito', 
                                            'detalle_remito', 
                                            'remito_interno_equipos',                                     
                                            'header_titulo',
                                            'header_descripcion'));
    }

    public function getRemitoInternoEquipos($id){


      $remito_interno_equipos = InternoEquipos::join('remito_interno_equipos','remito_interno_equipos.interno_equipo_id','=','interno_equipos.id')
                                                ->join('remitos','remitos.id','=','remito_interno_equipos.remito_id')
                                                ->where('remitos.id',$id)
                                                ->select('interno_equipos.*')
                                                ->with('equipo')
                                                ->get();

        return $remito_interno_equipos; 

    }

    public function getDetalle($id){


        $detalle_remito       = DB::table('detalle_remitos')
                               ->where('remito_id','=',$id)
                               ->select('id','cantidad')
                               ->get();            
  

         foreach ($detalle_remito as $item) {
             
                $producto = DB::table('productos')
                                ->join('detalle_remitos','detalle_remitos.producto_id','=','productos.id')
                                ->where('detalle_remitos.id','=',$item->id)
                                ->select('productos.*')
                                ->first();

                $medida = DB::table('medidas')
                                ->join('detalle_remitos','detalle_remitos.medida_id','=','medidas.id')
                                ->join('unidades_medidas','unidades_medidas.id','=','medidas.unidades_medida_id')
                                ->where('detalle_remitos.id','=',$item->id)
                                ->select('medidas.codigo as descripcion','unidades_medidas.codigo as codigo','medidas.id as id')
                                ->first();

                $item->cantidad_productos =(string)$item->cantidad;
                $item->producto = $producto;
                $item->medida = $medida;        

         }
       
         return $detalle_remito; 


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RemitoRequest $request, $id)
    {

        
        $remito = Remitos::where('id',$id)->first();
        $detalles = $request->detalles;
        $interno_equipos = $request->interno_equipos;
        
        DB::beginTransaction();
        try {     
          
            $remito = $this->saveRemito($request,$remito);
            DetalleRemitos::where('remito_id',$id)->delete();           
            $this->saveDetalle($detalles,$remito);
            RemitoInternoEquipos::where('remito_id',$id)->delete();
            $this->saveInternoEquipos($interno_equipos,$remito);
            $this->updateInternoEquipos($interno_equipos,$remito);
           
           
          DB::commit();
          
        } catch (Exception $e) {
  
          DB::rollback();
          throw $e;      
          
        }
  
    }

    public function GenerarNumeroRemito($ot_id){

      return DB::table('remitos')
                 ->where('remitos.ot_id',$ot_id)
                 ->where('remitos.interno_sn',1)
                 ->orderBy('remitos.numero', 'DESC')   
                 ->limit(1) 
                 ->selectRaw('remitos.numero + 1 as numero_remito')                    
                 ->get();  


    }

    public function RemitosTotal($ot_id){

      return Remitos::where('ot_id',$ot_id)->count(); 

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
