<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OperadorControl extends Model
{
    protected $table = 'operador_control';

    protected $fillable = [
        'frente_id',
        'operador_id',
        'mes',
        'dias_habiles_trabajados',
        'sabados_trabajados',
        'domingos_trabajados',
        'feriados_trabajados',
        'horas_extras_trabajadas',
        'servicios_extras_s1',
        'servicios_extras_s2',
        'servicios_extras_s3',
        'servicios_extras_s4',
        'servicios_extras_s5',
        'fecha_pago_s1',
        'fecha_pago_s2',
        'fecha_pago_s3',
        'fecha_pago_s4',
        'fecha_pago_s5',
        'fecha_pago_mes',
        'pago_mes_sn'
    ];
}
