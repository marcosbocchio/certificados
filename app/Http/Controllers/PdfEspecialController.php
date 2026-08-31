<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MetodoEnsayos;
use App\PdfEspecial;
use Illuminate\Support\Facades\Log;

class PdfEspecialController extends Controller
{
    
    public function getPdfEspecial($metodo, $cliente_id){

        $cliente_id = $this->resolverClienteId($cliente_id);
        $metodo_ensayo = MetodoEnsayos::where('metodo', $metodo)->first();
        log::Debug('metodo_ensayo: '.json_encode($metodo_ensayo));
        $pdfEspecial = PdfEspecial::where('metodo_ensayo_id', $metodo_ensayo->id)->where('cliente_id', $cliente_id)->get();
        return response()->json($pdfEspecial);
    }

}