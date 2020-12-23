<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

class CosturasController extends Controller
{

    public function __construct()
    {

          $this->middleware(['role_or_permission:Sistemas|R_costuras'],['only' => ['callView']]);

    }

    public function callView(){

        $user = auth()->user();
        $header_titulo = "Reporte";
        $header_descripcion ="Seguimiento de costuras / Plano-isométrico";
        return view('costuras.costuras',compact('user','header_titulo','header_descripcion'));

    }

    public function  getCosturas($ot_id,$pk,$plano,$costura,$rechazados,$reparaciones){

        $pk = $pk == 'null' ? '' : $pk;
        $plano = $plano == 'null' ? '' : $plano;
        $costura = $costura == 'null' ? '' : $costura;
        $rechazados = $rechazados == 'true' ? 1 : 0;
        $reparaciones = $reparaciones == 'true' ? 1 : 0;

        $page = Input::get('page', 1);
        $paginate = 10;

        $data = DB::select(DB::raw('CALL ReporteCosturas(?,?,?,?,?,?)'),array($ot_id,$pk,$plano,$costura,$rechazados,$reparaciones));
        $offSet = ($page * $paginate) - $paginate;
        $itemsForCurrentPage = array_slice($data, $offSet, $paginate, true);
        $data = new \Illuminate\Pagination\LengthAwarePaginator(array_values($itemsForCurrentPage), count($data), $paginate, $page);
        return $data;

    }
}
