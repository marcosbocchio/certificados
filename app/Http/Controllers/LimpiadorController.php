<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LimpiadorController extends Controller
{
    public function callView()
    {
        $user = auth()->user();
        $header_titulo = "GESTIONAR MULTIMEDIA";
        $header_descripcion =" ";

        return view('videos.crear-contenido', compact('user','header_titulo','header_descripcion'));
    }
}
