@extends('layouts.enod.master')

@section('contenido')

<div id="app">

   <ot-soldadores
    :ot_data = "{{$ot}}" 
    :soldadores_data = "{{$ot_soldadores}}"
    :usuarios_cliente_data = "{{$ot_usuarios_cliente}}"
   
   ></ot-soldadores>

</div>
@endsection
