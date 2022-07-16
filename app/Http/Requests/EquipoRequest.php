<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

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
        $condicional = [];
        $metodo_ensayo = $this->metodo_ensayos;
        log::debug('metodo: ' . $metodo_ensayo['metodo']);

        if ($metodo_ensayo['metodo'] == 'RI') { 
            $condicional = [
                'tipo_equipamiento' => 'required',
            ];
        }

        $validacion = [

            'codigo'            => 'required|Max:20',
            'descripcion'       =>'nullable|Max:100',
            'metodo_ensayos'    => 'required',
          
        ];

        $validacion_completa = array_merge($condicional,$validacion);

        return $validacion_completa;
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
