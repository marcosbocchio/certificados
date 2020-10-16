@extends('layouts.enod.master')

@section('contenido')

<div id="app">
   <abm-maestro modelo= "clientes" permiso_create="M_clientes_edita"></abm-maestro>
</div>

@endsection
