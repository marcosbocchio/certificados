<?php

namespace App\Http\Controllers;
use App\Informe;
use App\MetodoEnsayos;
use Illuminate\Http\Request;

class PlacasController extends Controller
{

    public function index($informe_id)
    {
        $header_titulo = "Placas Informe";
        $header_descripcion ="Alta | Baja | Modificación";
        $accion = 'edit';
        $user = auth()->user();
        $informe = informe::findOrFail($informe_id);
        $metodo = MetodoEnsayos::find($informe->metodo_ensayo_id);
        $modelo ='';

        switch ($metodo->metodo) {

            case 'RI':

                   $modelo = 'placas_ri';

                break;

            case 'US':

                   $modelo = 'placas_us';

                break;
            case 'RD':

                $modelo = 'placas_rd';

            break;

        }

        return view('informe-placas.index',compact('informe_id',
                                                    'modelo',
                                                    'user',
                                                    'header_titulo',
                                                    'header_descripcion'));
    }
}
