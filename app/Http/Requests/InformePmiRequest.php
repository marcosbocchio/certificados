<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformePmiRequest extends FormRequest
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
            'interno_equipo'            => 'required',
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
              'plano_isom'                  => 'plano',
              'interno_equipo'              => 'equipo',
            ];
    }
}
