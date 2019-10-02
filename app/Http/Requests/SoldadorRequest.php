<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SoldadorRequest extends FormRequest
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
            'codigo' => 'required|Max:10',
            'nombre'  =>'required|Max:100',
        ];
    }

    public function attributes()
    {
            return [
                'codigo'                   => 'código',            
            ];
     
    }
}
