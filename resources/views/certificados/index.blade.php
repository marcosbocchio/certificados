@extends('layouts.enod.master')


@section('css')

<link rel="stylesheet"  href="{{asset('adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet"  href="{{asset('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
   
@endsection


@section('contenido')
 
 <div id="app">

  <certificados></certificados>

 </div>

@endsection


@section('script')

    <script type="text/javascript" src="{{asset('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <script type="text/javascript" src="{{asset('adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('')}}"></script>
    <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
    <script>





    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

   

    </script>

@endsection

