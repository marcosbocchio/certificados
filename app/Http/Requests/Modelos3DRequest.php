<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Modelos3DRequest extends FormRequest
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

            'codigo'            => 'required|Max:20',
            'descripcion'       => 'nullable|Max:500',
            'path'              => 'required'

        ];
    }

    public function attributes()
    {
            return [
                'codigo'                   => 'código',
                'prefijo'                  => 'descripción',
            ];

    }

    public function messages()
    {
        return [
            'path.required' =>'No hay archivo seleccionado'
        ];
    }
}
