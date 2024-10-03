@extends('layouts.enod.master')

@section('contenido')

<div id="app">
   <asistencia-pagos-servicios 
      :frentes="{{ $frentes }}"
   ></asistencia-pagos-servicios>
</div>
@endsection