<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\ModelosUsMe;
use App\FluidosUsMe;
use App\TipoUsMe;
use App\NormasFabricacion;
use App\ComponenteUsMe;
use App\MaterialUs;
use App\PdfEspecial;
use App\CategoriasInspeccion;
use App\ItemsCategoriaInspeccion;
use App\RespuestasInforme;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class TgsController extends Controller
{
    public function saveComponente($informeUs, $clienteId, $popup)
    {
        // 1) Busco el PdfEspecial
        $pdf = PdfEspecial::where('cliente_id', $clienteId)
            ->where('tipo_informe', $popup['tipo'] ?? null)
            ->first();
    
        if (! $pdf) {
            Log::error("No hay PdfEspecial para cliente {$clienteId} y tipo {$popup['tipo']}");
            return null;
        }
    
        // Helper: obtener un posible ID de un campo que puede venir object|array|string|null
        $getId = function($field, $subkey = 'id') {
            if (is_array($field) && array_key_exists($subkey, $field)) {
                return $field[$subkey];
            }
            if (is_object($field) && isset($field->{$subkey})) {
                return $field->{$subkey};
            }
            // si llega un valor escalar, lo devolvemos como ID
            if (is_scalar($field) && $field !== '') {
                return $field;
            }
            return null;
        };

        $modeloId  = $getId($popup['modelo'] ?? null);
        $fluidoId  = $getId($popup['fluido'] ?? null);
        $normaId   = $getId($popup['normaFabricacion'] ?? null);
        // $tipoId    = $getId($popup['tipo2'] ?? null);
        $materialId= $getId($popup['material'] ?? null, 'idtipo_us_me');
    
        // 2) Armo y guardo el ComponenteUsMe
        $componente = new ComponenteUsMe();
        $componente->informe_us_id              = $informeUs;
        $componente->area                       = $popup['area']              ?? null;
        $componente->orden                      = $popup['orden']             ?? null;
        $componente->tipo_us                    = $popup['tipo']              ?? null;
        $componente->pdf_especial_id            = $pdf->id;
        $componente->modelo_id                  = $modeloId;
        $componente->path3_componente           = $popup['path3_componente'];
        $componente->denominacion               = $popup['denominacion']      ?? null;
        $componente->año                        = $popup['anio']              ?? null;
        $componente->temp_diseño               = $popup['temperatura']['disenio']   ?? null;
        $componente->temp_operacion             = $popup['temperatura']['operacion'] ?? null;
        $componente->presion_diseño            = $popup['presion']['disenio']       ?? null;
        $componente->presion_operacion          = $popup['presion']['operacion']     ?? null;
        $componente->fluido_id                  = $fluidoId;
        $componente->sobreespesor_por_corrocion = $popup['sobreespesor']     ?? null;
        $componente->diam_exterior              = $popup['diamExterior']     ?? null;
        $componente->longitud_total             = $popup['longitudTotal']    ?? null;
        $componente->tratamiento_termico        = $popup['trat_termico']     ?? null;
        $componente->radiografiado              = $popup['radiografiado']   ?? null;
        $componente->norma_fabric_id            = $normaId;
        $componente->aislacion                  = $popup['aislacion']        ?? null;
        $componente->tipo                       = $popup['tipo2']            ?? null;
        $componente->material_id                = $materialId;
        $componente->espesor                    = $popup['espesor']          ?? null;
    
        $componente->save();
    
        Log::info("ComponenteUsMe guardado con ID {$componente->id}");
        if (!empty($popup['detalles']) && is_array($popup['detalles'])) {
            $this->saveMateriales($componente->id, $popup['detalles']);
        }
        return $componente;
    }
    
    protected function saveMateriales(int $componenteId, array $detalles)
    {
        foreach ($detalles as $idx => $d) {
            try {
                MaterialUs::create([
                    'componente_us_me_id'   => $componenteId,
                    'descripcion'           => $d['descripcion'],
                    'material'              => $d['material']['codigo'] ?? (string) $d['material'],
                    'grado'                 => (float) ($d['grado'] ?? 0),
                    'espesor_nominal'       => (float) ($d['espNominal'] ?? 0),
                    'espesor_minimo_medido' => (float) ($d['espMinMedido'] ?? 0)
                ]);
            } catch (\Exception $e) {
                Log::error("Error guardando material_us en detalle {$idx}: " . $e->getMessage());
            }
        }
    }

    public function saveTablaInforme(int $informeId, array $tablaInspeccion)
    {
     
        RespuestasInforme::where('informe_id', $informeId)->delete();

        $insertData = [];
        foreach ($tablaInspeccion as $categoria) {
            foreach ($categoria['items'] as $item) {
                if (isset($item['selected']) && in_array($item['selected'], ['SI','NO','N/A'])) {
                    $insertData[] = [
                        'informe_id'         => $informeId,
                        'item_categoria_id'  => $item['id'],
                        'respuesta'          => $item['selected'],
                    ];
                }
            }
        }


        if (!empty($insertData)) {
    
            DB::transaction(function() use ($insertData) {
                RespuestasInforme::insert($insertData);
            });
        }
    }

    // Obtener todos los NormasFabricacion
    public function getNormasFabricacion()
    {
        return NormasFabricacion::orderBy('codigo')->get();
    }

    public function getComponenteInforme($id)
    {
        // Trae todos los componentes cuyo informe_us_id == $id
        $componentes = ComponenteUsMe::where('informe_us_id', $id)->get();
    
        return $componentes;
    }

    // Obtener todos los modelos_us_me
    public function getModelos()
    {
        return ModelosUsMe::orderBy('codigo')->get();
    }

    public function getTablaInspeccion()
    {
       
        $categorias = CategoriasInspeccion::with('items')->get();


        $tabla = $categorias->map(function($cat) {
            return [
                'id'        => $cat->id,
                'categoria' => $cat->nombre,
                'items'     => $cat->items->map(function($item) {
                    return [
                        'id'     => $item->id,
                        'nombre' => $item->nombre,
                    ];
                })->toArray(),
            ];
        });

        return response()->json($tabla);
    }

    // Obtener todos los fluidos_us_me
    public function getFluidos()
    {
        return FluidosUsMe::orderBy('codigo')->get();
    }

    // Obtener todos los tipo_us_me
    public function getTipos()
    {
        return TipoUsMe::orderBy('codigo')->get();
    }

    public function saveTipo(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:50',
            'descripcion' => 'required|string|max:255',
        ]);

        $tipo = TipoUsMe::updateOrCreate(
            ['codigo' => $validated['codigo']],
            ['descripcion' => $validated['descripcion']]
        );

        return response()->json($tipo, 200);
    }

    public function saveModelo($codigo)
    {
        // Evitamos duplicados: si ya existe, lo devolvemos
        $modelo = ModelosUsMe::firstOrCreate(
            ['codigo' => $codigo],
            ['descripcion' => $codigo]
        );

        return response()->json($modelo);
    }

    public function saveFluido($codigo)
    {
        $fluido = FluidosUsMe::firstOrCreate(
            ['codigo' => $codigo],
            ['descripcion' => $codigo]
        );

        return response()->json($fluido);
    }

}
