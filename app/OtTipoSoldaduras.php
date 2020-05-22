<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtTipoSoldaduras extends Model
{

   protected $table='ot_tipo_soldaduras';

   protected $fillable = ['ot_id','tipo_soldadura_id','eps', 'pqr'];


   public function tipoSoldadura(){

    return $this->belongsTo('App\TipoSoldaduras','tipo_soldadura_id','id');

    }

}
