<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Frente;
use App\Models\Remito;
use App\Models\DetalleRemito;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class PlacasUsadasController extends Controller
{
    public function callView()
    {
        $user = auth()->user();
        $header_titulo = "Reportes";
        $header_descripcion = "Certificados";
        return view('reporte-placas.placa', compact('user', 'header_titulo', 'header_descripcion'));
    }

    public function getFrentes()
    {
        $frentes = Frente::select('id', 'codigo')->get();
        return response()->json($frentes);
    }

    public function getRemitos($frentes_selected)
    {
        $remitos = Remito::whereIn('frente_id', $frentes_selected)->select('id', 'prefijo', 'numero', 'fecha')->get();
        return response()->json($remitos);
    }

    public function getRemitosProductos($remitos_selected)
    {
        $detalles = DetalleRemito::whereIn('remito_id', $remitos_selected)->get();
        $productos = Producto::whereIn('id', $detalles->pluck('producto_id'))
            ->where('relacionado_a_placas_sn', 1)
            ->get(['id', 'nombre']);
        
        return response()->json($productos);
    }
}