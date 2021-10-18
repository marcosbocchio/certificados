<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TrazabilidadEquipo;
use Illuminate\Support\Facades\Auth;

class TrazabilidadEquipoController extends Controller
{

    public function saveTrazabilidadEquipo($interno_equipo_id, $frente_id){

        $user_id = null;

        if (Auth::check())
        {
             $user_id = $userId = Auth::id();
        }

        $trazabilidad_equipo = new TrazabilidadEquipo;
        $trazabilidad_equipo->frente_id = $frente_id;
        $trazabilidad_equipo->interno_equipo_id = $interno_equipo_id;
        $trazabilidad_equipo->user_id = $user_id;
        $trazabilidad_equipo->save();
    }
}
