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

    $val_nombre_contacto1    ='';
    $val_cargo_contacto1      ='';
    $val_email_contacto1     ='';
    $val_telefono_contacto1   ='';

    $val_nombre_contacto2     ='';
    $val_cargo_contacto2      ='';
    $val_email_contacto2      ='';
    $val_telefono_contacto2   ='';  

    $val_nombre_contacto3     ='';
    $val_cargo_contacto3      ='';
    $val_email_contacto3      ='';
    $val_telefono_contacto3   ='';      


   

        if($this->contacto1['nombre'] != '' || $this->contacto1['email']!= '' || $this->contacto1['cargo']!= '' || $this->contacto1['tel']!= ''){

            $val_nombre_contacto1   = 'required|Max:20';
            $val_cargo_contacto1    = 'required|Max:45';
            $val_email_contacto1    = 'nullable|email';
            $val_telefono_contacto1 = 'required|regex:/^([0-9-]{6,15})?$/';
        }
   

   

        if($this->contacto2['nombre'] != '' || $this->contacto2['email']!= '' || $this->contacto2['cargo']!= '' || $this->contacto2['tel']!= ''){

            $val_nombre_contacto2   = 'required|Max:20';
            $val_cargo_contacto2    = 'required|Max:45';
            $val_email_contacto2    = 'nullable|email';
            $val_telefono_contacto2 = 'required|regex:/^([0-9-]{6,15})?$/';

            }
  

   

        if($this->contacto3['nombre'] != '' || $this->contacto3['email']!= '' || $this->contacto3['cargo']!= '' || $this->contacto3['tel']!= ''){

            $val_nombre_contacto3   = 'required|Max:20';
            $val_cargo_contacto3    = 'required|Max:45';
            $val_email_contacto3    = 'nullable|email';
            $val_telefono_contacto3 = 'required|regex:/^([0-9-]{6,15})?$/';
        }
    
  
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

                'contacto1.nombre' => $val_nombre_contacto1,
                'contacto1.cargo'  => $val_cargo_contacto1,
                'contacto1.email'  => $val_email_contacto1,
                'contacto1.tel'    => $val_telefono_contacto1,

                'contacto2.nombre' => $val_nombre_contacto2,
                'contacto2.cargo'  => $val_cargo_contacto2,
                'contacto2.email'  => $val_email_contacto2,
                'contacto2.tel'    => $val_telefono_contacto2,

                'contacto3.nombre' => $val_nombre_contacto3,
                'contacto3.cargo'  => $val_cargo_contacto3,
                'contacto3.email'  => $val_email_contacto3,
                'contacto3.tel'    => $val_telefono_contacto3,
            ];
     
    }

    public function attributes()
    {
            return [
                'codigo'              => 'código',
                'razon_social'        => 'razón social',
                'direccion'           => 'dirección',
                'tel'                 => 'teléfono',

                'contacto1.nombre'    => 'nombre del contacto 1',
                'contacto1.cargo'     => 'cargo del contacto 1',
                'contacto1.email'     => 'email del contacto 1',
                'contacto1.tel'       => 'teléfono del contacto 1',

                'contacto2.nombre'    => 'nombre del contacto 2',
                'contacto2.cargo'     => 'cargo del contacto 2',
                'contacto2.email'     => 'email del contacto 2',
                'contacto2.tel'       => 'teléfono del contacto 2',

                'contacto3.nombre'    => 'nombre del contacto 3',
                'contacto3.cargo'     => 'cargo del contacto 3',
                'contacto3.email'     => 'email del contacto 3',
                'contacto3.tel'       => 'teléfono del contacto 3',
            ];
     
    }

}
