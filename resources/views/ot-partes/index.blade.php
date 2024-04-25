@extends('layouts.enod.master')

@section('contenido')

<div id="app">

   <ot-partes
    :ot_id_data = "{{$ot_id}}"
    :ot_data="{{$ot}}"    
   ></ot-partes>

</div>
@endsection
