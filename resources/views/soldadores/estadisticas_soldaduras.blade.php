@extends('layouts.enod.master')

@section('contenido')


<div id="app">

   <estadisticas-soldaduras
         :user= "{{ $user }}"
   ></estadisticas-soldaduras>

</div>

@endsection

