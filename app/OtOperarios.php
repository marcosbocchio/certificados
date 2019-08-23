<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtOperarios extends Model
{
   protected $table='ot_operarios';
   protected $fillable = ['ot_id','user_id'];

   public function user()
   {
       return $this->belongsTo('App\User');
   }
}
