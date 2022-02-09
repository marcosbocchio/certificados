@extends('layouts.enod.master')


@section('css')

<link rel="stylesheet"  href="{{asset('adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet"  href="{{asset('adminlte/plugins/timepicker/bootstrap-timepicker.min.css')}}">

@endsection


@section('contenido')
 <div id="app">



  <informe-lp

     metodo ="{{$metodo}}"
     :otdata  ="{{$ot}}"
     :informedata ="{{$informe}}"
     :ot_tipo_soldaduradata = "{{$informe_ot_tipo_soldadura}}"
     :informe_lpdata ="{{$informe_lp}}"
     :materialdata="{{$informe_material}}"
     :material2data ="{{$informe_material_accesorio}}"
     :diametrodata="{{$informe_diametro}}"
     :diametro_espesordata="{{$informe_diametroEspesor}}"
     :interno_equipodata="{{$informe_interno_equipo}}"
     :procedimientodata="{{$informe_procedimiento}}"
     :norma_evaluaciondata="{{$informe_norma_evaluacion}}"
     :norma_ensayodata="{{$informe_norma_ensayo}}"
     :ejecutor_ensayodata="{{$informe_ejecutor_ensayo}}"
     :metodo_trabajo_lpdata="{{$informe_metodo_trabajo_lp}}"
     :penetrante_tipo_liquido_data="{{$penetrante_tipo_liquido}}"
     :revelador_tipo_liquido_data="{{$revelador_tipo_liquido}}"
     :removedor_tipo_liquido_data="{{$removedor_tipo_liquido}}"
     :penetrante_aplicacion_data="{{$penetrante_aplicacion}}"
     :revelador_aplicacion_data="{{$revelador_aplicacion}}"
     :removedor_aplicacion_data="{{$removedor_aplicacion}}"
     :solicitado_pordata = "{{$informe_solicitado_por}}"
     :iluminacion_data = "{{$informe_lp_iluminacion}}"
     :detalledata="{{$informe_detalle}}"
     :tablaModelos3d_data="{{$informe_modelos_3d}}"

     editmode

  ></informe-lp>

 </div>

@endsection


@section('script')

<script type="text/javascript" src="{{asset('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset('adminlte/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/lodash.js')}}"></script>

@endsection
