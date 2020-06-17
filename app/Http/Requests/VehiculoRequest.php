<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehiculoRequest extends FormRequest
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
            'nro_interno'   => 'required',
            'marca'         => 'required|Max:15',
            'modelo'        =>'required|Max:50',
            'patente'       => 'required | Max:7',
            'tipo'          => 'required | Max:15',
            'chasis'        => 'required | Max:20',
            'motor'         => 'required | Max:20',
        ];
     
    }
}
