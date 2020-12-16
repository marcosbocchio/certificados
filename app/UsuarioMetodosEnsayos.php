<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioMetodosEnsayos extends Model
{
    protected $table = "usuario_metodos_ensayos";

    protected $fillable = [
        'metodo_ensayo_id','user_id',
    ];

}
