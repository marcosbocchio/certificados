<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PlantaRequest;
use Illuminate\Support\Facades\DB;
use App\Plantas;
use App\Clientes;

class PlantasController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        $header_titulo = "Plantas ";
        $header_descripcion ="Alta | Baja | Modificación";

        return view('plantas',compact('user','header_titulo','header_descripcion'));

    }

    public function PlantasCliente($id){

        return Plantas::where('cliente_id',$id)->get();

    }

    public function paginate(Request $request,$id){

        return Plantas::where('cliente_id',$id)->orderBy('id','DESC')->paginate(10);
    }

    public function store(PlantaRequest $request)
    {
        $planta = new Plantas;

        DB::beginTransaction();
        try {

            $planta->cliente_id = $request['cliente_id'];
            $this->savePlanta($request,$planta);
            DB::commit();

        } catch (Exception $e) {

            DB::rollback();
            throw $e;

        }
    }

    public function savePlanta($request,$planta){

        $planta->codigo = $request['codigo'];
        $planta->nombre = $request['nombre'];
        $planta->save();

    }

    public function destroy($id)
    {
        $planta = Plantas::find($id);
        $planta->delete();
    }

    public function update(PlantaRequest $request, $id)
    {
        $planta = Plantas::find($id);

        DB::beginTransaction();
        try {
            $this->savePlanta($request,$planta);
            DB::commit();

          } catch (Exception $e) {

            DB::rollback();
            throw $e;

          }
    }
}
