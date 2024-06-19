<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Frentes;
use App\User;
use App\FrentesOperador;

class FrentesAsignacionController extends Controller
{
    public function callView()
    {
        $user = auth()->user();
        $header_titulo = "Frentes";
        $header_descripcion = "Alta | Baja | Modificación";
        return view('frentesAsignacion', compact('user', 'header_titulo', 'header_descripcion'));
    }

    public function getFrentes(Request $request)
    {
        $perPage = 10; // Número de elementos por página
        $frentes = Frentes::orderBy('codigo')->paginate($perPage);
        return response()->json($frentes);
    }

    public function store(Request $request)
    {
        Frentes::create([
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'horas_diarias_laborables' => $request->horas_diarias_laborables,
            'centro_distribucion_sn' => $request->centro_distribucion_sn,
            'controla_hs_extras_sn' => $request->controla_hs_extras_sn,
        ]);

        return response()->json(['message' => 'Frente creado con éxito'], 201);
    }

    public function update(Request $request, $id)
    {
        $frente = Frentes::findOrFail($id);

        $frente->update([
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'horas_diarias_laborables' => $request->horas_diarias_laborables,
            'centro_distribucion_sn' => $request->centro_distribucion_sn,
            'controla_hs_extras_sn' => $request->controla_hs_extras_sn,
        ]);

        return response()->json(['message' => 'Frente actualizado con éxito'], 200);
    }

    public function getUser()
    {
        $usuarios = User::whereNull('cliente_id')
                        ->where('habilitado_sn', 1)
                        ->orderBy('name', 'asc')
                        ->get();
        return response()->json($usuarios);
    }

    public function getUserFrente($id_frente)
    {
        $usuarios = User::whereHas('frentesOperador', function($query) use ($id_frente) {
            $query->where('frente_id', $id_frente);
        })->get();
    
        return response()->json(['usuarios' => $usuarios]);
    }

    public function updateFrenteUsuarios(Request $request)
    {
        $frenteId = $request->input('frente_id');
        $usuarioIds = $request->input('usuarios_asociados');
        // Eliminar todas las asociaciones actuales del frente
        FrentesOperador::where('frente_id', $frenteId)->delete();

        // Crear nuevas asociaciones
        foreach ($usuarioIds as $usuarioId) {
            FrentesOperador::create([
                'frente_id' => $frenteId,
                'user_id' => $usuarioId,
            ]);
        }

        return response()->json(['message' => 'Operación exitosa'], 200);
    }
}