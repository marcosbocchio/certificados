<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtSoldadores extends Model
{
   protected $table = 'ot_soldadores';
   protected $fillable = ['ot_id','soldadores_id'];

}
