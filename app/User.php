<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;


class User extends Authenticatable
{

    use Notifiable , HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'codigo','name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = ['notificaciones_resumen','firmas_usuarios'];

    public function getId(){

        return $this->id;
    }

   // protected $appends = ['all_permissions','can'];

    public function getAllPermissionsAttribute()
    {
        return $this->getAllPermissions();
    }

     /**
     * Get all user permissions in a flat array.
     *
     * @return array
     */
    public function getCanAttribute()
    {
        $permissions = [];
        foreach (Permission::all() as $permission) {
            if (Auth::user()->can($permission->name)) {
                $permissions[$permission->name] = true;
            } else {
                $permissions[$permission->name] = false;
            }
        }
        return $permissions;
    }


    public function cliente(){

        return $this->belongsTo('App\Clientes','cliente_id','id');

    }

    public function notificaciones_resumen()
    {
        return $this->hasMany('App\NotificacionesResumenView','user_id','id')->orderBy('tipo','asc');
    }

    public function firmas_usuarios()
    {
        return $this->hasMany('App\FirmaUsuario','user_id','id');
    }


    public function periodos()
    {
        return $this->hasMAny('App\OperadorPeriodoRx','operador_id','id');
    }

    public function scopeFiltro($query, $filtro='') {

        if (trim($filtro) != '') {

              $query->WhereRaw("users.name LIKE '%" . $filtro . "%'")
                    ->orWhereRaw("users.email LIKE '%" . $filtro . "%'")
                    ->orWhereHas('cliente', function ($q) use($filtro) {
                        $q->WhereRaw("clientes.nombre_fantasia LIKE '%" . $filtro . "%'");
                    });

        }

    }

}
