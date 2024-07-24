<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asignacion_epp extends Model
{

    public function remito()
    {
        return $this->belongsTo(Remitos::class, 'remito_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function detalles()
    {
        return $this->hasMany(Detalle_asignacion_epp::class);
    }
    
    protected $fillable = [
        'fecha',
        'operador_id',
        'user_id',
        'remito_id'
    ];

    protected $table="asignacion_epp";
}
