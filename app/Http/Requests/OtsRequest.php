<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;


class OtsRequest extends FormRequest
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
            'ot'                       => 'required|digits_between:1,11|integer|unique:ots,numero,'. $this->id,
            'fts'                      => 'required|digits_between:1,11|integer|unique:ots,numero,'. $this->id,
            'cliente'                  => 'required',
            'proyecto'                 => 'required|Max:50',
            'fecha'                    => 'required',
            'hora'                     => 'required',
            'obra'                     => 'integer|nullable',
            'contacto1'                => 'required', 
            'provincia'                => 'required',
            'localidad'                => 'required',
            'fecha_ensayo'             => 'required',
            'lugar_ensayo'             => 'required',
            'lat'                      => 'required',
            'lon'                      => 'required',
            'observaciones'            => 'Max:255',         
            'servicios.*.cantidad_servicios' => 'required|integer|Min:1',          
            'servicios.*.cantidad_placas'    => 'nullable|integer|Min:1',
            'productos.*.cantidad_productos'  =>'required|integer|Min:1',   
            'productos.*.medida'              =>'required',
                
        ];     

      
    }

    public function attributes()
    {
    return [
        'ot'                                  => 'OT N°',
        'fts'                                 => 'FTS N°',  
        'contacto1'                           => 'contacto 1',       
        'fecha_ensayo'                        => 'fecha estimada de ensayo',
        'lugar_ensayo'                        => 'lugar de ensayo',
        'servicios.*.cantidad_servicios'      => 'cant.',  
        'servicios.*.cantidad_placas'         => 'Max N° Placas', 
        'productos.*.medida'                  => 'medida',   
        'productos.*.cantidad_productos'      => 'cant.'  


         ];
    }

  

}
