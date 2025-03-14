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

    public function saveTrazabilidadFuente($interno_equipo_id, $interno_fuente_id, $activo_sn)
    {
        $user_id = Auth::check() ? Auth::id() : null;
        $fecha_actual = Carbon::now();
    
        // Se obtiene el registro de trazabilidad más reciente para este equipo.
        $trazabilidad_fuente_actual = TrazabilidadFuente::where('interno_equipo_id', $interno_equipo_id)
                                                          ->latest()
                                                          ->first();
    
        // Caso 1: No existe registro previo, se crea uno nuevo.
        if (!$trazabilidad_fuente_actual) {
            $nuevoRegistro = new TrazabilidadFuente;
            $nuevoRegistro->interno_equipo_id = $interno_equipo_id;
            $nuevoRegistro->interno_fuente_id = $interno_fuente_id;
            $nuevoRegistro->fecha_alta = $fecha_actual;
            // Si el equipo está inactivo, asignamos fecha de baja en el mismo registro.
            if ($activo_sn != 1) {
                $nuevoRegistro->fecha_baja = $fecha_actual;
            }
            $nuevoRegistro->user_id = $user_id;
            $interno_fuente = InternoFuentes::find($interno_fuente_id);
            $nuevoRegistro->curie = $interno_fuente->curie;
            $nuevoRegistro->save();
        } else {
            // Existe un registro previo.
            if ($trazabilidad_fuente_actual->interno_fuente_id == $interno_fuente_id) {
                // Caso 2: Se carga el mismo registro.
                if ($activo_sn != 1) {
                    // Si el equipo está inactivo y el registro aún no fue cerrado,
                    // asignamos la fecha de baja.
                    if (!$trazabilidad_fuente_actual->fecha_baja) {
                        $trazabilidad_fuente_actual->fecha_baja = $fecha_actual;
                        $trazabilidad_fuente_actual->save();
                    }
                } else {
                    // Caso 4: El mismo interno_fuente, pero se está reactivando el equipo.
                    // Si el registro actual ya tiene fecha de baja (se cerró por desactivación),
                    // se crea un nuevo registro.
                    if ($trazabilidad_fuente_actual->fecha_baja) {
                        $nuevoRegistro = new TrazabilidadFuente;
                        $nuevoRegistro->interno_equipo_id = $interno_equipo_id;
                        $nuevoRegistro->interno_fuente_id = $interno_fuente_id;
                        $nuevoRegistro->fecha_alta = $fecha_actual;
                        $nuevoRegistro->user_id = $user_id;
                        $interno_fuente = InternoFuentes::find($interno_fuente_id);
                        $nuevoRegistro->curie = $interno_fuente->curie;
                        $nuevoRegistro->save();
                    }
                    // Si el equipo está activo y el último registro sigue abierto,
                    // no se realiza ninguna acción.
                }
            } else {
                // Caso 3: Se carga un registro diferente.
                // Primero, se cierra el registro anterior si no lo está.
                if (!$trazabilidad_fuente_actual->fecha_baja) {
                    $trazabilidad_fuente_actual->fecha_baja = $fecha_actual;
                    $trazabilidad_fuente_actual->save();
                }
                // Luego, se crea el nuevo registro.
                $nuevoRegistro = new TrazabilidadFuente;
                $nuevoRegistro->interno_equipo_id = $interno_equipo_id;
                $nuevoRegistro->interno_fuente_id = $interno_fuente_id;
                $nuevoRegistro->fecha_alta = $fecha_actual;
                // Si el equipo está inactivo, se asigna fecha de baja en el nuevo registro.
                if ($activo_sn != 1) {
                    $nuevoRegistro->fecha_baja = $fecha_actual;
                }
                $nuevoRegistro->user_id = $user_id;
                $interno_fuente = InternoFuentes::find($interno_fuente_id);
                $nuevoRegistro->curie = $interno_fuente->curie;
                $nuevoRegistro->save();
            }
        }
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
