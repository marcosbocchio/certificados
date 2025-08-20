<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productos_grupo extends Model
{
    protected $table="productos_grupo";

    protected $fillable = [
        'codigo',
        'descripcion',
    ];
}
