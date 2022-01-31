@extends('layouts.enod.master')


@section('css')

<link rel="stylesheet"  href="{{asset('adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet"  href="{{asset('adminlte/plugins/timepicker/bootstrap-timepicker.min.css')}}">

@endsection


@section('contenido')
 <div id="app">



  <informe-pm

     metodo ="{{$metodo}}"
     :otdata  ="{{$ot}}"
     :informedata ="{{$informe}}"
     :informe_pmdata ="{{$informe_pm}}"
     :ot_tipo_soldaduradata = "{{$informe_ot_tipo_soldadura}}"
     :materialdata="{{$informe_material}}"
     :material2data ="{{$informe_material_accesorio}}"
     :diametrodata="{{$informe_diametro}}"
     :diametro_espesordata="{{$informe_diametroEspesor}}"
     :tecnicadata="{{$informe_tecnica}}"
     :interno_equipodata="{{$informe_interno_equipo}}"
     :procedimientodata="{{$informe_procedimiento}}"
     :norma_evaluaciondata="{{$informe_norma_evaluacion}}"
     :norma_ensayodata="{{$informe_norma_ensayo}}"
     :ejecutor_ensayodata="{{$informe_ejecutor_ensayo}}"
     :metodo_trabajo_pmdata="{{$informe_pm_metodo_trabajo_pm}}"
     :tipo_magnetizacion_data = "{{$informe_pm_tipo_magnetizacion}}"
     :magnetizacion_data = "{{$informe_pm_magnetizacion}}"
     :desmagnetizacion_sn_data = "{{$informe_pm_desmagnetizacion_sn}}"
     :iluminacion_data = "{{$informe_pm_iluminacion}}"
     :contraste_data = "{{$informe_pm_contraste}}"
     :particula_data ="{{$informe_pm_particula}}"
     :detalledata="{{$informe_detalle}}"
     :instrumento_medicion_data = "{{$informe_instrumento_medicion}}"
     :tablaModelos3d_data="{{$informe_modelos_3d}}"
     :solicitado_pordata = "{{$informe_solicitado_por}}"
     editmode

  ></informe-pm>

 </div>

@endsection


@section('script')

<script type="text/javascript" src="{{asset('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset('adminlte/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/lodash.js')}}"></script>

@endsection
