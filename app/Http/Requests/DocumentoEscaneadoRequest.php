<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentoEscaneadoRequest extends FormRequest
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

            'descripcion'  =>'required|Max:50',
            'path'         =>'required',       
            
        ];
    }

    public function attributes()
    {
            return [
              
                'descripcion'                  => 'descripción',

            ];
     
    }

    public function messages()
    {
        return [
            'path.required' =>'No hay archivo seleccionado'
        ];
    }
}
