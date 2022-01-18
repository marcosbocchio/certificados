<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformeCvRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'fecha'                     => 'required',
            'obra'                      => 'required|min:1',
            'componente'                => 'required|Max:30',
            'extension_ensayo'          => 'Max:30',
            'material'                  => 'required',
            'plano_isom'                => 'required|Max:30',
            'procedimiento'             => 'required',
            'norma_evaluacion'          => 'required',
            'norma_ensayo'              => 'required',
            'ot_tipo_soldadura'         => 'required',
            'bomba'                     => 'required',
            'campana'                   => 'required',
            'modo_aplicacion'           => 'required',
            'observaciones'             => 'Max:250',
            'detalles.*.elemento'        => 'required|Max:30',
            'detalles.*.diametro'        => 'required',
            'detalles.*.soldador'        => 'required',

        ];
    }

    public function attributes()
    {
        return [

            'norma_evaluacion'            => 'norma evaluación',
            'norma_ensayo'                => 'norma ensayo',
            'ejecutor_ensayo'             => 'ejecutor ensayo',
            'detalles.*.elemento'         => 'elemento',
            'detalles.*.diametro'         => 'diametro',
            'detalles.*.soldador'         => 'soldador',
            'ot_tipo_soldadura'           => 'Eps',
            'modo_aplicacion'           => 'modo de aplicación',
            ];
    }
}
