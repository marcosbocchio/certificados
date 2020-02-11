@extends('layouts.enod.master')

@section('contenido')

<div id="app">

   <ot-remitos
    :ot_id_data = "{{$ot_id}}"    
   ></ot-remitos>

</div>
@endsection

