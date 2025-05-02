<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FluidosUsMe extends Model
{
    protected $table = 'fluidos_us_me';
    protected $fillable = [
        'codigo',
        'descripcion',
        // ...
    ];
}
