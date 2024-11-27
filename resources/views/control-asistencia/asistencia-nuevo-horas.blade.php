@extends('layouts.enod.master')

@section('contenido')

<div id="app">

<asistencia-nuevo-horas
        :frentes_opciones="{{ json_encode($frente_sn) }}"
        :metodo_ensayos="{{ json_encode($metodoEnsayos) }}"
        :operarios_opciones="{{ json_encode($operarios) }}"
        :contratistas_opciones="{{ json_encode($contratistas) }}"
        :fechas_por_frente="{{ json_encode($fechasPorFrente) }}">
    </asistencia-nuevo-horas>

</div>
@endsection