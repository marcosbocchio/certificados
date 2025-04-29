<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NormasFabricacion extends Model
{
    protected $table = 'normas_fabricacion';
    protected $fillable = [
        
        'codigo','descripcion',
    ];
}
