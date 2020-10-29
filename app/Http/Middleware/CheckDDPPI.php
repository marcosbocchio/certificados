<?php

namespace App\Http\Middleware;

use Closure;
//use App\helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        DB::enableQueryLog();
        Log::debug("ejecuto CheckDDPPI :" . $request->ot_id);

        if(!PuedeCrearInforme($request->ot_id)){

            return abort(403, 'Unauthorized action.');

        }

        return $next($request);
    }
}
