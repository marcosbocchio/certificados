@extends('layouts.enod.master')

@section('contenido')

<div id="app">
  <enod-help-button url="{{ route('ayuda-gestionar-roles') }}"></enod-help-button>
  <enod-guia-roles-link></enod-guia-roles-link>

   <abm-maestro modelo= "roles" permiso_create="M_roles_edita"></abm-maestro>

</div>
@endsection

@section('css')
    <!-- icheck -->
    <link  rel="stylesheet" href="{{asset('adminlte/plugins/iCheck/icheck.js')}}">
@endsection

