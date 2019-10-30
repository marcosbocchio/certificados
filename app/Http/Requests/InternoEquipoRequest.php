<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [

            'nro_serie'      => 'nullable| Max:45',  
            'nro_interno'    => 'required| Max:5', 
            'voltaje'        => 'nullable| digits_between:1,11',
            'amperaje'       => 'nullable| digits_between:1,11',       
            'equipo'         => 'required',
        ];
    }

    public function attributes()
    {
            return [

                'nro_serie'                   => 'N° Serie',
                'nro_interno'                 => 'N° Interno',
                
            ];
     
    }
}
