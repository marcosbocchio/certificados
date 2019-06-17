@extends('layouts.enod.master')

@section('contenido')
 
 <div id="app">

  <certificados></certificados>

 </div>

@endsection


@section('script')

    <script type="text/javascript" src="{{asset('js/app.js')}}"></script>

@endsection
