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
    public function scopeFiltro($query, $filtro='') {
        
        if (trim($filtro) != '') {
            $query->WhereRaw("numero LIKE '%" . $filtro . "%'")
                  ->orWhereRaw("obra LIKE '%" . $filtro . "%'")
                  ->orWhereRaw("metodo LIKE '%" . $filtro . "%'")
                  ->orWhereRaw("informe_completo LIKE '%" . $filtro . "%'")
                  ->orWhereRaw("name LIKE '%" . $filtro . "%'")
                  ->orWhereRaw("fecha_formateada LIKE '%" . $filtro . "%'");
                  ->orWhereRaw("numero_formateado LIKE '%" . $filtro . "%'");
                  ->orWhereRaw("name LIKE '%" . $filtro . "%'");
        }

    }
}
