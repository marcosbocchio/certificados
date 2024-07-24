<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleRemitos extends Model
{
   protected $table = 'detalle_remitos';

   public function producto()
   {
       return $this->belongsTo(Productos::class, 'producto_id', 'id');
   }
}
