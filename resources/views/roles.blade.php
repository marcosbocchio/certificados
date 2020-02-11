@extends('layouts.enod.master')

@section('contenido')

<div id="app">

   <abm-maestro modelo= "roles" permiso_create="M_roles_edita"></abm-maestro>

</div>
@endsection

@section('css')
    <!-- icheck -->
    <link  rel="stylesheet" href="{{asset('adminlte/plugins/iCheck/icheck.js')}}">
@endsection

