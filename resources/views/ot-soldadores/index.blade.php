@extends('layouts.enod.master')

@section('contenido')

<div id="app">
  <enod-help-button url="{{ route('ayuda-asignar-soldadores-y-usuarios') }}"></enod-help-button>
  <enod-guia-roles-link></enod-guia-roles-link>

   <ot-soldadores
    :ot_data = "{{$ot}}" 
    :soldadores_data = "{{$ot_soldadores}}"
    :usuarios_cliente_data = "{{$ot_usuarios_cliente}}"
   
   ></ot-soldadores>

</div>
@endsection
