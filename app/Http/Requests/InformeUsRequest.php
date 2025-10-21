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
        $condicional_pdf_especial='';

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
        if($this->tipo_tgs == 'Linea'){
            $condicional_pdf_especial = [
                'data_popup.fluido' => 'required',
            ];
        }

        if($this->tipo_tgs == 'Horizontal' || $this->tipo_tgs == 'Vertical'){
            $condicional_pdf_especial = [
                'data_popup.fluido' => 'required',
                'data_popup.modelo' => 'required',
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
        $validacion_completa =array_merge($validacion_completa,$condicional_pdf_especial);

        return $validacion_completa;

    }

    public function attributes()

    {
        return [

            'ot_tipo_soldadura'           => 'Eps',
            'data_popup.fluido'           => 'Fluido en el detalle del componente',
            'data_popup.modelo'           => 'Modelo en el detalle del componente',
            ];
    }
}
