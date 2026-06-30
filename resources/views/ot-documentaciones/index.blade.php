@extends('layouts.enod.master')

@section('contenido')

<div id="app">
  <enod-help-button url="{{ route('ayuda-asignar-vehiculos') }}"></enod-help-button>

   <ot-documentaciones
        :ot_data = "{{$ot}}" 
        :documentaciones_data = "{{$ot_documentaciones}}" 
        :vehiculos_data = "{{$ot_vehiculos}}"   
   ></ot-documentaciones>

</div>
@endsection
