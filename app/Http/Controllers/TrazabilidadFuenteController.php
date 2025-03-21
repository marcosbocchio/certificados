<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\TrazabilidadFuente;
use App\InternoFuentes;
use Carbon\carbon;
use App\InternoEquipos;
use Illuminate\Support\Facades\Log;

class TrazabilidadFuenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    public function saveTrazabilidadFuente($interno_equipo_id, $interno_fuente_id, $old_interno_fuente_id = null)
    {
        $fecha_actual = Carbon::now();
        $user_id = Auth::check() ? Auth::id() : null;
    
        // Caso: Si no se proporciona interno_fuente_id,
        // se cierra el registro activo del old_interno_fuente_id (si existe) y se finaliza.
        if (is_null($interno_fuente_id)) {
            if (!is_null($old_interno_fuente_id)) {
                $registro = TrazabilidadFuente::where('interno_equipo_id', $interno_equipo_id)
                    ->where('interno_fuente_id', $old_interno_fuente_id)
                    ->whereNull('fecha_baja')
                    ->orderBy('fecha_alta', 'desc')
                    ->first();
    
                if ($registro) {
                    $registro->fecha_baja = $fecha_actual;
                    $registro->save();
                    Log::info("Se asignó fecha de baja para old_interno_fuente_id: {$old_interno_fuente_id} en equipo {$interno_equipo_id}");
                } else {
                    Log::warning("No se encontró registro activo para old_interno_fuente_id: {$old_interno_fuente_id} en equipo {$interno_equipo_id}");
                }
            } else {
                Log::warning("No se proporcionó interno_fuente_id ni old_interno_fuente_id para equipo {$interno_equipo_id}");
            }
            return;
        }
    
        // Si se proporciona old_interno_fuente_id, comparamos
        if (!is_null($old_interno_fuente_id)) {
            // Si los IDs son iguales, no se realiza acción.
            if ($interno_fuente_id == $old_interno_fuente_id) {
                return;
            } else {
                // Si son diferentes, se busca el registro activo del old_interno_fuente_id y se le asigna la fecha de baja.
                $registro = TrazabilidadFuente::where('interno_equipo_id', $interno_equipo_id)
                    ->where('interno_fuente_id', $old_interno_fuente_id)
                    ->whereNull('fecha_baja')
                    ->orderBy('fecha_alta', 'desc')
                    ->first();
    
                if ($registro) {
                    $registro->fecha_baja = $fecha_actual;
                    $registro->save();
                    Log::info("Se asignó fecha de baja para old_interno_fuente_id: {$old_interno_fuente_id} en equipo {$interno_equipo_id}");
                } else {
                    Log::warning("No se encontró registro activo para old_interno_fuente_id: {$old_interno_fuente_id} en equipo {$interno_equipo_id}");
                }
            }
        }
    
        // En ambos casos (ya sea que no se haya proporcionado old_interno_fuente_id
        // o se haya proporcionado y sea distinto) se crea un nuevo registro con el interno_fuente_id actual.
        $nuevoRegistro = new TrazabilidadFuente;
        $nuevoRegistro->interno_equipo_id = $interno_equipo_id;
        $nuevoRegistro->interno_fuente_id = $interno_fuente_id;
        $nuevoRegistro->fecha_alta = $fecha_actual;
        $nuevoRegistro->user_id = $user_id;
        
        // Buscar la fuente usando fuente_id en lugar de la llave primaria
        $interno_fuente = InternoFuentes::where('fuente_id', $interno_fuente_id)->first();
        if ($interno_fuente) {
            $nuevoRegistro->curie = $interno_fuente->curie;
        } else {
            Log::warning("No se encontró registro en InternoFuentes para fuente_id: {$interno_fuente_id}");
        }
        $nuevoRegistro->save();
    }
    

    
    

    public function getTrazabilidad(Request $request,$interno_equipo_id){

        $page = $request->page;
        $trazabilidad_fuente = TrazabilidadFuente::where('interno_equipo_id',$interno_equipo_id)->with('internoFuente.fuente')->orderBy('fecha_alta','desc')->paginate(10);

        return $trazabilidad_fuente;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
