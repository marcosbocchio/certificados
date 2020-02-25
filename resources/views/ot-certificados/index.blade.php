@extends('layouts.enod.master')

@section('contenido')

<div id="app">

   <ot-certificados
    :ot_id_data = "{{$ot_id}}"    
   ></ot-certificados>

</div>
@endsection