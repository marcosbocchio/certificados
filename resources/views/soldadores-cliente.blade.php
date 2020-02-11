@extends('layouts.enod.master')

@section('contenido')

<div id="app">

   <abm-maestro modelo= '{{ $modelo }}' permiso_create="M_soldadores_edita"></abm-maestro>

</div>
@endsection
