<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Si el usuario tiene rol Cliente, verifica que la OT pertenezca a su cliente.
     * ENOD/Admin/Sistemas no se restringen. ot_id vacío o 0 se permite (sin OT específica).
     */
    protected function autorizarOtCliente($ot_id)
    {
        $user = auth()->user();

        if (!$user || !($user->hasRole('Cliente') || $user->cliente_id)) {
            return;
        }

        if (empty($ot_id) || $ot_id == 0) {
            return;
        }

        $ot = \App\Ots::find($ot_id);

        if (!$ot || $ot->cliente_id != $user->cliente_id) {
            abort(403, 'No tiene acceso a esta orden de trabajo.');
        }
    }

    /**
     * Si el usuario tiene rol Cliente o cliente_id asignado, fuerza el filtrado a su propio
     * cliente, ignorando cualquier cliente_id recibido desde el front (query/route param).
     * ENOD/Admin/Sistemas no se restringen: se les devuelve el cliente_id recibido tal cual.
     */
    protected function resolverClienteId($cliente_id)
    {
        $user = auth()->user();

        if ($user && ($user->hasRole('Cliente') || $user->cliente_id)) {
            return $user->cliente_id;
        }

        return $cliente_id;
    }
}
