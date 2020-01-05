<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $condicion_cliente ='';
        if(!$this->isEnod) {
            $condicion_cliente ='required';
        }

        return [
            'name' => 'required',
            'dni'  =>'nullable|unique:users|numeric|digits_between:7,8',
            'film' => 'nullable|unique:users.film|max:6',
            'email'  =>'required|unique:users|email',
            'password' =>'required|Min:8',
            'cliente'  =>$condicion_cliente
        ];


      
    }
}
