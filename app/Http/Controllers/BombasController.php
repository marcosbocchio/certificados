<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BombasRequest;
use App\Bombas;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class BombasController extends Controller
{

  public function __construct()
  {

        $this->middleware(['role_or_permission:Sistemas|M_fuentes'],['only' => ['callView']]);

  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Bombas::All();
    }

    public function paginate(Request $request){
        Log::debug("entro el paginate");
        return Bombas::orderBy('designacion','DESC')->paginate(10);
    }

    public function callView()
      {
          $user = auth()->user();
          $header_titulo = "Bombas";
          $header_descripcion ="Alta | Baja | Modificación";

          return view('bombas',compact('user','header_titulo','header_descripcion'));

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BombasRequest $request){

        $bomba = new Bombas;


          DB::beginTransaction();
          try {

              $this->saveBomba($request,$bomba);
              DB::commit();

          } catch (Exception $e) {

              DB::rollback();
              throw $e;

          }

      }

      public function update(BombasRequest $request, $id){

        $bomba = Bombas::find($id);

          DB::beginTransaction();
          try {
              $this->saveBomba($request,$bomba);
              DB::commit();

            } catch (Exception $e) {

              DB::rollback();
              throw $e;

            }
      }
      public function saveBomba($request,$bomba){

        $bomba->designacion = $request['designacion'];
        $bomba->marca = $request['marca'];
        $bomba->caudal = $request['caudal'];
        $bomba->voltaje = $request['voltaje'];
        $bomba->save();

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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Bomba = Bombas::find($id);
        $Bomba->delete();
    }
}
