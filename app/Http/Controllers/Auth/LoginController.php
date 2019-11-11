<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /*
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectPath()
    {

        return '/area/enod';

        $User = auth()->user();

        /* Si tiene el permiso "Navegar operador" es Administrador u operador */

        /*

        if($User->hasPermissionTo('Navegar operador')){

            return '/area/enod';

         }elseif($User->hasPermissionTo('Navegar cliente')){

            return '/area/enod';
        }

        */
      }
}
