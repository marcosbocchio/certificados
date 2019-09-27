<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
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
                'descripcion'  =>'nullable|Max:100',
                'unidad_medida' => 'required',
            ];
     
    }
}
