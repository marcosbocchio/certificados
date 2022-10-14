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

    public function getVehiculo($id)
    {
        return Vehiculos::where('id',$id)->first();
    }
    public function index()
    {
        return Vehiculos::orderBy('nro_interno','ASC')->where('habilitado_sn',1)->get();
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
        $vehiculo->habilitado_sn = $request['habilitado_sn'];
        $vehiculo->save();

      }

    public function OtVehiculosTotal($ot_id){

        return OtVehiculos::where('ot_id',$ot_id)->count();

    }

    public function destroy($id)
    {
        $vehiculo = Vehiculos::find($id);
        $vehiculo->delete();
    }
}
