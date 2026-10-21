@extends('layouts.enod.master')

@section('contenido')

<div id="app">

   <enod-help-button url="{{ route('ayuda-gestion-interno-equipos') }}"></enod-help-button>

   <abm-maestro modelo= "interno_equipos" permiso_create="M_interno_equipos_edita" ></abm-maestro>

</div>
@endsection
