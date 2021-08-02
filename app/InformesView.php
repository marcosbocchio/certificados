<?php

namespace App;

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
}
