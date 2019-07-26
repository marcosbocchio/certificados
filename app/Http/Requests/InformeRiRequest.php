<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformeRiRequest extends FormRequest
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

            'numero_inf' =>'required | integer| max:3 |digits_between:1,3',
        ];

    }


    public function attributes()
        {
        return [
            'numero_inf'           => 'Número de informe',  
    
    
            ];
        }
}
