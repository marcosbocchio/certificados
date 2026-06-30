@extends('layouts.enod.master')

@section('contenido')

<div id="app">
  <enod-help-button url="{{ route('ayuda-crear-parte-diario') }}"></enod-help-button>

   <ot-partes
    :ot_id_data = "{{$ot_id}}"
    :ot_data="{{$ot}}"
    :parte_esp="{{$parte_esp}}"
   ></ot-partes>

</div>
@endsection
