@extends('layouts.enod.master')


@section('css')

<link rel="stylesheet"  href="{{asset('adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet"  href="{{asset('adminlte/plugins/timepicker/bootstrap-timepicker.min.css')}}">

@endsection


@section('contenido')

 <div id="app">

  <partes

  :otdata="{{$ot}}"
  :parte_data="{{$parte}}"
  :informes_ri_data="{{$informes_ri}}"
  :informes_ri_adicionales_data="{{$informes_ri_adicionales}}"
  :informes_pm_data="{{$informes_pm}}"
  :informes_lp_data="{{$informes_lp}}"
  :informes_us_data="{{$informes_us}}"
  :informes_cv_data="{{$informes_cv}}"
  :informes_dz_data="{{$informes_dz}}"
  :informes_tt_data="{{$informes_tt}}"
  :informes_importados_data="{{$informes_importados}}"
  :servicios_data="{{$servicios}}"
  :vehiculos_data="{{$vehiculos}}"
  :responsables_data="{{$responsables}}"
  editmode


  ></partes>

 </div>

@endsection


@section('script')

<script type="text/javascript" src="{{asset('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset('adminlte/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/lodash.js')}}"></script>

@endsection
