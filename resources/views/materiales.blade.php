@extends('layouts.enod.master')

@section('contenido')

<div id="app">

   <abm-maestro  modelo= "materiales" ></abm-maestro>

</div>
@endsection


@section('script')

    <script type="text/javascript" src="{{asset('js/app.js')}}"></script>

@endsection