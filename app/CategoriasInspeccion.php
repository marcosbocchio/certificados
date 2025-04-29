<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriasInspeccion extends Model
{
    protected $table = "categorias_inspeccion";

    public function items()
    {
        return $this->hasMany(ItemsCategoriaInspeccion::class, 'categoria_id');
    }
}
