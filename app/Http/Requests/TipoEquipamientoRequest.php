<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoEquipamientoRequest extends FormRequest
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

    public function rules()
    {
        return [
            'codigo' => 'required|Max:25',
            'descripcion'  =>'Max:100',
        ];
    }

    public function attributes()
    {
            return [
                'codigo'                   => 'código',
                'descripcion'              => 'descripción',
            ];
     
    }
}
