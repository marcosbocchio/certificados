<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'name' => 'required | max:30',
            'dni'  =>'nullable|numeric|digits_between:7,8|unique:users,dni,'. $this->id,
            'film' => 'nullable|numeric|digits_between:1,3|unique:users,film,'. $this->id,
            'email'  =>'required|email|unique:users,email,'. $this->id,
            'password' =>'required|Min:8',
            'cliente'  =>$condicion_cliente
        ];


      
    }
}
