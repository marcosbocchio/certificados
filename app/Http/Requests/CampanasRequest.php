<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CampanasRequest extends FormRequest
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

    public function rules()
    {
        return [
            'designacion'  => 'required|Max:15',
            'presion_max_manometro'  => 'required|numeric|min:0',
            'presion_trabajo_min'   => 'required|numeric|min:0',
            'presion_trabajo_max'   => 'required|numeric|min:0',
            'tipo_angular_sn'       => 'required',
            'ancho'                  => 'nullable|numeric|min:0',
            'alto'                   => 'nullable|numeric|min:0',
            'profundidad'            => 'nullable|numeric|min:0',
        ];
    }

    public function attributes()
    {
            return [
                'designacion'  => 'designacion',
                'presion_max_manometro'  => 'presión máxima manómetro',
                'presion_trabajo_min'   => 'presión trabajo mínima',
                'presion_trabajo_max'   => 'presión trabajo máxima',
                'tipo_angular_sn'       => 'campana tipo angular',
            ];

    }
}
