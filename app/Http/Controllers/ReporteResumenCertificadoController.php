<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use App\Provincias;
use App\Localidades;

class ReporteResumenCertificadoController extends Controller
{
    public function __construct()
    {
        $this->middleware(
            ['role_or_permission:Sistemas|R_placas'],
            ['only' => ['callView']]
        );
    }

    public function callView()
    {
        $user = auth()->user();
        $header_titulo = 'Reportes';
        $header_descripcion = 'Resumen certificado';
        return view(
            'reporte-resumen-certificado.resumen-certificado',
            compact('user', 'header_titulo', 'header_descripcion')
        );
    }

    public function resumenServiciosPorCertificado(
        $cliente_id,
        $ot_id,
        $provincia,
        $fecha_desde,
        $fecha_hasta
    ) {
        $cliente_id = $cliente_id == 'null' ? 0 : $cliente_id;
        $ot_id = $ot_id == 'null' ? 0 : $ot_id;
        $provincia = $provincia == 'null' ? 0 : $provincia;

        if ($fecha_desde == 'null') {
            $fecha_desde = date('2000-01-01');
        }

        if ($fecha_hasta == 'null') {
            $fecha_hasta = date('2100-01-01');
        }

        DB::select('CALL armadoReporteServicios(?,?,?,?,?)', [
            $cliente_id,
            $ot_id,
            $provincia,
            $fecha_desde,
            $fecha_hasta,
        ]);
        $data = DB::select('CALL getResumenServicios()');

        return $data;
    }

    public function dataPlacaMedidas(
        $cliente_id,
        $ot_id,
        $provincia,
        $fecha_desde,
        $fecha_hasta
    ) {
        $cliente_id = $cliente_id == 'null' ? 0 : $cliente_id;
        $ot_id = $ot_id == 'null' ? 0 : $ot_id;
        $provincia = $provincia == 'null' ? 0 : $provincia;

        if ($fecha_desde == 'null') {
            $fecha_desde = date('2000-01-01');
        }

        if ($fecha_hasta == 'null') {
            $fecha_hasta = date('2100-01-01');
        }
        $data = DB::select('CALL reportePlacasMedidas(?,?,?,?,?)', [
            $cliente_id,
            $ot_id,
            $provincia,
            $fecha_desde,
            $fecha_hasta,
        ]);
        return $data;
    }
    public function tituloMedidasDinamicas()
    {
        DB::select('CALL medidasParaTituloReporte()');
        $data = DB::select('CALL medidasParaTituloReporte()');
        return $data;
    }
    public function medidaPulgadaTituloReporte()
    {
        DB::select('CALL medidaPulgadaTituloReporte()');
        $data = DB::select('CALL medidaPulgadaTituloReporte()');
        return $data;
    }
    public function medidaCmTituloReporte()
    {
        DB::select('CALL medidaCmTituloReporte()');
        $data = DB::select('CALL medidaCmTituloReporte()');
        return $data;
    }
}
