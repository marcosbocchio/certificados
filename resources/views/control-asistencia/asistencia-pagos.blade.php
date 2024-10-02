@extends('layouts.enod.master')

@section('contenido')

<div id="app">
   <asistencia-pagos 
      :frentes="{{ $frentes }}"
   ></asistencia-pagos>
</div>
@endsection