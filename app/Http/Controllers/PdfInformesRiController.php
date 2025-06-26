<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\helpers; // Asegúrate de que esta clase está disponible y sus funciones son eficientes
use App\Informe;
use App\InformesRi;
use App\Plantas;
use App\Ots;
use App\Clientes;
use App\Materiales;
use App\NormaEnsayos;
use App\NormaEvaluaciones;
use App\Documentaciones;
use App\Equipos;
use App\Fuentes;
use App\TipoPeliculas;
use App\DiametrosEspesor;
use App\InternoEquipos;
use App\InternoFuentes;
use App\Icis;
use App\Tecnicas;
use App\EjecutorEnsayo;
use App\User;
use App\TecnicasGraficos;
use PDF; // Asegúrate de que esta es la librería PDF que usas (ej: Barryvdh\DomPDF)
use App\Juntas;
use App\Tramos;
use App\Soldadores;
use Illuminate\Support\Facades\Log;
use App\Posicion;
use App\PasadasPosicion;
use App\DefectosPasadasPosicion;
use App\OtOperarios;
use App\OtProcedimientosPropios;
use App\Contratistas;
use App\OtTipoSoldaduras;
use App\MetodoEnsayos;
use App\FirmaUsuario;
use App\InformesRiElementosView;
use App\DefectosEsp;

class PdfInformesRiController extends Controller
{
    public function imprimir($id, $informeEspecialParam = null)
    {
        // --- INICIO DE MEDICIÓN GENERAL DEL REQUEST ---
        $requestStartTime = microtime(true);
        Log::info("--- INICIO DE GENERACIÓN DE PDF PARA INFORME ID: {$id} ---");

        /* ====================================================================
         * SECCIÓN 1: Carga de Datos del Header (Común a todas las rutas de PDF)
         * ==================================================================== */
        $headerStartTime = microtime(true);

        $informe = Informe::findOrFail($id);
        $numero_repetido = $informe->numero_repetido;
        $metodo_ensayo = MetodoEnsayos::find($informe->metodo_ensayo_id);
        $informe_ri = InformesRi::where('informe_id', $informe->id)->firstOrFail();
        $planta = Plantas::where('id', $informe->planta_id)->first();
        $ot = Ots::findOrFail($informe->ot_id);

        $cliente = Clientes::findOrFail($ot->cliente_id);

        $ot_tipo_soldadura = OtTipoSoldaduras::where('id', $informe->ot_tipo_soldadura_id)->with('Tiposoldadura')->first();

        $material = Materiales::findOrFail($informe->material_id);
        $material2 = Materiales::find($informe->material2_id);
        $norma_ensayo = NormaEnsayos::findOrFail($informe->norma_ensayo_id);
        $norma_evaluacion = NormaEvaluaciones::findOrFail($informe->norma_evaluacion_id);
        $ot_procedimiento_propio = OtProcedimientosPropios::findOrFail($informe->procedimiento_informe_id);
        $procedimiento_inf = Documentaciones::findOrFail($ot_procedimiento_propio->documentacion_id);
        $interno_equipo = InternoEquipos::where('id', $informe->interno_equipo_id)->with('equipo')->first();
        $interno_fuente = InternoFuentes::where('id', $informe_ri->interno_fuente_id)->first();
        // Nota: curie() es una función auxiliar, su rendimiento debería ser evaluado por separado si es un cuello de botella.
        $actividad = $interno_fuente ? curie($interno_fuente->id, $informe->fecha) : '';
        $tipo_pelicula = TipoPeliculas::findOrFail($informe_ri->tipo_pelicula_id);
        $diametro_espesor = $informe->diametro_espesor_id ? DiametrosEspesor::findOrFail($informe->diametro_espesor_id) : null;
        $ici = Icis::findOrFail($informe_ri->ici_id);
        $tecnica = Tecnicas::findOrFail($informe->tecnica_id);
        $ot_operador = OtOperarios::findOrFail($informe->ejecutor_ensayo_id);
        $ejecutor_ensayo = User::findOrFail($ot_operador->user_id);
        $tecnicas_grafico = TecnicasGraficos::findOrFail($informe_ri->tecnicas_grafico_id);
        $evaluador = User::find($informe->firma);
        // Nota: getFirma() es un método de controlador, su rendimiento debería ser evaluado por separado.
        $firma = (new \App\Http\Controllers\UserController)->getFirma($informe->firma, $metodo_ensayo->id);
        $contratista = Contratistas::find($ot->contratista_id);

        $observaciones = $informe->observaciones;
        // Nota: getInformeModelos3d() es un método de controlador, su rendimiento debería ser evaluado por separado.
        $informe_modelos_3d = (new \App\Http\Controllers\InformeModelos3dController)->getInformeModelos3d($id);
        $informe_solicitado_por = User::where('id', $informe->solicitado_por)->first();

        // Esta línea estaba mal ubicada en tu código original, no tiene efecto en $informeEspecialParam
        // $informeEspecial = null;
        // obtenerInformeEspecial($ot, $metodo_ensayo, $informeEspecial);

        $headerEndTime = microtime(true);
        $headerDuration = ($headerEndTime - $headerStartTime) * 1000;
        Log::info("TIEMPO: Carga de Datos del Header: {$headerDuration} ms");

        /* ====================================================================
         * SECCIÓN 2: Lógica Condicional del Informe (informeEspecialParam)
         * ==================================================================== */
        // Usamos $informeEspecialParam para mantener el valor pasado por la URL o función.
        if ($informeEspecialParam !== null) {
            $detalleStartTime = microtime(true);

            $blade = $informeEspecialParam; // Usamos el parámetro directamente

            // Lógica común de encabezado para esta rama
            $titulo = "RADIOGRAFIA INDUSTRIAL";
            $nro = $numero_repetido === 1 ? FormatearNumeroInforme($informe->numero, $metodo_ensayo->metodo) . ' - Rev.' . FormatearNumeroConCeros($informe->revision, 2) : FormatearNumeroInforme($informe->numero, $metodo_ensayo->metodo) . '-' . $numero_repetido . ' - Rev.' . FormatearNumeroConCeros($informe->revision, 2);
            $nroAESA = FormatearNumeroConCeros($informe->numero, 5);
            $fecha = date('d-m-Y', strtotime($informe->fecha));
            $tipo_reporte = "INFORME N°";

            if ($blade == 'informeRiPlantaAESA') {
                $juntas_posiciones = DB::select('CALL InformeRiPlantaJuntaPosicionAESA(?)', array($informe_ri->id));
                $defectos_posiciones = DB::select('CALL InformeRiPlantaDefectosPasadaPosicion(?)', array($informe_ri->id));
                if ($contratista && $contratista->nombre === 'ENOD') {
                    $ot->logo_contratista_sn = 1;
                }
            } else {
                // Aquí se usaría el SP de tu consulta original si $blade no es AESA
                $juntas_posiciones = DB::select('CALL InformeRiPlantaJuntaPosicion(?)', array($informe_ri->id));
                $defectos_posiciones = DB::select('CALL InformeRiPlantaDefectosPasadaPosicion(?)', array($informe_ri->id));
            }
            $juntas_posiciones_procesos = DB::select('CALL juntas_posiciones_procesos(?)', array($informe_ri->id));

            $detalleEndTime = microtime(true);
            $detalleDuration = ($detalleEndTime - $detalleStartTime) * 1000;
            Log::info("TIEMPO: Carga de Datos - Rama 'informeEspecial': {$detalleDuration} ms");

            // --- SECCIÓN: Renderizado y Stream del PDF ---
            $pdfRenderStartTime = microtime(true);
            $pdf = PDF::loadView('reportes.informes.' . $blade, compact(
                'titulo', 'nro', 'tipo_reporte', 'fecha', 'ot', 'norma_ensayo',
                'planta', 'norma_evaluacion', 'procedimiento_inf', 'ot_tipo_soldadura',
                'interno_equipo', 'actividad', 'interno_fuente', 'tipo_pelicula',
                'diametro_espesor', 'ici', 'tecnica', 'ejecutor_ensayo', 'cliente',
                'contratista', 'informe', 'informe_ri', 'material', 'material2',
                'tecnicas_grafico', 'juntas_posiciones', 'defectos_posiciones',
                'evaluador', 'informe_modelos_3d', 'firma', 'numero_repetido',
                'informe_solicitado_por', 'nroAESA', 'juntas_posiciones_procesos',
                'observaciones'
            ))->setPaper('a4', 'portrait')->setWarnings(false);

            $pdfRenderEndTime = microtime(true);
            $pdfRenderDuration = ($pdfRenderEndTime - $pdfRenderStartTime) * 1000;
            Log::info("TIEMPO: Renderizado y Stream del PDF - Rama 'informeEspecial': {$pdfRenderDuration} ms");

            $requestEndTime = microtime(true);
            $totalDuration = ($requestEndTime - $requestStartTime) * 1000;
            Log::info("--- FIN DE GENERACIÓN DE PDF: {$totalDuration} ms ---");

            return $pdf->stream();
        }

        /* ====================================================================
         * SECCIÓN 3: Lógica Condicional del Informe (perfil_sn)
         * ==================================================================== */
        if ($informe_ri->perfil_sn) {
            $detalleStartTime = microtime(true);

            // Lógica común de encabezado para esta rama
            $titulo = "RADIOGRAFIA INDUSTRIAL";
            $nro = $numero_repetido === 1 ? FormatearNumeroInforme($informe->numero, $metodo_ensayo->metodo) . ' - Rev.' . FormatearNumeroConCeros($informe->revision, 2) : FormatearNumeroInforme($informe->numero, $metodo_ensayo->metodo) . '-' . $numero_repetido . ' - Rev.' . FormatearNumeroConCeros($informe->revision, 2);
            $fecha = date('d-m-Y', strtotime($informe->fecha));
            $tipo_reporte = "INFORME N°";

            $tamaño_bola = '25,4 mm';
            // Nota: getTramos() es un método de controlador, su rendimiento debería ser evaluado por separado.
            $detalles2 = (new \App\Http\Controllers\InformesRiController)->getTramos($informe_ri->id);
            $detalles = Tramos::with('referencia')
                                ->where('informes_ri_id', $informe_ri->id)
                                ->get();

            $detalleEndTime = microtime(true);
            $detalleDuration = ($detalleEndTime - $detalleStartTime) * 1000;
            Log::info("TIEMPO: Carga de Datos - Rama 'perfil_sn': {$detalleDuration} ms");

            // --- SECCIÓN: Renderizado y Stream del PDF ---
            $pdfRenderStartTime = microtime(true);
            $pdf = PDF::loadView('reportes.informes.ri-perfiles-v2', compact(
                'titulo', 'nro', 'tipo_reporte', 'fecha', 'ot', 'norma_ensayo',
                'planta', 'norma_evaluacion', 'procedimiento_inf', 'ot_tipo_soldadura',
                'interno_equipo', 'actividad', 'interno_fuente', 'tipo_pelicula',
                'diametro_espesor', 'ici', 'tecnica', 'ejecutor_ensayo', 'cliente',
                'contratista', 'informe', 'informe_ri', 'material', 'material2',
                'tecnicas_grafico', 'detalles', 'tamaño_bola', 'evaluador',
                'informe_modelos_3d', 'firma', 'numero_repetido', 'informe_solicitado_por',
                'observaciones'
            ))->setPaper('a4', 'portrait')->setWarnings(false);

            $pdfRenderEndTime = microtime(true);
            $pdfRenderDuration = ($pdfRenderEndTime - $pdfRenderStartTime) * 1000;
            Log::info("TIEMPO: Renderizado y Stream del PDF - Rama 'perfil_sn': {$pdfRenderDuration} ms");

            $requestEndTime = microtime(true);
            $totalDuration = ($requestEndTime - $requestStartTime) * 1000;
            Log::info("--- FIN DE GENERACIÓN DE PDF: {$totalDuration} ms ---");

            return $pdf->stream();
        }

        /* ====================================================================
         * SECCIÓN 4: Lógica Condicional del Informe (gasoducto_sn)
         * ==================================================================== */
        if ($informe_ri->gasoducto_sn) {
            $detalleStartTime = microtime(true);

            // Lógica común de encabezado para esta rama
            $titulo = "RADIOGRAFIA INDUSTRIAL";
            $nro = $numero_repetido === 1 ? FormatearNumeroInforme($informe->numero, $metodo_ensayo->metodo) . ' - Rev.' . FormatearNumeroConCeros($informe->revision, 2) : FormatearNumeroInforme($informe->numero, $metodo_ensayo->metodo) . '-' . $numero_repetido . ' - Rev.' . FormatearNumeroConCeros($informe->revision, 2);
            $fecha = date('d-m-Y', strtotime($informe->fecha));
            $tipo_reporte = "INFORME N°";

            /* Recupero la Max cantidad de pasadas del informe , si tiene más de 6 uso una plantilla especial */
            $max_pasadas = InformesRiElementosView::where('informe_id', $id)->max('cantidad_pasadas');
            log::info($max_pasadas);
            $plantilla = ($max_pasadas > 6) ? 'ri-gasoducto-12-v2' : 'ri-gasoducto-6-v2';

            $juntas_posiciones = DB::select('CALL InformeRiGasoductoJuntaPosicion(?)', array($informe_ri->id));
            $pasadas_juntas = DB::select('CALL InformeRiGasoductoPasadasJuntas(?)', array($informe_ri->id));
            $defectos_posiciones = DB::select('CALL InformeRiGasoductoDefectosPasadasPosicion(?)', array($informe_ri->id));

            $detalleEndTime = microtime(true);
            $detalleDuration = ($detalleEndTime - $detalleStartTime) * 1000;
            Log::info("TIEMPO: Carga de Datos - Rama 'gasoducto_sn': {$detalleDuration} ms");

            // --- SECCIÓN: Renderizado y Stream del PDF ---
            $pdfRenderStartTime = microtime(true);
            $pdf = PDF::loadView('reportes.informes.' . $plantilla, compact(
                'titulo', 'nro', 'tipo_reporte', 'fecha', 'ot', 'planta',
                'norma_ensayo', 'norma_evaluacion', 'procedimiento_inf',
                'interno_equipo', 'ot_tipo_soldadura', 'actividad', 'interno_fuente',
                'tipo_pelicula', 'diametro_espesor', 'ici', 'tecnica', 'ejecutor_ensayo',
                'cliente', 'contratista', 'informe', 'informe_ri', 'material',
                'material2', 'tecnicas_grafico', 'juntas_posiciones',
                'pasadas_juntas', 'defectos_posiciones', 'evaluador',
                'informe_modelos_3d', 'firma', 'numero_repetido',
                'informe_solicitado_por', 'observaciones'
            ))->setPaper('a4', 'landscape')->setWarnings(false);

            $pdfRenderEndTime = microtime(true);
            $pdfRenderDuration = ($pdfRenderEndTime - $pdfRenderStartTime) * 1000;
            Log::info("TIEMPO: Renderizado y Stream del PDF - Rama 'gasoducto_sn': {$pdfRenderDuration} ms");

            $requestEndTime = microtime(true);
            $totalDuration = ($requestEndTime - $requestStartTime) * 1000;
            Log::info("--- FIN DE GENERACIÓN DE PDF: {$totalDuration} ms ---");

            return $pdf->stream();
        }

        /* ====================================================================
         * SECCIÓN 5: Lógica Condicional del Informe (por defecto)
         * ==================================================================== */
        // Este bloque se ejecuta si ninguna de las condiciones anteriores se cumple.
        else {
            $detalleStartTime = microtime(true);

            // Lógica común de encabezado para esta rama
            $titulo = "RADIOGRAFIA INDUSTRIAL";
            $nro = $numero_repetido === 1 ? FormatearNumeroInforme($informe->numero, $metodo_ensayo->metodo) . ' - Rev.' . FormatearNumeroConCeros($informe->revision, 2) : FormatearNumeroInforme($informe->numero, $metodo_ensayo->metodo) . '-' . $numero_repetido . ' - Rev.' . FormatearNumeroConCeros($informe->revision, 2);
            $fecha = date('d-m-Y', strtotime($informe->fecha));
            $tipo_reporte = "INFORME N°";

            $juntas_posiciones = DB::select('CALL InformeRiPlantaJuntaPosicion(?)', array($informe_ri->id));
            $defectos_posiciones = DB::select('CALL InformeRiPlantaDefectosPasadaPosicion(?)', array($informe_ri->id));

            $detalleEndTime = microtime(true);
            $detalleDuration = ($detalleEndTime - $detalleStartTime) * 1000;
            Log::info("TIEMPO: Carga de Datos - Rama 'Por Defecto': {$detalleDuration} ms");

            // --- SECCIÓN: Renderizado y Stream del PDF ---
            $pdfRenderStartTime = microtime(true);
            $pdf = PDF::loadView('reportes.informes.ri-planta-v2', compact(
                'titulo', 'nro', 'tipo_reporte', 'fecha', 'ot', 'norma_ensayo',
                'planta', 'norma_evaluacion', 'procedimiento_inf', 'ot_tipo_soldadura',
                'interno_equipo', 'actividad', 'interno_fuente', 'tipo_pelicula',
                'diametro_espesor', 'ici', 'tecnica', 'ejecutor_ensayo', 'cliente',
                'contratista', 'informe', 'informe_ri', 'material', 'material2',
                'tecnicas_grafico', 'juntas_posiciones', 'defectos_posiciones',
                'evaluador', 'informe_modelos_3d', 'firma', 'numero_repetido',
                'informe_solicitado_por', 'observaciones'
            ))->setPaper('a4', 'portrait')->setWarnings(false);

            $pdfRenderEndTime = microtime(true);
            $pdfRenderDuration = ($pdfRenderEndTime - $pdfRenderStartTime) * 1000;
            Log::info("TIEMPO: Renderizado y Stream del PDF - Rama 'Por Defecto': {$pdfRenderDuration} ms");

            $requestEndTime = microtime(true);
            $totalDuration = ($requestEndTime - $requestStartTime) * 1000;
            Log::info("--- FIN DE GENERACIÓN DE PDF: {$totalDuration} ms ---");

            return $pdf->stream();
        }
    }
}
