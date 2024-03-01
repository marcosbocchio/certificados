<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProveedorRequest extends FormRequest
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
            
            'cuit' => 'required|string|max:45', 
            'razon_social' => 'required|string|max:100', 
            'email' => 'required|email|max:60', 
            'tel' => 'required|string|max:40', 
        ];
    }
}
