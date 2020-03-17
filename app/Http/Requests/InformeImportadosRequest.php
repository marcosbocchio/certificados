<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformeImportadosRequest extends FormRequest
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
            'prefijo'                   => 'nullable|Max:10',  
            'numero'                    => 'required',
            'ejecutor_ensayo'           => 'required',
            'path'                      => 'required',
            'observaciones'             => 'required | Max:250',  

        ];
    }

    public function attributes()
    {
    return [
        
        'numero'   => 'número',  
    
          ];
    }

    public function messages()
    {
        return [
            'path.required' =>'No hay archivo seleccionado'
        ];
    }
}
