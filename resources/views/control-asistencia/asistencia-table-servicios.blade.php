@extends('layouts.enod.master')

@section('contenido')

<div id="app">

   <asistencia-table-servicios
   :frentes_data="{{ $frentes }}"
   :user_frente="{{ $user_frente }}"
   ></asistencia-table-servicios>

</div>
@endsection