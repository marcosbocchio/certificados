<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehiculos;

class OtVehiculosController extends Controller
{
   public function getVehiculosOt($ot_id) {

    return Vehiculos::join('ot_vehiculos','ot_vehiculos.vehiculo_id','=','vehiculos.id')
                      ->where('ot_vehiculos.ot_id',$ot_id)
                      ->select('vehiculos.*')
                      ->get();

   }
}
