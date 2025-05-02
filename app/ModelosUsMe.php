<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelosUsMe extends Model
{
    protected $table = 'modelos_us_me';
    protected $fillable = [
        'codigo',
        'descripcion',
    ];
}
