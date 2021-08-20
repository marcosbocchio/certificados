<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParteRequest extends FormRequest
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
            'fecha' => 'required',
            'tipo_servicio' =>'required',
            'horario' =>'required|Max:5',
            'servicios.*.cant_final' => 'nullable|Min:0',
        ];
    }



    public function attributes()
    {
            return [

                'servicios.*.cant_final' =>'cant de la tabla servicios'
            ];

    }

}
