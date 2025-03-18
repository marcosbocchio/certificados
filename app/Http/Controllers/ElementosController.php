<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ots;
use App\Clientes;
use \stdClass;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

class ElementosController extends Controller
{

    public function __construct()
    {

          $this->middleware(['role_or_permission:Sistemas|R_elementos'],['only' => ['callView']]);

    }

    public function callView($ot_id){

        $user = auth()->user();
        $ot_prop = Ots::with('cliente')->orderBy('numero', 'asc')->get();
        $header_titulo = "Reporte";
        $header_descripcion ="Seguimiento de elementos / Plano-isométrico";
        return view('elementos.elementos',compact('user','ot_prop','header_titulo','header_descripcion'));

    }

    public function  getElementos($ot_id,$plano,$elemento,$obra,$componente){

        $obra = $obra == 'null' ? '' : str_replace('--','/',$obra);
        $componente = $componente == 'null' ? '' : str_replace('--','/',$componente);
        $plano = $plano == 'null' ? '' : str_replace('--','/',$plano);
        $elemento = $elemento == 'null' ? '' : str_replace('--','/',$elemento);
        $page = Input::get('page', 1);
        $paginate = 10;
        $data = DB::select(DB::raw('CALL ReporteElementos(?,?,?,?,?)'), array($ot_id, $plano, $elemento, $obra, $componente));

        $offSet = ($page * $paginate) - $paginate;

        $itemsForCurrentPage = array_slice($data, $offSet, $paginate, true);
        $data = new \Illuminate\Pagination\LengthAwarePaginator(array_values($itemsForCurrentPage), count($data), $paginate, $page);
        return $data;

    }
}
