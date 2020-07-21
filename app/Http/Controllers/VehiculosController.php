<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehiculoRequest;
use Illuminate\Http\Request;
use App\Vehiculos;
use App\User;
use Illuminate\Support\Facades\DB;
use App\OtVehiculos;

class VehiculosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {

      $this->middleware(['role_or_permission:Sistemas|M_vehiculos'], ['only' => ['callView']]);      
      
    }

    public function index()
    {
        return Vehiculos::orderBy('nro_interno','ASC')->get();
    }

    public function paginate(Request $request){

        return  Vehiculos::orderBy('nro_interno','ASC')->paginate(10);

    }

    public function callView()
    {   
        $user = auth()->user(); 
        $header_titulo = "Vehículos";
        $header_descripcion ="Alta | Baja | Modificación";  
        return view('vehiculos',compact('user','header_titulo','header_descripcion'));

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(VehiculoRequest $request){

        $vehiculo = new Vehiculos;   
  
          DB::beginTransaction();
          try { 
  
              $this->saveVehiculos($request,$vehiculo);
              DB::commit(); 
  
          } catch (Exception $e) {
      
              DB::rollback();
              throw $e;      
              
          }        
    }

    public function update(VehiculoRequest $request, $id){
  
        $vehiculo = Vehiculos::find($id);     
      
          DB::beginTransaction();
          try {
              $this->saveVehiculos($request,$vehiculo);
              DB::commit(); 
      
            } catch (Exception $e) {
        
              DB::rollback();
              throw $e;      
              
            }
      }

      public function saveVehiculos($request,$vehiculo){
        
        $vehiculo->nro_interno = $request['nro_interno'];
        $vehiculo->marca = $request['marca'];
        $vehiculo->modelo = $request['modelo'];
        $vehiculo->patente = $request['patente'];
        $vehiculo->tipo = $request['tipo'];
        $vehiculo->chasis = $request['chasis'];
        $vehiculo->motor = $request['motor'];
        $vehiculo->save();
  
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
    
    public function OtVehiculosTotal($ot_id){

        return OtVehiculos::where('ot_id',$ot_id)->count(); 

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vehiculo = Vehiculos::find($id);    
        $vehiculo->delete();
    }
}
