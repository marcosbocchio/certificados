<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformeTtRequest extends FormRequest
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

            'fecha'                            => 'required',
            'obra'                             => 'required|min:1',
            'componente'                       => 'required|Max:30',
            'material'                         => 'required',
            'plano_isom'                       => 'required|Max:30',
            'procedimiento'                    => 'required',
            'norma_evaluacion'                 => 'required',
            'ot_tipo_soldadura'                 => 'required',
            'interno_equipo'                    => 'required',
            'norma_ensayo'                     => 'required',
            'ejecutor_ensayo'                  => 'required',
            'temperatura_inicial'              => 'required |numeric|between:0,10000',
            'temperatura_subida'               => 'required |numeric|between:0,10000',
            'temperatura_mantenimiento'        => 'required |numeric|between:0,10000',
            'temperatura_enfriado'             => 'required |numeric|between:0,10000',
            'temperatura_final'                => 'required |numeric|between:0,10000',
            'observaciones'                    => 'Max:250',
        ];
    }
    public function messages()
    {
        return [
            'ot_tipo_soldadura.required' => 'El campo EPS / WPS es obligatorio.',
            'interno_equipo.required'     => 'El campo Equipo es obligatorio.',
        ];
    }
}
