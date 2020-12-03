<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NotificacionesResumenView;

class NotificacionesResumenViewController extends Controller
{

    public function getResumenUsuario($user_id)

    {
        return NotificacionesResumenView::where('user_id',$user_id)->orderBy('tipo','asc')->get();

    }
}
