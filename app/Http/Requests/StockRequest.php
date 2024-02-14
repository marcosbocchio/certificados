<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockRequest extends FormRequest
{

    public function authorize()
    {

        return true; // Todos están autorizados
    }

    public function rules()
    {
        return [
            'fecha' => 'required|date', // 
            'obs' => 'nullable|string|max:200', // 
            'cantidad' => 'required|numeric', // 
            'stock' => 'required|numeric', // 
        ];
    }
    public function messages()
    {
        return [
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'El campo fecha debe ser una fecha válida.',
            
        ];
    }
}
