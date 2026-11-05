@extends('layouts.enod.master')

@section('contenido')

<div id="app">
  <enod-help-button url="{{ route('ayuda-gestion-permisos') }}"></enod-help-button>

   <abm-maestro modelo= "permissions" permiso_create="M_permisos_edita" ></abm-maestro>

</div>
@endsection

@section('css')
    <!-- icheck -->
    <link  rel="stylesheet" href="{{asset('adminlte/plugins/iCheck/icheck.js')}}">
@endsection
