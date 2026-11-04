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

    /**
     * OTs que el usuario puede ver:
     * - Cliente: solo las de ot_usuarios_clientes.
     * - Personal con O_todas_las_ots (o rol Sistemas): todas.
     * - Resto: solo donde figura en ot_operarios (operario o ayudante).
     */
    public function scopeVisiblesPara($query, $user)
    {
        if (!$user) {
            return $query->whereRaw('1 = 0');
        }

        if ($user->cliente_id) {
            if (!$user->hasRole('Cliente')) {
                return $query->whereRaw('1 = 0');
            }
            return $query->whereIn('ots.id', function ($sub) use ($user) {
                $sub->select('ot_id')->from('ot_usuarios_clientes')->where('user_id', $user->id);
            });
        }

        if ($user->can('O_todas_las_ots')) {
            return $query;
        }

        return $query->whereIn('ots.id', function ($sub) use ($user) {
            $sub->select('ot_id')->from('ot_operarios')->where('user_id', $user->id);
        });
    }

    public static function puedeAcceder($user, $ot_id)
    {
        if (!$user) {
            return false;
        }

        if (!$user->cliente_id && $user->can('O_todas_las_ots')) {
            return true;
        }

        return static::visiblesPara($user)->where('ots.id', $ot_id)->exists();
    }

    public function scopeOtfiltro($query, $filtro='') {

        if (trim($filtro) != '') {
           
              $query->WhereRaw("proyecto LIKE '%" . $filtro . "%'")
                    ->orWhereRaw("numero LIKE '%" . $filtro . "%'")    
                    ->orWhereRaw("obra LIKE '%" . $filtro . "%'")
                    ->orWhereRaw("clientes.nombre_fantasia LIKE '%" . $filtro . "%'");
    
       
        }
     
    }

    public function contratista()
    {
        return $this->belongsTo('App\Contratistas','contratista_id','id');
    }


}
