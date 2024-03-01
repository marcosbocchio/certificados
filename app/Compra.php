<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compra'; // Asegúrate de que el nombre de la tabla es correcto

    protected $fillable = [
        'fecha', 'fecha_remito', 'proveedor_id', 'numero_remito', 'obs','anulado_sn',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    public function scopeWithSearch($query, $filtro)
    {
        if ($filtro) {
            $query->where('numero_remito', 'LIKE', "%{$filtro}%")
                  ->orWhereHas('proveedor', function($q) use ($filtro) {
                      $q->where('razon_social', 'LIKE', "%{$filtro}%");
                  });
        }
    }
}
