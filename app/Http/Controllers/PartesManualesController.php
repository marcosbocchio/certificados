<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\ParteManual;
use App\ParteManualDetalle;
use App\Informe;
use App\Clientes;
use App\Ots;
use App\Plantas;
use App\OtOperarios;
use App\User;
use App\MetodoEnsayos;
class PartesManualesController extends Controller
{
    
    public function index($ot_id)
    {
        $header_titulo = "Partes";
        $header_descripcion = "Alta | Modificación";
        $user = auth()->user();
        $header_sub_titulo = ' / ';

      
        $ot = Ots::findOrFail($ot_id);
        $cliente = Clientes::findOrFail($ot->cliente_id);
        $clienteNombre = $cliente->nombre_fantasia;
        log::info($cliente);
        $proyecto = $ot->proyecto;
        
        $ordenTrabajoNumero = $ot->numero;
        
        $plantas = Plantas::where('cliente_id', $ot->cliente_id)->get();


        $operador_opcion = obtenerNombresOperadoresPorOt($ot_id);

        
        return view('partes.manual', compact(
            'ot_id',
            'user',
            'header_titulo',
            'header_sub_titulo',
            'header_descripcion',
            'clienteNombre',
            'proyecto',
            'ordenTrabajoNumero',
            'plantas',
            'operador_opcion',
            'ot'
        ));
    }

    public function edit($id)
    {
        try {
            $header_titulo = "Partes";
            $header_descripcion = "Alta | Modificación";
            $user = auth()->user();
            $header_sub_titulo = ' / ';
            $parteManual = ParteManual::findOrFail($id);
            $fecha = $parteManual->fecha;
            $ot = Ots::findOrFail($parteManual->ot_id);
            $cliente = Clientes::findOrFail($ot->cliente_id);
            $clienteNombre = $cliente->nombre_fantasia;   
            $proyecto = $ot->proyecto;
            $ordenTrabajoNumero = $ot->numero;
            $detalles = ParteManualDetalle::where('parte_manual_id', $id)->get();
            $plantas = Plantas::where('cliente_id', $ot->cliente_id)->get();
            $operador_opcion = obtenerNombresOperadoresPorOt($ot->id);
            
            
            return view('partes.manual-edit', compact(
                'parteManual',
                'fecha',
                'ot',
                'cliente',
                'clienteNombre',
                'proyecto',
                'ordenTrabajoNumero',
                'detalles',
                'plantas',
                'operador_opcion',
                'header_titulo',
                'header_descripcion',
                'user',
                'header_sub_titulo',
            ));
        } catch (\Exception $e) {
            \Log::error('Error al cargar la edición de la parte manual: ' . $e->getMessage());
            abort(404);
        }
    }


    public function store(Request $request)
    {
        // Validación de datos recibidos
        $validatedData = $request->validate([
            'ordenTrabajo' => 'required|integer',
            'fecha' => 'required|date',
            'ot_obra' => 'required|string',
            'detalles' => 'required|array',
            'selectedInformes' => 'nullable|array',
            'selectedInformes.*' => 'integer',
        ]);

        try {
            \DB::beginTransaction();
            log::info('hola'.$request->ot_id);
            // Crear la parte manual
            $parteManual = ParteManual::create([
                'ot_id' => $request->ot_id,
                'obra' => $request->ot_obra,
                'fecha' => $request->fecha,
            ]);
            log::info($request->ot_obra . 'blabla');
            log::info($request->detalles);
            foreach ($request->detalles as $detalle) {
                ParteManualDetalle::create([
                    'parte_manual_id' => $parteManual->id,
                    'tecnica' => $detalle['tecnica'],
                    'cantidad' => $detalle['cantidad'],
                    'planta' => $detalle['planta']['label'], 
                    'equipo' => $detalle['equipo_linea'],
                    'operador1' => $detalle['operadores'][0] ?? null,
                    'operador2' => $detalle['operadores'][1] ?? null,
                    'horario' => $detalle['horario'],
                    'informe_nro' => $detalle['n_informe'],
                ]);
            }

            // Asociar los informes seleccionados
            if (!empty($validatedData['selectedInformes'])) {
                foreach ($validatedData['selectedInformes'] as $informeId) {
                    log::info('cambio:' . $informeId);
                    $informe = Informe::find($informeId);
                    if ($informe) {
                        $informe->parte_id = $parteManual->id;
                        $informe->parte_manual_sn = 1;
                        $informe->save();
                    }
                }
            }

            \DB::commit();
            return response()->json(['message' => 'Parte manual y detalles guardados exitosamente, informes asociados.', 'id' => $parteManual->id], 200);
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Error al guardar los datos: ' . $e->getMessage());
            return response()->json(['message' => 'Error al guardar: ' . $e->getMessage()], 500);
        }
    }
    

    public function getInformesSinParte(Request $request) {
        $fechaSeleccionada = $request->query('hasta');
        $otId = $request->query('ot_id');
        
        // Ajusta la consulta para obtener los informes que coincidan exactamente con la fecha seleccionada
        $informesSinParte = Informe::select('informes.*', 'metodo_ensayos.metodo', 'users.name as solicitante', 'plantas.nombre as nombre_planta')
                                    ->leftJoin('metodo_ensayos', 'informes.metodo_ensayo_id', '=', 'metodo_ensayos.id')
                                    ->leftJoin('users', 'informes.solicitado_por', '=', 'users.id')
                                    ->leftJoin('plantas', 'informes.planta_id', '=', 'plantas.id') // Unión con la tabla plantas
                                    ->where('informes.ot_id', $otId)
                                    ->whereNull('informes.parte_id')
                                    ->whereDate('informes.fecha', '=', $fechaSeleccionada) // Modificado para coincidir exactamente con la fecha
                                    ->get();

        return response()->json($informesSinParte);
    }
}