@extends('layouts.enod.master')


@section('css')

<link rel="stylesheet"  href="{{asset('adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet"  href="{{asset('adminlte/plugins/timepicker/bootstrap-timepicker.min.css')}}">
   
@endsection


@section('contenido')
 
 <div id="app">

 <partes-manuales :ot_id="{{ $ot_id }}"
  :cliente="'{{ $clienteNombre }}'"
  :proyecto="'{{ $proyecto }}'"
  :orden-trabajo-numero="'{{ $ordenTrabajoNumero }}'"
  :plantas='@json($plantas)'
  :operadores='@json($operador_opcion)'
  :ot="'{{ $ot }}'"
  :inspectores_op ='@json($inspectores_op)'
  ></partes-manuales>

 </div>

@endsection


@section('script')

<script type="text/javascript" src="{{asset('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset('adminlte/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/lodash.js')}}"></script>

@endsection