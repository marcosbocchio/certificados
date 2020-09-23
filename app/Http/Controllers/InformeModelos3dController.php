<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\InformeModelos3d;
use App\Modelos3D;

class InformeModelos3dController extends Controller
{
    public function store($informe_id,$TablaModelos3d){

        DB::enableQueryLog();

        $informe_modelos3d = InformeModelos3d::where('informe_id',$informe_id)->get();

        foreach ($informe_modelos3d as $informe_modelo3d) {
            $existe = false;
            foreach ($TablaModelos3d as $item_tabla) {

                if( ($informe_modelo3d['modelo_3d_id'] == $item_tabla['id'])){
                  $existe = true;
                }

            }

          if (!$existe){
            InformeModelos3d::where('informe_id',$informe_id)
                             ->where('modelo_3d_id',$informe_modelo3d['modelo_3d_id'])
                             ->delete();
            }
        }

       foreach ($TablaModelos3d as $item_tabla) {

            $informe_modelos3d_update = InformeModelos3d::firstOrCreate(

               ['informe_id' => $informe_id,'modelo_3d_id' => $item_tabla['id']],
               ['informe_id' => $informe_id,'modelo_3d_id' => $item_tabla['id']]

            );

        $informe_modelos3d_update->save();

       }
    }

    public function getInformeModelos3d($informe_id){

       return  Modelos3D::join('informe_modelos3d','informe_modelos3d.modelo_3d_id','=','modelos_3d.id')
                          ->where('informe_modelos3d.informe_id',$informe_id)
                          ->select('modelos_3d.*')
                          ->get();


    }
}
