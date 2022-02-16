<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Informe extends Model
{
    protected $table='informes';

    public function ot(){

        return $this->belongsTo('App\Ots','ot_id','id');

    }

    public function metodoEnsayos(){

        return $this->belongsTo('App\MetodoEnsayos','metodo_ensayo_id','id');

     }

     public function tecnica(){

        return $this->belongsTo('App\Tecnicas','tecnica_id','id');

     }

     public function internoEquipo(){

        return $this->belongsTo('App\InternoEquipos','interno_equipo_id','id');

     }

     public function procedimiento(){

        return $this->belongsTo('App\Documentaciones','procedimiento_informe_id','id');

     }

     public function planta(){

        return $this->belongsTo('App\Plantas','planta_id','id');

     }

     public function material(){

        return $this->belongsTo('App\Materiales','material_id','id');

    }

    public function material2(){

        return $this->belongsTo('App\Materiales','material2_id','id');

    }

    public function otTipoSoldadura(){

        return $this->belongsTo('App\OtTipoSoldaduras','ot_tipo_soldadura_id','id');

    }

    public function normaEnsayo(){

        return $this->belongsTo('App\NormaEnsayos','norma_ensayo_id','id');

    }

    public function normaEvaluacion(){

        return $this->belongsTo('App\NormaEvaluaciones','norma_evaluacion_id','id');

    }

    public function informeTt(){

       return $this->hasOne('App\InformesTt','informe_id','id');

   }

   public function solicitadoPor() {
        return $this->belongsTo('App\User','solicitado_por','id');
   }

    public function scopeUs($query, $metodo, $tecnica = null) {

           if($metodo == 'US') {
               $query->join('tecnicas','tecnicas.id','=','informes.tecnica_id')
               ->where('tecnicas.codigo',$tecnica);
           }
    }
}
