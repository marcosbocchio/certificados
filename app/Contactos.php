<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contactos extends Model
{
    protected $table = "contactos";
    protected $fillable = ['cliente_id','nombre','cargo','tel','email'];
}
