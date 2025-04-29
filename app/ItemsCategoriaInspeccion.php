<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemsCategoriaInspeccion extends Model
{
    protected $table = "items_categoria_inspeccion";

    public function categoria()
    {
        return $this->belongsTo(CategoriasInspeccion::class, 'categoria_id');
    }
}
