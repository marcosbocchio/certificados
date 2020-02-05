<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ots extends Model
{
    protected $table = "ots";

    public function cliente()
    {
        return $this->belongsTo('App\Clientes','cliente_id','id');
    }

    public function localidad(){

        return $this->belongsTo('App\Localidades','localidad_id','id');
      
    }

    public function scopeOtfiltro($query, $filtro='') {

        if (trim($filtro) != '') {
           
              $query->WhereRaw("proyecto LIKE '%" . $filtro . "%'")
                    ->orWhereRaw("numero LIKE '%" . $filtro . "%'")    
                    ->orWhereRaw("obra LIKE '%" . $filtro . "%'")
                    ->orWhereRaw("clientes.nombre_fantasia LIKE '%" . $filtro . "%'");
    
       
        }
     
    }


}
