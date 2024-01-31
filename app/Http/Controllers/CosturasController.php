<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ots;
use App\Clientes;
use \stdClass;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

class CosturasController extends Controller
{

    public function __construct()
    {

          $this->middleware(['role_or_permission:Sistemas|R_costuras'],['only' => ['callView']]);

    }

    public function callView($ot_id){

        $user = auth()->user();
        $ot_prop = Ots::with('cliente')->find($ot_id);
        $header_titulo = "Reporte";
        $header_descripcion ="Seguimiento de costuras / Plano-isométrico";
        return view('costuras.costuras',compact('user','ot_prop','header_titulo','header_descripcion'));

    }

    public function  getCosturas($ot_id,$pk,$plano,$costura,$rechazados,$reparaciones,$soldador_id,$obra,$componente){

        $obra = $obra == 'null' ? '' : str_replace('--','/',$obra);
        $componente = $componente == 'null' ? '' : str_replace('--','/',$componente);

        $pk = $pk == 'null' ? '' : $pk;
        $plano = $plano == 'null' ? '' : $plano;
        $costura = $costura == 'null' ? '' : $costura;
        $rechazados = $rechazados == 'true' ? 1 : 0;
        $reparaciones = $reparaciones == 'true' ? 1 : 0;

        $page = Input::get('page', 1);
        Log::debug($page);
        $paginate = 10;
        $data = DB::select(DB::raw('CALL ReporteCosturas(?,?,?,?,?,?,?,?,?)'),array($ot_id,$pk,$plano,$costura,$rechazados,$reparaciones,$soldador_id,$obra,$componente));
        $offSet = ($page * $paginate) - $paginate;
        $itemsForCurrentPage = array_slice($data, $offSet, $paginate, true);
        $data = new \Illuminate\Pagination\LengthAwarePaginator(array_values($itemsForCurrentPage), count($data), $paginate, $page);
        
        return $data;

    }
}
