<?php

namespace App;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class InformesView extends Model
{
    protected $table ='informes_view';

    public function otTiposoldadura(){

        return $this->belongsTo('App\OtTipoSoldaduras','ot_tipo_soldadura_id','id');

    }
    
    public function scopeObra($query,$obra){

        if($obra) {

           $query->Where('obra',$obra);

        }

    }
    public function scopePk($query,$pk){

        if($pk) {

           $query->Where('km',$pk);

        }

    }
    public function scopeMetodo($query, $metodo = '') {
        if (trim($metodo) != '') {
            $query->where('metodo', $metodo);
        }
    }

    public function scopeFiltro($query, $filtro = '') {
        if (trim($filtro) != '') {
            $query->where(function($q) use ($filtro) {
                $q->WhereRaw("numero_formateado LIKE '%" . $filtro . "%'")
                  ->orWhereRaw("informe_completo LIKE '%" . $filtro . "%'")
                  ->orWhereRaw("numero LIKE '%" . $filtro . "%'");
            });
        }
    }
}
