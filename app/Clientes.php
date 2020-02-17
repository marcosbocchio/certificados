<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $table = "clientes";
    

    public function contactos(){

        return $this->hasMany('App\Contactos','cliente_id','id');

    }
  

    public function localidad(){

      return $this->belongsTo('App\Localidades','localidad_id','id');
        
    }

    public function scopeFiltro($query, $filtro='') {

        if (trim($filtro) != '') {
           
              $query->WhereRaw("clientes.nombre_fantasia LIKE '%" . $filtro . "%'")
                    ->orWhereRaw("clientes.razon_social LIKE '%" . $filtro . "%'")    
                    ->orWhereRaw("clientes.email LIKE '%" . $filtro . "%'")
                    ->orWhereRaw("localidades.localidad LIKE '%" . $filtro . "%'");  
       
        }
     
    }

}
