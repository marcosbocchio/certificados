<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtUsuariosClientes extends Model
{
    protected $table = 'ot_usuarios_clientes';
    protected $fillable = ['ot_id','user_id'];
}
