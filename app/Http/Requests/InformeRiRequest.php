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
    
    $condicion_espesor_no_chapa = '' ;      
    $condicion_espesor_chapa = '' ;
    $condicion_dist_fuente_pelicula ='';
    $condicion_componente='';

   

    if($this->diametro == 'CHAPA'){

        $condicion_espesor_chapa = 'required';
        $condicion_dist_fuente_pelicula = 'required';

    }else {

        $condicion_espesor_no_chapa = 'required';

    }    

    if($this->gasoducto_sn == false){
        $condicion_componente = 'required |';
    }


    $condicional = [      
           
           'espesor'                     => $condicion_espesor_no_chapa,
           'espesor_chapa'               => $condicion_espesor_chapa,
           'distancia_fuente_pelicula'   => $condicion_dist_fuente_pelicula,
                         
           ];


     $validacion = [

                'numero_inf'                =>'required | integer| digits_between:1,3',
                'gasoducto_sn'              => 'required',
                'fecha'                     => 'required',
                'componente'                => $condicion_componente . 'Max:20',
                'material'                  => 'required',
                'plano_isom'                => 'required|Max:10',
                'diametro'                  => 'required',
                'procedimiento_soldadura'   => 'required|Max:20', 
                'tecnica'                   => 'required',
                'eps'                       => 'Max:30',
                'pqr'                       => 'Max:30',
                'foco'                      => 'required',
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

        $validacion_completa =array_merge($condicional,$validacion);

        return $validacion_completa;

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
            'gasoducto_sn'          =>'formato'  
            ];
        }
}
