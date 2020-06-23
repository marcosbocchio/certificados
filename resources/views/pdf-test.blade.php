@extends('layouts.enod.master')

@section('contenido')

<div id="app">

   <pdf-test></pdf-test>

</div>
@endsection

@section('css')
    <!-- icheck -->
    <link  rel="stylesheet" href="{{asset('adminlte/plugins/iCheck/icheck.js')}}">
@endsection