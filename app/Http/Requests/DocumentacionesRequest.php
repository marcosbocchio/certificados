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
            'usuario_id' => 'required',
            'path' =>'required',
           
        ];
        }
        else{
            return [
               'tipo' =>'required',
               'descripcion' => 'max:50',
               'titulo' =>'required | max:45',
               'path' =>'required'
            ];
        }
    }

    public function attributes()
    {
    return [
        'usuario_id'   => 'usuario',   
          ];
    }
}
