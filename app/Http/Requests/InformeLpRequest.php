<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformeLpRequest extends FormRequest
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
            'diametro'                  => 'required',
            'procedimiento'             => 'required',
            'norma_evaluacion'          => 'required',
            'norma_ensayo'              => 'required',
            'ot_tipo_soldadura'         => 'required',
            'metodo_trabajo_lp'         => 'required',
            'penetrante_tipo_liquido'   => 'required',
            'tiempo_penetracion'        => 'required|integer| digits_between:1,3',
            'revelador_tipo_liquido'    => 'required',
            'removedor_tipo_liquido'    => 'required',
            'penetrante_aplicacion'     => 'required',
            'revelador_aplicacion'      => 'required',
            'removedor_aplicacion'      => 'required',
            'limpieza_previa'           => 'Max:20',
            'limpieza_intermedia'       => 'Max:20',
            'limpieza_final'            => 'Max:20',
            'iluminacion'               => 'required',
            'ejecutor_ensayo'           => 'required',
            'observaciones'             => 'Max:250',
            'detalles.*.detalle'        => 'required|Max:250',
            'detalles.*.pieza'          => 'required|Max:30',
            'detalles.*.cm'             => 'nullable|integer',

        ];
    }

    public function attributes()
    {
        return [

            'norma_evaluacion'            => 'norma evaluación',
            'norma_ensayo'                => 'norma ensayo',
            'ejecutor_ensayo'             => 'ejecutor ensayo',
            'procedimiento_soldadura'     => 'procedimiento soldadura',
            'tipo_magnetizacion'          => 'tipo magnetización',
            'detalles.*.detalle'          => 'detalle',
            'detalles.*.pieza'            => 'pieza',
            'detalles.*.cm'               => 'cm',
            'ot_tipo_soldadura'           => 'Eps',

            ];
    }
}
