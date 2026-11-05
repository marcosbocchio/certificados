@extends('layouts.enod.master')

@section('contenido')

<div id="app">
  <enod-help-button url="{{ route('ayuda-crear-certificados') }}"></enod-help-button>

   <ot-certificados
    :ot_id_data = "{{$ot_id}}"    
   ></ot-certificados>

</div>
@endsection