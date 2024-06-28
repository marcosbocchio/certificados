<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FrentesOperador extends Model
{
    protected $table = 'frentre_operador';

    protected $fillable = ['frente_id', 'user_id'];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
