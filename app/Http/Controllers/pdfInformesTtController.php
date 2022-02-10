<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pdfInformesTtController extends Controller
{
    public function imprimir($id) {
        $informe = (new \App\Http\Controllers\InformesTtController)->show($id);
        dd($informe);
    }
}
