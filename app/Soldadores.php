<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Soldadores extends Model
{
    protected $table ='soldadores';
    protected $fillable = ['cliente_id','codigo','nombre'];

}
