<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BombasRequest extends FormRequest
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
            'designacion'  => 'required|Max:15',
            'marca'  => 'required|Max:15',
            'caudal'   => 'required|numeric|min:0',
            'voltaje'   => 'required|numeric|min:0',
        ];
    }

}
