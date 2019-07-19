<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioDocumentaciones extends Model
{
    protected $table='usuario_documentaciones';

    public function Documentacion(){

        return $this->belongsTo('App\Documentaciones','documentacion_id');
    }
}
