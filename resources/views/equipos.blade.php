@extends('layouts.enod.master')

@section('contenido')

<div id="app">

   <enod-help-button url="{{ route('ayuda-gestion-equipos') }}"></enod-help-button>

   <abm-maestro modelo= "equipos" permiso_create="M_equipos_edita"></abm-maestro>

</div>
@endsection
