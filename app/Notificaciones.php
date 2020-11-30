<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notificaciones extends Model
{
    use SoftDeletes;
    protected $table="notificaciones";

    public function documentacion()
    {
        return $this->belongsTo('App\Documentaciones','documentacion_id','id');
    }
}
