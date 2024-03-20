<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stock';

    protected $fillable = [
        'producto_id', 
        'obs', 
        'cantidad', 
        'stock',
        'tipo_movimiento',
        'user_id',
    ];
    
    public function scopeFiltro($query, $filtro = '') {
        if (trim($filtro) != '') {
            
            $query->where(function ($query) use ($filtro) {
                $query->where('obs', 'LIKE', "%{$filtro}%")
                      ->orWhere('fecha', 'LIKE', "%{$filtro}%");
            }); 
        }
    }
}