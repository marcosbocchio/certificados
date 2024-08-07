<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FuenteRequest extends FormRequest
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

            'codigo'            => 'required|Max:20',
            'descripcion'       => 'nullable|Max:100',
            't'                 => 'required|numeric|between:1,200',
         
          
        ];
    }

    public function attributes()
    {
            return [
                'codigo'                   => 'código',
                'descripcion'              =>'descripción',   
                't'                  =>' T 1/2',
            ];
     
    }
}
