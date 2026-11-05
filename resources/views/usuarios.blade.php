@extends('layouts.enod.master')

@section('contenido')

<div id="app">
  <enod-help-button url="{{ route('ayuda-gestion-usuario') }}"></enod-help-button>
  <enod-guia-roles-link></enod-guia-roles-link>

   <abm-maestro modelo= "users" permiso_create="M_usuarios_edita" ></abm-maestro>

</div>
@endsection