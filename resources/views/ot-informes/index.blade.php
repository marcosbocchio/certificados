@extends('layouts.enod.master')

@section('contenido')

<?php // return dd($ot_informes);?>

<div id="app">

   <ot-informes
    :ot_id_data = "{{$id}}"
    :ot_metodos_ensayos_data ="{{$ot_metodos_ensayos}}"
   
   ></ot-informes>

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