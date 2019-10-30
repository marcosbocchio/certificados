<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EquipoRequest extends FormRequest
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
            'descripcion'       =>'nullable|Max:100',
            'metodo_ensayos'     => 'required',
            'tipo_lp'           => 'nullable| Max:15',       
          
        ];
    }

    public function attributes()
    {
            return [
                'codigo'                   => 'código',
                'descripcion'              =>'descripción', 
                'metodo_ensayo'            =>'Método de ensayo', 
            ];
     
    }
  
}
