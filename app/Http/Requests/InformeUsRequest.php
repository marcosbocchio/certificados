<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformeUsRequest extends FormRequest
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

        $condicional_espesor='';

        if($this->diametro['diametro'] == 'CHAPA'){

            $condicional_espesor = [

                'espesor'                    => '',
                'espesor_chapa'              => 'required',

                ];

        } else if($this->diametro['diametro'] == 'VARIOS') {

            $condicional_espesor = [
                'espesor'                    => '',
          ];

        } else {

            $condicional_espesor = [

                'espesor'                     => 'required',
                'espesor_chapa'               =>  '',

                ];

        }

        $validacion = [

            'fecha'                     => 'required',
            'obra'                      => 'required|min:1',
            'componente'                => 'required|Max:30',
            'material'                  => 'required',
            'plano_isom'                => 'required|Max:30',
            'diametro'                  => 'required',
            'ot_tipo_soldadura'         => 'required',
            'interno_equipo'            => 'required',
            'procedimiento'             => 'required',
            'norma_evaluacion'          => 'required',
            'norma_ensayo'              => 'required',
            'ejecutor_ensayo'           => 'required',
            'estado_superficie'         => 'required',
            'encoder'                   => 'required|max:15',
            'agente_acoplamiento'       => 'required',
        ];

        $validacion_completa =array_merge($condicional_espesor,$validacion);

        return $validacion_completa;

    }

    public function attributes()

    {
        return [

            'ot_tipo_soldadura'           => 'Eps',

            ];
    }
}
