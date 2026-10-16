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
        $metodos = $this->metodos ?: [$this->metodo_ensayos];
        $nombres_metodos = collect($metodos)->pluck('metodo');
        log::debug('metodos: ' . $nombres_metodos->implode(','));

        if ($nombres_metodos->contains('RI')) {
            $condicional = [
                'tipo_equipamiento' => 'required',
            ];
        }

        $validacion = [

            'codigo'            => 'required|Max:25',
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
                'metodo_ensayos'           =>'método de ensayo',
                'tipo_equipamiento'        =>'tipo de equipamiento',
            ];
     
    }
  
}
