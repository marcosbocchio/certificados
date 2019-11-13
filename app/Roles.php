<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table="roles";

    public function permisos()
    {
        return $this->belongsToMany('App\Permissions','role_has_permissions','role_id','permission_id');
    }
 
}
