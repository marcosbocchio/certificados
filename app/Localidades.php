<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Localidades extends Model
{
    protected $table = "localidades";

    public function provincia(){

        return $this->belongsTo('App\Provincias','provincia_id','id');
      
      }
}
