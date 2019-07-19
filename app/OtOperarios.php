<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtOperarios extends Model
{
   protected $table='ot_operarios';

   public function user()
   {
       return $this->belongsTo('App\User');
   }
}
