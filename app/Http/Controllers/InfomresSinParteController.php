<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // No olvides importar la fachada DB
use Carbon\Carbon; // Don't forget to import Carbon for date handling
use Illuminate\Pagination\LengthAwarePaginator; // ¡Esta es la línea que falta o está incorrecta!
use App\Ots;      // Asegúrate de importar el modelo Ots
use App\Clientes; // Asegúrate de importar el modelo Clientes

class InfomresSinParteController extends Controller
{
    public function informesSinParteView(){

        $user = auth()->user();
        $header_titulo = "informes sin parte";
        $header_descripcion =".";
        $ots_data = Ots::select('id', 'numero')->get();
        $clientes_data = Clientes::select('id', 'nombre_fantasia', 'razon_social')
                            ->orderBy('nombre_fantasia') // Agrega esta línea para ordenar
                            ->get();
        return view('reporte-infomres-sin-parte.reportes',compact('user','header_titulo','header_descripcion','ots_data', 'clientes_data'));

    }
    /**
     * Obtiene informes pendientes de parte diario con filtros opcionales desde la URL.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $ot_id          The OT ID from the URL path, can be 'null' string.
     * @param  string  $obra           The project name from the URL path, can be 'null' string.
     * @param  string  $fecha_desde    The start date from the URL path, can be 'null' string.
     * @param  string  $fecha_hasta    The end date from the URL path, can be 'null' string.
     * @return \Illuminate\Http\JsonResponse
     */
    public function obtenerInformesSinParte(
        Request $request,
        $cliente_id = null,    // Ahora viene directamente de la ruta
        $ot_id = null,
        $fecha_desde = null,
        $fecha_hasta = null
    ) {
        // Preparar parámetros para el SP:
        // Convertimos 'null' string o null a 0 para que el SP lo ignore.
        $clienteIdParam = ($cliente_id === 'null' || $cliente_id === null) ? 0 : (int)$cliente_id;
        $otIdParam = ($ot_id === 'null' || $ot_id === null) ? 0 : (int)$ot_id;

        // Las fechas se convierten a cadenas 'YYYY-MM-DD' o a fechas muy lejanas para el "ignorar"
        $fechaDesdeParam = ($fecha_desde === 'null' || $fecha_desde === null) ? '1900-01-01 00:00:00' : Carbon::parse($fecha_desde)->startOfDay()->toDateTimeString();
        $fechaHastaParam = ($fecha_hasta === 'null' || $fecha_hasta === null) ? '2100-12-31 23:59:59' : Carbon::parse($fecha_hasta)->endOfDay()->toDateTimeString();

        // Configuración de paginación:
        // El número de página siempre se obtiene de los query parameters (?page=X)
        $page = $request->query('page', 1);
        $perPage = 10;

        try {
            // Llamada al Procedimiento Almacenado con los 4 parámetros de filtro
            $rawResults = DB::select(
                'CALL informesSinParteReporte(?,?,?,?)',
                [
                    $clienteIdParam,
                    $otIdParam,
                    $fechaDesdeParam,
                    $fechaHastaParam
                ]
            );

            // Paginación manual de los resultados
            $totalResults = count($rawResults);
            $offset = ($page - 1) * $perPage;
            $itemsForCurrentPage = array_slice($rawResults, $offset, $perPage);

            // Crear instancia de LengthAwarePaginator
            $informesPaginados = new LengthAwarePaginator(
                $itemsForCurrentPage,
                $totalResults,
                $perPage,
                $page,
                ['path' => url()->current()]
            );

            return response()->json($informesPaginados);

        } catch (\Exception $e) {
            \Log::error('Error al obtener informes sin parte: ' . $e->getMessage());
            return response()->json(['error' => 'No se pudieron recuperar los informes. Por favor, inténtelo de nuevo más tarde.'], 500);
        }
    }

}
