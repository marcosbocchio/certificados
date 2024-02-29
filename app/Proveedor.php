<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';

    protected $fillable = [
        'cuit', 
        'razon_social', 
        'email', 
        'tel',
    ];

    public function scopeFiltro($query, $filtro='') {

        if (trim($filtro) != '') {
           
            $query->where(function ($query) use ($filtro) {
                $query->where('cuit', 'LIKE', "%{$filtro}%")
                      ->orWhere('razon_social', 'LIKE', "%{$filtro}%")
                      ->orWhere('email', 'LIKE', "%{$filtro}%");
            });  
       
        }
     
    }
}
