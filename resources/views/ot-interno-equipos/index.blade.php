@extends('layouts.enod.master')

@section('contenido')

<div id="app">

   <ot-interno-equipos
    :ot_id_data = "{{$ot_id}}"
    :interno_equipos_data= "{{$interno_equipos}}" 
   
   ></ot-interno-equipos>

</div>
@endsection


