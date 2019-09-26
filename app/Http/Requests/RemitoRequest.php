<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RemitoRequest extends FormRequest
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
            'fecha'                    => 'required',
            'prefijo'                  =>'required | numeric',
            'numero'                   =>'required | numeric',
            'receptor'                 =>'required | Max:45',  
            'destino'                  =>'required | Max:100',             
        ];
    }

    public function attributes()
    {
            return [
                'numero'                   => 'Remito N°',
                'prefijo'                  => 'Prefijo N°',
            ];
     
    }
}
