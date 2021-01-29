<?php

namespace App\Http\Middleware;

use Closure;

class Token_sincronizacion
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

        $this->validateLogin($request);
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $apiToken = Auth::user()->api_token;
            return response()->json($apiToken);
        }
        return response()->json("Datos invalidos", 401,['Content-type'=>'application/json;charset=utf-8'],JSON_UNESCAPED_UNICODE);

        return $next($request);
    }
}
