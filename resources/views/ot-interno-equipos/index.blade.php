@extends('layouts.enod.master')

@section('contenido')

<div id="app">
  <enod-help-button url="{{ route('ayuda-asignar-vehiculos') }}"></enod-help-button>

   <ot-interno-equipos
    :ot_id_data = "{{$ot_id}}"
    :ot_interno_equipos_data= "{{$ot_interno_equipos}}"

   ></ot-interno-equipos>

</div>
@endsection


