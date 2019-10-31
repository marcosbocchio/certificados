<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InternoFuenteRequest extends FormRequest
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
            'nro_serie'  => 'required|Max:45',    
            'curie'      => 'nullable | numeric |between:0,100',   
            'fuente'     => 'required',
        ];
    }

    public function attributes()
    {
            return [
                'nro_serie'                   => 'N° Serie',
                
            ];
     
    }
}
