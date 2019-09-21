<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtDocumentaciones extends Model
{
    protected $table='ot_documentaciones';
    protected $fillable = ['ot_id','documentacion_id'];

}
