@extends('layouts.enod.master')

@section('contenido')

<div id="app">

   <ot-documentaciones
        :ot_data = "{{$ot}}" 
        :documentaciones_data = "{{$ot_documentaciones}}" 
        :vehiculos_data = "{{$ot_vehiculos}}"   
   ></ot-documentaciones>

</div>
@endsection
