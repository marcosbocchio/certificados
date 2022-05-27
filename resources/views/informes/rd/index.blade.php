@extends('layouts.enod.master')


@section('css')

<link rel="stylesheet"  href="{{asset('adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet"  href="{{asset('adminlte/plugins/timepicker/bootstrap-timepicker.min.css')}}">
<script type="text/javascript" src="{{asset('js/sheetjs/shim.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/sheetjs/xlsx.full.min.js')}}"></script>

@endsection


@section('contenido')
 <div id="app">

  <informe-rd

    metodo="{{$metodo}}"
    :otdata="{{$ot}}"

  ></informe-rd>

 </div>

@endsection

@section('script')

<script type="text/javascript" src="{{asset('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset('adminlte/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/lodash.js')}}"></script>

@endsection
