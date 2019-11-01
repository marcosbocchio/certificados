@extends('layouts.enod.master')

@section('contenido')

<div id="app">

   <ot-interno-equipos
    :ot_id_data = "{{$ot_id}}"
    :interno_equipos_data= "{{$interno_equipos}}" 
   
   ></ot-interno-equipos>

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

