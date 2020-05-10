<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class DocumentacionesRequest extends FormRequest
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
      
       if ( $this->tipo == 'USUARIO'){ 

        return [

            'tipo' =>'required',
            'titulo' =>'required | max:45',
            'descripcion' => 'max:50',
            'usuario.name' => 'required',
            'fecha_caducidad' =>'required',
            'path' =>'required',          
        ];
        }
        elseif($this->tipo == 'PROCEDIMIENTO'){
            return [
               'tipo' =>'required',
               'descripcion' => 'max:50',
               'titulo' =>'required | max:45',
               'path' =>'required',
            ];
        }else{

            return [
               'tipo' =>'required',
               'descripcion' => 'max:100',
               'titulo' =>'required | max:25',
               'fecha_caducidad' =>'required',
               'path' =>'required',
            ];
        }
        



    }

    public function attributes()
    {
    return [
        'usuario.name'   => 'usuario',   
        'fecha_caducidad'   => 'fecha caducidad',   
       
          ];
    }

    public function messages()
    {
        return [
            'path.required' =>'No hay archivo seleccionado'
        ];
    }
}
