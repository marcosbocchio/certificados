@extends('layouts.enod.master')

@section('contenido')

<div id="app">

   <asistencia-table-horas
   :frentes_data="{{ $frentes }}"
   :user_frente="{{ $user_frente }}"
   ></asistencia-table-horas>

</div>
@endsection