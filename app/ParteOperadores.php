<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParteOperadores extends Model
{
    protected $table="parte_operadores";
    protected $fillable = ['parte_id','user_id','responsabilidad'];

    public function user()
   {
       return $this->belongsTo('App\User','user_id','id');
   }
}
