@extends('layouts.enod.master')

@section('contenido')

<div id="app">

   <ot-documentaciones
        :ot_data = "{{$ot}}" 
        :documentaciones_data = "{{$ot_documentaciones}}"   
   ></ot-documentaciones>

</div>
@endsection
