@extends('layouts.enod.master')

@section('contenido')

<div id="app">

   <ot-documentaciones
        :ot_data = "{{$ot}}" 
        :documentaciones_data = "{{$ot_documentaciones}}"   
   ></ot-documentaciones>

</div>
@endsection


@section('script')

<script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
        'user' => Auth::user()
    ]) !!};
</script>

<script type="text/javascript" src="{{asset('js/app.js')}}"></script>

@endsection