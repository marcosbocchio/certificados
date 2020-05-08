<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParteRequest extends FormRequest
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
        $condicion_patente ='';
        $condicion_km_inicial ='';
        $condicion_km_final ='';
        
        if($this->movilidad_propia_sn) {
            $condicion_patente ='required | Max:10';
            $condicion_km_inicial ='required';
            $condicion_km_final = 'required';
        }else {
            $condicion_patente ='nullable';
            $condicion_km_inicial ='nullable';
            $condicion_km_final ='nullable';
        }


        return [
            'fecha' => 'required',  
            'tipo_servicio' =>'required',
            'horario' =>'required|Max:5', 
            'patente' => $condicion_patente,
            'km_inicial' => $condicion_km_inicial,
            'km_final'  =>  $condicion_km_final,   
            'servicios.*.cant_final' => 'nullable|integer|Min:0',               
        ];
    }



    public function attributes()
    {
            return [
               
                'servicios.*.cant_final' =>'cant de la tabla servicios'
            ];
     
    }

}
