<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class InternoEquipoRequest extends FormRequest
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
    $probeta= '';
    $dureza_calibracion= '';
    $metodo_ensayo = $this->equipo['metodo_ensayos'];
    Log::debug($metodo_ensayo);
    if($metodo_ensayo['metodo'] == 'DZ'){

        $probeta = 'required|max:15';
        $dureza_calibracion = 'required|max:5';
    }else{
        $probeta = '';
        $dureza_calibracion = '';
    }
            $condicional = [

            'probeta'                     => $probeta,
            'dureza_calibracion'               => $dureza_calibracion,
            ];
            $validacion = [
            'nro_serie'      => 'nullable| Max:45',
            'nro_interno'    => 'required|numeric |digits_between:1,5',
            'equipo'         => 'required',
            ];
        $validacion_completa =array_merge($condicional,$validacion);

        return $validacion_completa;

    }

    public function attributes()
    {
            return [

                'nro_serie'                   => 'N° Serie',
                'nro_interno'                 => 'N° Interno',
                'dureza_calibracion'          => 'Dureza de calibración',
            ];

    }
}
