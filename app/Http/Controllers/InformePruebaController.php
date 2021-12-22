<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ots;
use Illuminate\Support\Facades\DB;
use App\InformePrueba;
use App\InformesView;
use App\InformesRev;
use App\MetodoEnsayos;
use App\DiametrosEspesor;
use Illuminate\Support\Facades\Auth;
use App\OtProcedimientosPropios;
use App\InformesImportados;
use \stdClass;
use Illuminate\Support\Facades\Log;
use Exception as Exception;
use PhpParser\Node\Stmt\Else_;

class InformePruebaController extends Controller
{
    public function index()
    {
        $header_titulo = "Informes";
        $header_descripcion ="Alta | Modificación";
        $user = auth()->user();
        $header_sub_titulo =' / ';

        return view('ot-informes.prueba',compact('user',
                                                'header_titulo',
                                                'header_sub_titulo',
                                                'header_descripcion'));
    }
}
