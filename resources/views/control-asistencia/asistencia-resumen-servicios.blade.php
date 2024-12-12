@extends('layouts.enod.master')

@section('contenido')

<div id="app">
   <asistencia-resumen-servicios
   :frentes_opciones="{{ json_encode($frente_sn) }}"
   ></asistencia-resumen-servicios>
</div>
@endsection