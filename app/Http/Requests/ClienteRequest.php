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


    public function AsignarValidaciones(&$val_nombre_contacto,&$val_cargo_contacto,&$val_email_contacto,&$val_telefono_contacto){

        $val_nombre_contacto   = 'required|Max:20';
        $val_cargo_contacto    = 'required|Max:45';
        $val_email_contacto    = 'nullable|email';
        $val_telefono_contacto = 'required|regex:/^([0-9-]{6,15})?$/';

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
                'nombre'        => 'required|Max:20',
                'razon_social'  => 'required|Max:100',
                'provincia'     =>'required',
                'localidad'     =>'required',
                'cp'            =>'required|regex:/[A-Z0-9]{8}/',
                'direccion'     =>'required|Max:50',
                'tel'           =>'required|regex:/^([0-9-]{6,15})?$/',
                'email'         =>'required|unique:users|email',

                'contactos.*.nombre' =>'required|Max:20',
                'contactos.*.cargo'  =>'required|Max:45',
                'contactos.*.tel'  =>'required|regex:/^([0-9-]{6,15})?$/',
                'contactos.*email'   =>'nullable|email',
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
