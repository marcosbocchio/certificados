<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PdfEspecialController extends Controller
{
    
    getPdfEspecial($metodo, $cliente_id){
        $pdfEspecial = PdfEspecial::where('metodo', $metodo)->where('cliente_id', $cliente_id)->first();
        return response()->json($pdfEspecial);
    }

}
