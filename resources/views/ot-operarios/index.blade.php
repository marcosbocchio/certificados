@extends('layouts.enod.master')

@section('contenido')

<div id="app">

   <ot-operarios
    :ot_id_data = "{{$id}}"
    :ot_operarios_data= "{{$users_ot_operarios}}" 
   
   ></ot-operarios>

</div>
@endsection


@section('script')

<script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
        'user' => Auth::user()
    ]) !!};
</script>

@endsection

