@extends('layouts.enod.master')

@section('contenido')

<div id="app">
  <enod-help-button url="{{ route('ayuda-asignar-operadores') }}"></enod-help-button>
  <enod-guia-roles-link></enod-guia-roles-link>

   <ot-operarios
    :ot_id_data = "{{$id}}"
    :ot_operarios_data= "{{$users_ot_operarios}}" 
   
   ></ot-operarios>

</div>
@endsection


