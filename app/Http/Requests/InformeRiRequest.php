<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformeRiRequest extends FormRequest
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
            'tecnica'                   => 'required',
            'eps'                       => 'Max:30',
            'pqr'                       => 'Max:30',
            'equipo'                    => 'required',
            'tipo_pelicula'             => 'required',
            'procedimiento'             => 'required',
            'pos_ant'                   => 'required|numeric|between:0,999.99',
            'pos_pos'                   => 'required|numeric|between:0,999.99',
            'lado'                      => 'required|Max:6',
            'ici'                       => 'required',
            'norma_evaluacion'          => 'required',
            'norma_ensayo'              => 'required',
            'actividad'                 => 'Max:10',
            'exposicion'                => 'required|integer|digits_between:1,6',
            'ejecutor_ensayo'           => 'required',
            'observaciones'             => 'max:250',
           
            
        ];

    }


    public function attributes()
        {
        return [
            'numero_inf'           => 'número de informe',  
            'tipo_pelicula'        => 'tipo Pelicula',
            'pos_ant'              => 'ant',   
            'pos_pos'              => 'pos',   
            'norma_evaluacion'     => 'norma Evaluación',
            'norma_ensayo'         => 'norma Ensayo',
            'ejecutor_ensayo'      => 'ejecutor ensayo',
            'procedimiento_soldadura' =>'procedimiento soldadura',    
            ];
        }
}
