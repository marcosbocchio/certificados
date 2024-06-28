@extends('layouts.enod.master')

@section('contenido')

<div id="app">

   <asistencia-table
   :frentes_data="{{ $frentes }}"
   :user_frente="{{ $user_frente }}"
   ></asistencia-table>

</div>
@endsection