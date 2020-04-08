<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
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
          
                'codigo'        => 'required|Max:13',
                'nombre'        => 'required|Max:30',
                'razon_social'  => 'required|Max:100',
                'provincia'     =>'required',
                'localidad'     =>'required',
                'cp'            =>'required|min:4|max:8|regex:/[A-Z0-9]/',
                'direccion'     =>'required|Max:50',
                'tel'           =>'required|regex:/^([0-9-()\/ ]{6,40})?$/',
                'email'         =>'required|unique:users|email',

                'contactos.*.nombre' =>'required|Max:30',
                'contactos.*.cargo'  =>'required|Max:30',
                'contactos.*.tel'    =>'required|regex:/^([0-9-()\/ ]{6,40})?$/',
                'contactos.*.email'   =>'nullable|email',
            ];
     
    }

    public function attributes()
    {
            return [
                'codigo'              => 'código', 
                'razon_social'        => 'razón social',
                'direccion'           => 'dirección',
                'tel'                 => 'teléfono',
                'contactos.*.nombre'    => 'nombre del contacto',
                'contactos.*.cargo'     => 'cargo del contacto',
                'contactos.*.email'     => 'email del contacto',
                'contactos.*.tel'       => 'teléfono del contacto',
   
            ];
     
    }

}
