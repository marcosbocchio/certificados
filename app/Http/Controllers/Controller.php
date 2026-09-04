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

        $asignado = \App\OtUsuariosClientes::where('ot_id', $ot_id)
            ->where('user_id', $user->id)
            ->exists();

        if (!$asignado) {
            abort(403, 'No tiene acceso a esta orden de trabajo.');
        }
    }
}
