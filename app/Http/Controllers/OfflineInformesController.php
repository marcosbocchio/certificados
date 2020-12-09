<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Str;
use Image;
use Illuminate\Support\Facades\DB;
use App\OtTipoSoldaduras;
use App\OtSoldadores;
use App\Soldadores;

class OfflineInformesController extends Controller
{

    public function storeTiposSoldaduras(Request $request)
    {

        $content = $request->all();
        $result = collect(); //aca va: [id que viene desde local] = id de la DB servidor
        foreach ($content as $nueva_ot_tipo_soldadura) {

            //primero busco que no exista el tipo de soldadura (por si lo meten dos veces)
            $ot_tipo_soldaduras = OtTipoSoldaduras::where('ot_id',$nueva_ot_tipo_soldadura['ot_id'])->get();

            //Si la ot no tiene tipos de soldaduras, se agrega directamente
            $existe = false;
            if (!$ot_tipo_soldaduras->isEmpty()) {
                foreach ($ot_tipo_soldaduras as $ot_tipo_soldadura) {
                    //Comparo si existe una igual: existe -> me quedo con el id de la DB servidor
                    //                           no existe-> Se agrega a la DBS
                    if($ot_tipo_soldadura['obra'] == $nueva_ot_tipo_soldadura['obra']
                        && $ot_tipo_soldadura['tipo_soldadura_id'] == $nueva_ot_tipo_soldadura['tipo_soldadura_id']
                        && $ot_tipo_soldadura['eps'] == $nueva_ot_tipo_soldadura['eps']
                        && $ot_tipo_soldadura['pqr'] == $nueva_ot_tipo_soldadura['pqr']
                        && $ot_tipo_soldadura['proc_reparacion'] == $nueva_ot_tipo_soldadura['proc_reparacion']) {
                        $existe = true;
                        //$result[$nueva_ot_tipo_soldadura['id']] = [$nueva_ot_tipo_soldadura['id'] => $ot_tipo_soldadura['id']];
                        $result->add([
                            'idViejo' => $nueva_ot_tipo_soldadura['id'],
                            'idNuevo' => $ot_tipo_soldadura['id']
                            ]);
                    }
                }
            }
            if(!$existe) {
                $tipo_soldadura = new OtTipoSoldaduras;
                $tipo_soldadura->ot_id =$nueva_ot_tipo_soldadura['ot_id'];
                $tipo_soldadura->obra =$nueva_ot_tipo_soldadura['obra'];
                $tipo_soldadura->tipo_soldadura_id =$nueva_ot_tipo_soldadura['tipo_soldadura_id'];
                $tipo_soldadura->eps =$nueva_ot_tipo_soldadura['eps'];
                $tipo_soldadura->pqr =$nueva_ot_tipo_soldadura['pqr'];
                $tipo_soldadura->proc_reparacion =$nueva_ot_tipo_soldadura['proc_reparacion'];
                $tipo_soldadura->save();
                //$result[$nueva_ot_tipo_soldadura['id']] = [$nueva_ot_tipo_soldadura['id'] => $tipo_soldadura->id];
                $result->add([
                    'idViejo' =>$nueva_ot_tipo_soldadura['id'],
                    'idNuevo' =>$tipo_soldadura->id
                    ]);
            }
        }
        return response()->json($result, 200, ['Content-type'=>'application/json;charset=utf-8'], JSON_UNESCAPED_UNICODE);

    }

    public function storeSoldadores(Request $request)
    {
        $content = $request->all();
        $result = collect(); //aca va: [id que viene desde local] = id de la DB servidor

        $soldadores = $content['soldadores'];
        $otSoldadores = $content['ot_soldadores'];
        $soldador_id = 0;

        foreach ($otSoldadores as $otSoldador) {
            $posEnSoldadores = array_search($otSoldador['soldadores_id'], $soldadores);
            if ($posEnSoldadores) //da falso si no encuentra
            {
                $codigo = $soldadores[$posEnSoldadores]['codigo'];
                $clienteId = $soldadores[$posEnSoldadores]['cliente_id'];
                $nSoldador = Soldadores::firstOrCreate(
                    ['codigo' => $codigo ,'cliente_id' => $clienteId],
                    ['codigo' => $codigo ,'cliente_id' => $clienteId,'nombre'  =>'nn']
                );
                $ot_id = $otSoldador['ot_id'];
                $soldador_id = $nSoldador->id;
            }
            else
            {
                $soldador = Soldadores::find($otSoldador['soldadores_id']);
                $soldador_id = ($soldador) ? $soldador->id : 0;

            }
            if ($soldador_id !== 0)
            {
                $ot_soldador = OtSoldadores::firstOrCreate(
                    ['ot_id' => $ot_id,'soldadores_id' => $soldador_id],
                    ['ot_id' => $ot_id,'soldadores_id' => $soldador_id]
                );
                $result->add([
                            'idViejo' => $otSoldador['id'],
                            'idNuevo' => $ot_soldador['id']
                            ]);
            }
        }
        return response()->json($result, 200, ['Content-type'=>'application/json;charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function saveReferenciaImg(Request $request)
    {
        $path1 = 'null';
        $path2 = 'null';
        $path3 = 'null';
        $path4 = 'null';
        if ($request->path1 != null){
            $path1 = $this->saveReferenciaImgFiles($request->path1);
        }
        if ($request->path2 != null){
            $path2 = $this->saveReferenciaImgFiles($request->path2);
        }
        if ($request->path3 != null){
            $path3 = $this->saveReferenciaImgFiles($request->path3);
        }
        if ($request->path4 != null){
            $path4 = $this->saveReferenciaImgFiles($request->path4);
        }
        $paths = collect();
        $paths->add( [
            'id' => 0,
            'descripcion' =>'',
            'path1' => $path1,
            'path2' => $path2,
            'path3' => $path3,
            'path4' => $path4,

        ]);
        return response()->json($paths,200,['Content-type'=>'application/json;charset=utf-8'],JSON_UNESCAPED_UNICODE);
    }

    public function saveReferenciaImgFiles($imagenBase64)
    {
        $extension = explode('/', mime_content_type($imagenBase64))[1];
        $png_url = Str::random(40)."." . $extension;
        $path = public_path().'/storage/referencias/' . $png_url;//comprobar que se guarden en la misma carpeta (web y offline)

        Image::make(file_get_contents($imagenBase64))->save($path);
        return '/storage/referencias/' . $png_url;
    }

    public function saveUsImgFiles(Request $request)
    {
        $imagenBase64 = $request->path;
        $extension = explode('/', mime_content_type($imagenBase64))[1];
        $png_url = Str::random(40)."." . $extension;
        $path = public_path().'/storage/calibraciones_us/' . $png_url;

        Image::make(file_get_contents($imagenBase64))->save($path);
        return '/storage/calibraciones_us/' . $png_url;
    }

    public function getToday()
    {
        return date('Y-m-d H:i:s');
    }
}
