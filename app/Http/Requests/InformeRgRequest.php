<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformeRgRequest extends FormRequest
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
            'material'                  => 'required',
            'plano_isom'                => 'required|Max:30',
            'procedimiento'             => 'required',
            'norma_evaluacion'          => 'required',
            'norma_ensayo'              => 'required',
            'ot_tipo_soldadura'         => 'required',
            'recorrido_terminal'        => 'required',
            'cut_off'                   => 'required',
            'rango_inicial'             => 'required',
            'rango_final'               => 'required',
            'observaciones'             => 'Max:250',
            'ejecutor_ensayo'           => 'required',
        ];
    }

    public function attributes()
    {
        return [

              'norma_evaluacion'            => 'norma evaluación',
              'norma_ensayo'                => 'norma ensayo',
              'ejecutor_ensayo'             => 'ejecutor ensayo',
              'ot_tipo_soldadura'           => 'Eps',
              'recorrido_terminal'          => 'recorrido del terminal',
              'cut_off'                     => 'cut off',
              'plano_isom'                  => 'plano',
            ];
    }
}
