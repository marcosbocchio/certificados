<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contratistas extends Model
{
    protected $table='contratistas';
    protected $fillable = ['nombre','path_logo'];
}
