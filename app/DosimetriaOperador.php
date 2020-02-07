<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DosimetriaOperador extends Model
{
    protected $table="dosimetria_operador";
    protected $fillable = ['operador_id','microsievert','fecha','observaciones','user_id'];
}
