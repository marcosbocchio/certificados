<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\UnidadMedidaRequest;
use App\UnidadesMedidas;

class UnidadesMedidasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UnidadesMedidas::all();
    }

    public function paginate(Request $request){

        return UnidadesMedidas::orderBy('id','DESC')->paginate(10);

    }

    public function callView()
    {   
        $user = auth()->user()->name;
        $header_titulo = "Unidades Medidas";
        $header_descripcion ="Alta | Baja | Modificación";      
        return view('unidades_medidas',compact('user','header_titulo','header_descripcion'));

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
    public function store(UnidadMedidaRequest $request)
    {
        $unidad_medida  = new UnidadesMedidas; 

        DB::beginTransaction();

        try { 

            $this->saveUnidadMedida($request,$unidad_medida);
            DB::commit(); 
        
        } catch (Exception $e) {
    
          DB::rollback();
          throw $e;      
          
        }
    }

    public function saveUnidadMedida($request,$unidad_medida){

        $unidad_medida->codigo = $request['codigo'];
        $unidad_medida->descripcion = $request['descripcion'];
        $unidad_medida->save();

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
    public function update(UnidadMedidaRequest $request, $id)
    {
        DB::beginTransaction();
        
        try { 

            $unidad_medida  = UnidadesMedidas::find($id); 
            $this->saveUnidadMedida($request,$unidad_medida);
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
        $unidad_medida = UnidadesMedidas::find($id);    
        $unidad_medida->delete();
    }
}
