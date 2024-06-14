@extends('layouts.enod.master')

@section('contenido')

<div id="app">

   <abm-maestro modelo= "users" permiso_create="M_usuarios_edita" ></abm-maestro>

</div>
@endsection