<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParteManual extends Model
{
    protected $table = 'parte_manual';

    protected $fillable = ['ot_id','usuario_alta_id', 'obra', 'fecha'];

    public function detalles()
    {
        return $this->hasMany(ParteManualDetalle::class, 'parte_manual_id');
    }

    // Si tienes un modelo para OT y quieres relacionarlo
    public function ot()
    {
        return $this->belongsTo(OT::class, 'ot_id');
    }

    // Método para encontrar un parte manual por su ID
    public static function find($id)
    {
        return static::where('id', $id)->first();
    }
}