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
use App\RemitoInternoEquipos;
use App\Productos;
use App\Stock;
use Illuminate\Support\Facades\Log;


class RemitosController extends Controller
{
  public function __construct()
  {

    $this->middleware(['role_or_permission:Sistemas|T_remitos_acceder'],['only' => ['index']]);
    $this->middleware(['role_or_permission:Sistemas|T_remitos_edita'],['only' => ['store','edit','update']]);

  }
    public function index()
    {

    }

    public function RemitosTable(){

        $header_titulo = "Remitos";
        $header_descripcion ="";
        $header_sub_titulo ='';
        $user = auth()->user();

        return view('remitos.table',compact('user',
                                            'header_titulo',
                                            'header_sub_titulo',
                                            'header_descripcion'));

    }

    public function callView(){

        $header_titulo = "Remitos";
        $header_descripcion ="Alta | Modificación";
        $header_sub_titulo ='';
        $user = auth()->user();

        return view('remitos.index',compact('user',
                                            'header_titulo',
                                            'header_sub_titulo',
                                            'header_descripcion'));
    }

    public function paginate(Request $request){

      return remitos::selectRaw('id,LPAD(prefijo, 4, "0") as prefijo_formateado,LPAD(numero, 8, "0") as numero_formateado,DATE_FORMAT(remitos.created_at,"%d/%m/%Y")as fecha,receptor,destino,frente_origen_id,frente_destino_id,aunulado_sn')
                     ->with('frente_origen')
                     ->with('frente_destino')
                     ->orderBy('id','DESC')
                     ->paginate(10);
    }

    public function create($ot_id)
    {
        $user = auth()->user();
        $header_titulo = "Remito";
        $header_descripcion ="Crear";
        $ot = Ots::findOrFail($ot_id);

        return view('remitos.index', compact('ot',
                                             'user',
                                             'header_titulo',
                                             'header_descripcion'));
    }

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

        return $remito;
    }

    public function saveRemito($request,$remito){

        $user_id = null;

        if (Auth::check())
        {
             $user_id = $userId = Auth::id();
        }

        $remito->prefijo  = $request->prefijo;
        $remito->numero   = $request->numero;
        $remito->fecha    = date('Y-m-d',strtotime($request->fecha));
        $remito->frente_origen_id = $request->frente_origen['id'];
        $remito->frente_destino_id = $request->frente_destino['id'];
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

             $this->actualizarStockYRegistrarMovimiento($detalle_remito, $remito);
    }
}

private function actualizarStockYRegistrarMovimiento($detalle_remito, $remito)
{
    DB::beginTransaction();
    try {
        $producto = Productos::findOrFail($detalle_remito->producto_id);
        // Restar la cantidad del detalle al stock actual del producto
        $producto->stock -= $detalle_remito->cantidad;
        $producto->save();


        $nuevoMovimientoStock = new Stock();
        $nuevoMovimientoStock->producto_id = $detalle_remito->producto_id;
        $nuevoMovimientoStock->cantidad = -$detalle_remito->cantidad; // Negativo porque es una salida
        $nuevoMovimientoStock->stock = $producto->stock; // El stock después de la operación
        $nuevoMovimientoStock->fecha = $remito->fecha;
        $nuevoMovimientoStock->obs = $remito->prefijo . '-' . $remito->numero; // Observación con prefijo y número de remito;
        $nuevoMovimientoStock->tipo_movimiento = 'Remito: n°'. $remito->prefijo . '-' . $remito->numero . ' | Receptor: ' . $remito->receptor . ' | Destino: '. $remito->destino;
        $nuevoMovimientoStock->save();

        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        // Manejar el error adecuadamente
        Log::error('Error al actualizar stock y registrar movimiento: ' . $e->getMessage());
        throw $e;
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
            $interno_equipo->frente_id  = $remito->frente_destino_id;
            $interno_equipo->save();
            (new \App\Http\Controllers\TrazabilidadEquipoController)->saveTrazabilidadEquipo($interno_equipo->id,$remito->frente_destino_id);

          }
     }

    public function edit($id)
    {

        $header_titulo = "Remitos";
        $header_descripcion ="Editar";
        $user = auth()->user();
        $remito = Remitos::where('id',$id)->with('frente_origen')->with('frente_destino')->first();
        $detalle_remito = $this->getDetalle($remito->id);
        $remito_interno_equipos = $this->getRemitoInternoEquipos($remito->id);

        return view('remitos.edit', compact('user',
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
    public function destroy($id)
    {
        //
    }

    public function remitoAnulacion($id){
      DB::beginTransaction();
      try {
          
          
          $remito = Remitos::findOrFail($id);
          
  
          $detallesRemitos = DetalleRemitos::where('remito_id', $id)->get();
    
          foreach ($detallesRemitos as $detalle) {
              $producto = Productos::findOrFail($detalle->producto_id);
              $producto->stock += $detalle->cantidad;
              $producto->save();
            
              $nuevoMovimientoStock = new Stock();
              $nuevoMovimientoStock->producto_id = $detalle->producto_id;
              $nuevoMovimientoStock->fecha = now();
              $nuevoMovimientoStock->obs = "Anulacion Remito N°".str_pad($remito->prefijo, 4, "0", STR_PAD_LEFT)."-".str_pad($remito->numero, 8, "0", STR_PAD_LEFT);
              $nuevoMovimientoStock->cantidad = $detalle->cantidad;
              $nuevoMovimientoStock->stock = $producto->stock;
              $nuevoMovimientoStock->tipo_movimiento = 'Anulacion';
              $nuevoMovimientoStock->save();
              
          }
    
          $remitoInternoEquipos = RemitoInternoEquipos::where('remito_id', $remito->id)->get();
          if (!$remitoInternoEquipos->isEmpty()) {
              foreach ($remitoInternoEquipos as $item) {
                  $internoEquipo = InternoEquipos::findOrFail($item->interno_equipo_id);
                  $internoEquipo->frente_id = $remito->frente_origen_id;
                  $internoEquipo->save();
                  Log::info("Actualizado InternoEquipo ID: {$internoEquipo->id} con nuevo frente_id: {$remito->frente_destino_id}");
              }
          }
  
          // Marcar el remito como anulado
          $remito->aunulado_sn = 1;
          $remito->save();
          
  
          DB::commit();
          return response()->json(['message' => 'Remito anulado con éxito y stock actualizado.'], 200);
      } catch (\Exception $e) {
          DB::rollback();
          Log::error("Error al anular el remito", ['error' => $e->getMessage(), 'remito_id' => $id]);
          return response()->json(['error' => 'Error al anular el remito: '.$e->getMessage()], 500);
      }
  }

    public function desanularRemito($id){
      DB::beginTransaction();
      try {
          
          
          $remito = Remitos::findOrFail($id);
          
  
          $detallesRemitos = DetalleRemitos::where('remito_id', $id)->get();
    
          foreach ($detallesRemitos as $detalle) {
              $producto = Productos::findOrFail($detalle->producto_id);
              $producto->stock -= $detalle->cantidad;
              $producto->save();
            
              $nuevoMovimientoStock = new Stock();
              $nuevoMovimientoStock->producto_id = $detalle->producto_id;
              $nuevoMovimientoStock->fecha = now();
              $nuevoMovimientoStock->obs = "Desanulacion Remito N°".str_pad($remito->prefijo, 4, "0", STR_PAD_LEFT)."-".str_pad($remito->numero, 8, "0", STR_PAD_LEFT);
              $nuevoMovimientoStock->cantidad = -$detalle->cantidad;
              $nuevoMovimientoStock->stock = $producto->stock;
              $nuevoMovimientoStock->tipo_movimiento = 'Desanulacion';
              $nuevoMovimientoStock->save();
              
          }
    
          $remitoInternoEquipos = RemitoInternoEquipos::where('remito_id', $remito->id)->get();
          if (!$remitoInternoEquipos->isEmpty()) {
              foreach ($remitoInternoEquipos as $item) {
                  $internoEquipo = InternoEquipos::findOrFail($item->interno_equipo_id);
                  $internoEquipo->frente_id = $remito->frente_destino_id;
                  $internoEquipo->save();
                  Log::info("Actualizado InternoEquipo ID: {$internoEquipo->id} con nuevo frente_id: {$remito->frente_destino_id}");
              }
          }
  
          // Marcar el remito como Desanulado
          $remito->aunulado_sn = 0;
          $remito->save();
          
  
          DB::commit();
          return response()->json(['message' => 'Remito anulado con éxito y stock actualizado.'], 200);
      } catch (\Exception $e) {
          DB::rollback();
          Log::error("Error al anular el remito", ['error' => $e->getMessage(), 'remito_id' => $id]);
          return response()->json(['error' => 'Error al anular el remito: '.$e->getMessage()], 500);
      }
    }

}
