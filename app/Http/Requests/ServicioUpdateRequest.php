<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServicioUpdateRequest extends FormRequest
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
            'descripcion'   => 'nullable|Max:100',
            'abreviatura'   => 'required|Max:4|unique:servicios,abreviatura,' . $this->servicio,
            'unidad_medida' => 'required',
            'metodo_ensayo' => 'required',
        ];
    }

    public function attributes()
    {
            return [
                'prefijo'                  => 'descripción',
                'abreviatura'              => 'código',
            ];
     
    }
}
