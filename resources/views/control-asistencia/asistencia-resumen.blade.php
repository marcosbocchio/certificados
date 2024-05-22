@extends('layouts.enod.master')

@section('contenido')

<div id="app">
   <asistencia-resumen
   :frentes_opciones="{{ json_encode($frente_sn) }}"
   ></asistencia-resumen>
</div>
@endsection