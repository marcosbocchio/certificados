<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MedidaRequest;
use App\Repositories\Medidas\MedidasRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection as Collection;

use App\Medidas;
use App\Productos;

class MedidasController extends Controller
{

    Protected $medidas;

    public function __construct(MedidasRepository $medidasRepository)
    {
      $this->medidas = $medidasRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Medidas::all();
    
    }

    public function paginate(Request $request){

        return Medidas::with('unidadMedidas')->orderBy('id','DESC')->paginate(10);

    }

    public function callView()
    {   
        $user = auth()->user()->name; 
        $header_titulo = "Medidas";
        $header_descripcion ="Alta | Baja | Modificación";  
        return view('medidas',compact('user','modelo','header_titulo','header_descripcion'));

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
    public function store(MedidaRequest $request)
    {
        $this->medidas->store($request) ;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Medidas  $medidas
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        
        
        $medidas = DB::select('select 
                            medidas.codigo descripcion,
                            medidas.id,
                            unidades_medidas.codigo 
                            from
                            medidas
                            inner join unidades_medidas on
                            unidades_medidas.id = medidas.unidades_medida_id
                            where
                            medidas.unidades_medida_id =:id',['id' => $id ]);

        $medidas = Collection::make($medidas);

        return $medidas;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Medidas  $medidas
     * @return \Illuminate\Http\Response
     */
    public function edit(Medidas $medidas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Medidas  $medidas
     * @return \Illuminate\Http\Response
     */
    public function update(MedidaRequest $request,$id)
    {
        $this->medidas->updateMedidas($request,$id) ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Medidas  $medidas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $medida = Medidas::find($id);
        $medida->delete();
    }

    public function getCms(){

        return DB::table('medidas')
                   ->join('unidades_medidas','unidades_medidas.id','=','medidas.unidades_medida_id') 
                   ->where('unidades_medidas.codigo','Cm')
                   ->select('medidas.*')
                   ->get();
    }
}
