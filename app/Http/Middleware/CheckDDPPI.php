<?php

namespace App\Http\Middleware;

use Closure;
use App\helpers;
class CheckDDPPI
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        if(!PuedeCrearInforme($request->ot_id)){

            return abort(403, 'Unauthorized action.');

        }

        return $next($request);
    }
}
