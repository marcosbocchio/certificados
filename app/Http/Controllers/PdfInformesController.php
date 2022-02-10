<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Informe;
use App\MetodoEnsayos;

class PdfInformesController extends Controller
{

    public function index($id)    {

        $informe = Informe::where('id', '=', $id)->first();
        $metodo_ensayo = MetodoEnsayos::where('id', '=', $informe->metodo_ensayo_id)->first();

        switch ($metodo_ensayo->metodo) {
            case 'RI':
                 return redirect()->route('pdfInformeRi',array('id' => $id));
                 break;
            case 'PM':
                return redirect()->route('pdfInformePm',array('id' => $id));
                break;
            case 'LP':
                return redirect()->route('pdfInformeLp',array('id' => $id));
                break;
            case 'US':
                return redirect()->route('pdfInformeUs',array('id' => $id));
                break;
            case 'CV':
                return redirect()->route('pdfInformeCv',array('id' => $id));
                break;
            case 'DZ':
                return redirect()->route('pdfInformeDz',array('id' => $id));
                break;
            case 'TT':
                return redirect()->route('pdfInformeTt',array('id' => $id));
                break;
        }

    }

}
