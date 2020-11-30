@extends('layouts.enod.master')

@section('contenido')

<div id="app">

   <notificaciones
   :user_data  = "{{ $user }}"
   >

   </notificaciones>

</div>
@endsection
