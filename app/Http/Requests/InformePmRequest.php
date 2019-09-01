<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformePmRequest extends FormRequest
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

            'numero_inf'                =>'required | integer| digits_between:1,3',
            'fecha'                     => 'required',
            'componente'                => 'required|Max:20',
            'material'                  => 'required',
            'plano_isom'                => 'required|Max:10',
            'diametro'                  => 'required',
            'procedimiento_soldadura'   => 'required|Max:20', 
            'eps'                       => 'Max:30',
            'pqr'                       => 'Max:30',           
            'concentracion'             => 'required|numeric|between:0,999.99',
            'tecnica'                   => 'required',          
            'procedimiento'             => 'required',         
            'norma_evaluacion'          => 'required',
            'norma_ensayo'              => 'required',  
            'tipo_magnetizacion'        => 'required',  
            'magnetizacion'             => 'required', 
            'color_particula'           => 'required', 
            'iluminacion'               => 'required', 
            'desmagnetizacion'          => 'required',  
            'ejecutor_ensayo'           => 'required',
            'observaciones'             => 'Max:250',
            'detalles.*.detalle'        => 'required|Max:250',
            'detalles.*.pieza'          => 'required|Max:10',
            'detalles.*.numero'         => 'required|integer',
            
        ];
   
    }

    public function attributes()
    {
        return [
            'numero_inf'                  => 'número de informe',    
            'norma_evaluacion'            => 'norma evaluación',
            'norma_ensayo'                => 'norma ensayo',
            'ejecutor_ensayo'             => 'ejecutor ensayo',  
            'procedimiento_soldadura'     => 'procedimiento soldadura', 
            'tipo_magnetizacion'          => 'tipo magnetización',
            'detalles.*.detalle'          => 'detalle',
            'detalles.*.pieza'            => 'pieza',
            'detalles.*.numero'           => 'número',  
            ];
    }
}
