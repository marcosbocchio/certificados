<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProveedorRequest; // Asegúrate de importar tu ProveedorRequest
use App\Proveedor; // Usa el namespace correcto para tu modelo Proveedor
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProveedoresController extends Controller
{

    public function __construct()
    {

     $this->middleware(['role_or_permission:Sistemas|M_proveedores'],['only' => ['callView']]);

    }

    public function index()
    {
        return Proveedor::orderBy('razon_social', 'ASC')->get();
    }
    public function getProveedores()
    {
        return Proveedor::orderBy('razon_social', 'ASC')->get();
    }

    public function store(ProveedorRequest $request)
    {

        log::info('estamos en controller'. $request);

        DB::beginTransaction();
        try {
            $proveedor = new Proveedor;

            // campos específicos en el request recibido.
            $proveedor->cuit = $request['cuit'];
            $proveedor->razon_social = $request['razon_social'];
            $proveedor->email = $request['email'];
            $proveedor->tel = $request['tel'];
            
            $proveedor->save(); // Guardar el nuevo proveedor en la base de datos.

            DB::commit(); // Confirmar la transacción.

            return response()->json(['message' => 'Proveedor creado exitosamente.', 'proveedor' => $proveedor], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error al crear el proveedor: ' . $e->getMessage(), [
                'exception' => $e,
            ]);
            return response()->json(['message' => 'Error al crear el proveedor', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $proveedor = Proveedor::find($id);
        if (!$proveedor) {
            return response()->json(['message' => 'Proveedor no encontrado.'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($proveedor);
    }

    public function callView()
    {
        $user = auth()->user(); // Obtener el usuario autenticado
        $header_titulo = "Proveedores"; // Título para la página
        $header_descripcion = "Alta | Baja | Modificación"; // Descripción o subtítulo para la página

        // Retornar la vista de proveedores, pasando los datos necesarios
        return view('proveedores', compact('user', 'header_titulo', 'header_descripcion'));
    }

    public function update(ProveedorRequest $request, $id)
        {
            try {
                Log::info('Actualizando proveedor', ['id' => $id]);
                $proveedor = Proveedor::findOrFail($id);
                $proveedor->update($request->validated());
                return response()->json(['message' => 'Proveedor actualizado exitosamente.', 'proveedor' => $proveedor]);
            } catch (\Exception $e) {
                Log::error('Error al actualizar proveedor', ['error' => $e->getMessage()]);
                return response()->json(['message' => 'Error al actualizar el proveedor', 'error' => $e->getMessage()], 500);
            }
        }

    public function destroy($id)
    {
        $proveedor = Proveedor::find($id);
        if (!$proveedor) {
            return response()->json(['message' => 'Proveedor no encontrado.'], Response::HTTP_NOT_FOUND);
        }

        DB::beginTransaction();
        try {
            $proveedor->delete();
            DB::commit();
            return response()->json(['message' => 'Proveedor eliminado exitosamente.'], Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Error al eliminar el proveedor', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function paginate(Request $request)
    {
        $filtro = $request->search;
        $proveedores = Proveedor::when($filtro, function ($query, $filtro) {
            return $query->where('cuit', 'LIKE', "%{$filtro}%")
                         ->orWhere('razon_social', 'LIKE', "%{$filtro}%");
        })
        ->orderBy('id', 'DESC')
        ->paginate(10);
    
        return response()->json($proveedores);
    }
}