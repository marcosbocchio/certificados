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

    public function scopeProyecto($query, $filtro='') {

        if (trim($filtro) != '') {
           
              $query->WhereRaw("proyecto LIKE '%" . $filtro . "%'")
                    ->orWhereRaw("numero LIKE '%" . $filtro . "%'")    
                    ->orWhereRaw("obra LIKE '%" . $filtro . "%'");
    
       
        }
     
    }

    /*
    public function scopeNumeroOt($query, $filtro='') {

        if (trim($filtro) != '') {
           
              $query->WhereRaw("numero LIKE '%" . $filtro . "%'");
    
       
        }
     
    }

    public function scopeObraOt($query, $filtro='') {

        if (trim($filtro) != '') {
           
              $query->WhereRaw("obra LIKE '%" . $filtro . "%'");
    
       
        }
     
    }

*/

}
