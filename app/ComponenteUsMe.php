<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComponenteUsMe extends Model
{
    protected $table = 'componente_us_me';

    public function modelo(){

        return $this->hasOne('App\ModelosUsMe','id','modelo_id');
    
    }

    public function fluido(){

        return $this->hasOne('App\FluidosUsMe','id','fluido_id');
    
    }

    public function material(){
        return $this->hasOne('App\Materiales','id','material_id');
    }

    public function norma(){

        return $this->hasOne('App\NormasFabricacion','id','norma_fabric_id');
    
    }

    public function materiales()
    {
        return $this->hasMany('App\MaterialUs', 'componente_us_me_id', 'id');
    }
}
