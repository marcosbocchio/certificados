<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformeUsRequest extends FormRequest
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
     
        $condicional_espesor='';

        if($this->diametro['diametro'] == 'CHAPA'){

            $condicional_espesor = [      
           
                'espesor'                    => '',       
                'espesor_chapa'              => 'required',      
                              
                ];           
    
        }else {
    
            $condicional_espesor = [      
           
                'espesor'                     => 'required',       
                'espesor_chapa'               =>  '',
                              
                ];
    
        }   

       

        $validacion = [

            'fecha'                     => 'required',
            'componente'                => 'required|Max:20',
            'material'                  => 'required',
            'plano_isom'                => 'required|Max:10',
            'diametro'                  => 'required',
            'procedimiento_soldadura'   => 'required|Max:20', 
            'eps'                       => 'Max:30',
            'pqr'                       => 'Max:30',
            'interno_equipo'            => 'required',      
            'procedimiento'             => 'required',         
            'norma_evaluacion'          => 'required',
            'norma_ensayo'              => 'required',  
            'ejecutor_ensayo'           => 'required',
            'estado_superficie'         => 'required',
            'encoder'                   => 'required|max:15',
            'agente_acoplamiento'       => 'required|max:10',
        ];

        $validacion_completa =array_merge($condicional_espesor,$validacion);

        return $validacion_completa;

    }
}