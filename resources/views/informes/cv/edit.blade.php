@extends('layouts.enod.master')


@section('css')

<link rel="stylesheet"  href="{{asset('adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet"  href="{{asset('adminlte/plugins/timepicker/bootstrap-timepicker.min.css')}}">

@endsection


@section('contenido')
 <div id="app">



  <informe-cv

      metodo="{{$metodo}}"
      :otdata  ="{{$ot}}"
      :informedata ="{{$informe}}"
      :informe_cvdata ="{{$informe_cv}}"
      :materialdata="{{$informe_material}}"
      :material2data ="{{$informe_material_accesorio}}"
      :norma_evaluaciondata="{{$informe_norma_evaluacion}}"
      :norma_ensayodata="{{$informe_norma_ensayo}}"
      :ejecutor_ensayodata="{{$informe_ejecutor_ensayo}}"
      :tablaModelos3d_data="{{$informe_modelos_3d}}"
      :procedimientodata="{{$informe_procedimiento}}"
      :campanadata="{{$informe_campana}}"
      :bombadata="{{$informe_bomba}}"
      :ot_tipo_soldaduradata = "{{$informe_ot_tipo_soldadura}}"
      :aplicaciondata = "{{$informe_modo_aplicacion}}"
      :detalledata = "{{$informe_detalle}}"
      :solicitado_pordata = "{{$informe_solicitado_por}}"
      editmode

  ></informe-cv>

 </div>

@endsection


@section('script')

<script type="text/javascript" src="{{asset('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset('adminlte/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/lodash.js')}}"></script>

@endsection
