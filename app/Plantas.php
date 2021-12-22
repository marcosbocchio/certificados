<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plantas extends Model
{
    protected $table ='plantas';
    protected $fillable = ['cliente_id','codigo','nombre'];

}
