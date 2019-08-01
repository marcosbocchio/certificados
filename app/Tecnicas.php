<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Tecnicas extends Model
{
    protected $table='tecnicas';

    public function Graficos()
    {
        return $this->hasMany('App\TecnicasGraficos','tecnica_id');
    }
}
