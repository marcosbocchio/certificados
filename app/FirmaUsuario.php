<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FirmaUsuario extends Model
{
   protected $table='firmas_usuarios';
   protected $fillable = [
    'user_id','metodo_ensayo_id', 'path',
];
}
