@extends('layouts.enod.master')

@section('contenido')

<div id="app">

   <asistencia-table
   :frentes_data="{{ $frentes }}"
   ></asistencia-table>

</div>
@endsection