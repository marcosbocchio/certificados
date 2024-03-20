<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'fecha' => 'required|date', 
            'obs' => 'nullable|string|max:200', 
            'cantidad' => 'required|numeric', 
            'stock' => 'required|numeric',
            'tipo_movimiento' => 'required|string|max:100',
            'user_id' => 'required|numeric|max:30',
        ];
    }
}
