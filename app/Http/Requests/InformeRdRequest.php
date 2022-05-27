<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformeRdRequest extends FormRequest
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
    $condicion_pk='';

    if($this->diametro['diametro'] == 'CHAPA'){

        $condicion_espesor_chapa = 'required';
        $condicion_dist_fuente_pelicula = 'required';

    }else if($this->diametro['diametro'] == 'VARIOS') {

        $condicion_espesor_no_chapa = '';

    } else {

        $condicion_espesor_no_chapa = 'required';

    }

    if($this->gasoducto_sn == false){

        $condicion_componente = 'required |';

    }else{

        $condicion_pk = 'required |numeric|min:0';
    }




        $condicional = [

           'espesor'                     => $condicion_espesor_no_chapa,
           'espesor_chapa'               => $condicion_espesor_chapa,
           'distancia_fuente_pelicula'   => $condicion_dist_fuente_pelicula,

           ];


     $validacion = [

                'gasoducto_sn'              => 'required',
                'fecha'                     => 'required',
                'obra'                      => 'required|min:1',
                'componente'                => $condicion_componente . 'Max:30',
                'material'                  => 'required',
                'plano_isom'                => 'required|Max:30',
                'medida.codigo'             => 'required',
                'ot_tipo_soldadura'         => 'required',
                'diametro'                  => 'required',
                'tecnica'                   => 'required',
                'interno_equipo'            => 'required',
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
                'distancia_fuente_pelicula' => 'required|numeric|between:0,99999.99',
                'observaciones'             => 'max:250',
                'pk'                        =>  $condicion_pk,

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
            'gasoducto_sn'          =>'formato',
            'ot_tipo_soldadura'     =>'Eps',
            'medida.codigo'         =>'medida'
            ];
        }
}
