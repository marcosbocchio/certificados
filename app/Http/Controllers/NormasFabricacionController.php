<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\NormasFabricacion;

class NormasFabricacionController extends Controller
{
    /**
     * Constructor del controlador.
     *
     * Si deseas agregar middleware para permisos o roles, lo puedes hacer aquí.
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:Sistemas|M_normas_fabricacion'], ['only' => ['callView']]);
    }

    /**
     * Retorna todos los registros de NormasFabricacion ordenados por descripción.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return NormasFabricacion::orderBy('descripcion', 'ASC')->get();
    }

    /**
     * Retorna los registros paginados de NormasFabricacion ordenados por código.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function paginate(Request $request)
    {
        // Inicia la consulta sobre la tabla normas_fabricacion
        $query = NormasFabricacion::query();
    
        // Si existe un término de búsqueda, aplica el filtro sobre 'codigo' y 'descripcion'
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('codigo', 'LIKE', "%{$search}%")
                  ->orWhere('descripcion', 'LIKE', "%{$search}%");
            });
        }
    
        // Ordena los resultados por código (ASC)
        $query->orderBy('codigo', 'ASC');
    
        // Retorna los resultados paginados
        return $query->paginate(10);
    }
    

    /**
     * Muestra la vista principal para Normas de Fabricación.
     *
     * @return \Illuminate\Http\Response
     */
    public function callView()
    {
        $user = auth()->user(); 
        $header_titulo = "Normas Fabricación";
        $header_descripcion = "Alta | Baja | Modificación";  
        return view('normas-fabricacion', compact('user', 'header_titulo', 'header_descripcion'));
    }

    /**
     * Almacena un nuevo registro de NormasFabricacion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function store(Request $request)
    {
        $norma = new NormasFabricacion();

        DB::beginTransaction();
        try {
            $this->saveNormasFabricacion($request, $norma);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }      
    }

    /**
     * Actualiza un registro existente de NormasFabricacion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $norma = NormasFabricacion::find($id);

        DB::beginTransaction();
        try {
            $this->saveNormasFabricacion($request, $norma);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Elimina un registro de NormasFabricacion.
     *
     * @param  int  $id
     * @return void
     */
    public function destroy($id)
    {
        $norma = NormasFabricacion::find($id);
        if ($norma) {
            $norma->delete();
        }
    }

    /**
     * Función auxiliar para guardar o actualizar los datos de NormasFabricacion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NormasFabricacion  $norma
     * @return void
     */
    protected function saveNormasFabricacion(Request $request, NormasFabricacion $norma)
    {
        $norma->codigo = $request->input('codigo');
        $norma->descripcion = $request->input('descripcion');
        $norma->save();
    }
}
