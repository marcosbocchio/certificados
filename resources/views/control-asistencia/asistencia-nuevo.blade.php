@extends('layouts.enod.master')

@section('contenido')

<div id="app">

<asistencia-nuevo 
        :frentes_opciones="{{ json_encode($frente_sn) }}"
        :operarios_opciones="{{ json_encode($operarios) }}"
        :contratistas_opciones="{{ json_encode($contratistas) }}"
        :fechas_por_frente="{{ json_encode($fechasPorFrente) }}">
    </asistencia-nuevo>

</div>
@endsection