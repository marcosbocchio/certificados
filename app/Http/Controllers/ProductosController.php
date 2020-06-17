<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductoRequest;
use Illuminate\Support\Facades\DB;
use App\Productos;

class ProductosController extends Controller
{

    public function __construct()
    {

          $this->middleware(['role_or_permission:Sistemas|M_productos'],['only' => ['callView']]);  
    
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  Productos::with('unidadMedidas')->orderBy('descripcion','ASC')->get();
    }

    public function paginate(Request $request){

        return  Productos::with('unidadMedidas')->orderBy('codigo','ASC')->paginate(10);

    }

    public function ProductosOts(){

        return  Productos::where('visible_ot',1)->orderBy('descripcion','ASC')->get();
    }

    public function callView()
    {   
        $user = auth()->user(); 
        $header_titulo = "Productos";
        $header_descripcion ="Alta | Baja | Modificación";  
        return view('productos',compact('user','header_titulo','header_descripcion'));

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
    public function store(ProductoRequest $request)
    {
        $producto = new Productos;   

        DB::beginTransaction();
        try { 

            $this->saveProducto($request,$producto);
            DB::commit(); 

        } catch (Exception $e) {
    
            DB::rollback();
            throw $e;      
            
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
    public function update(ProductoRequest $request, $id)
    {
        $producto = Productos::find($id);     
    
        DB::beginTransaction();
        try {
            $this->saveProducto($request,$producto);
            DB::commit(); 
    
          } catch (Exception $e) {
      
            DB::rollback();
            throw $e;      
            
          }
    }

    public function saveProducto($request,$producto){

        $producto->codigo = $request['codigo'];
        $producto->descripcion = $request['descripcion'];
        $producto->unidades_medida_id = $request['unidad_medida']['id'];
        $producto->visible_ot = $request->visible_ot;
        $producto->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $producto = Productos::find($id);
        $producto->delete();
    }
}
