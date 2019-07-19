<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ots extends Model
{
    protected $table = "ots";

    public function cliente()
    {
        return $this->belongsTo('App\Clientes');
    }

  

 

}
