<?php

namespace App\Http\Middleware;

use Closure;
use App\Ots;

class AccesoOt
{
    /**
     * Si la ruta recibe una OT (ot_id, id_ot u ot), verifica que el usuario pueda verla.
     */
    public function handle($request, Closure $next)
    {
        $route = $request->route();

        if ($route) {
            foreach (['ot_id', 'id_ot', 'ot'] as $param) {
                $valor = $route->parameter($param);

                if (is_object($valor)) {
                    $valor = $valor->id;
                }

                if ($valor !== null && is_numeric($valor) && (int) $valor > 0) {
                    if (!Ots::puedeAcceder($request->user(), (int) $valor)) {
                        abort(403, 'No tiene acceso a esta orden de trabajo.');
                    }
                }
            }
        }

        return $next($request);
    }
}
