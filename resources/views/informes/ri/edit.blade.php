@extends('layouts.enod.master')


@section('css')

<link rel="stylesheet"  href="{{asset('adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet"  href="{{asset('adminlte/plugins/timepicker/bootstrap-timepicker.min.css')}}">
<script type="text/javascript" src="{{asset('js/sheetjs/shim.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/sheetjs/xlsx.full.min.js')}}"></script>
@endsection

@section('contenido')
 <div id="app">

  <informe-ri

      metodo ="{{$metodo}}"
     :otdata  ="{{$ot}}"
     :informedata ="{{$informe}}"
     :informe_ridata ="{{$informe_ri}}"
     :tipo_soldaduradata = "{{$informe_tipo_soldadura}}"
     :ot_tipo_soldaduradata = "{{$informe_ot_tipo_soldadura}}"
     :materialdata="{{$informe_material}}"
     :material2data ="{{$informe_material_accesorio}}"
     :diametrodata="{{$informe_diametro}}"
     :diametro_espesordata="{{$informe_diametroEspesor}}"
     :interno_fuentedata="{{$informe_interno_fuente}}"
     :tecnicadata="{{$informe_tecnica_grafico}}"
     :interno_equipodata="{{$informe_interno_equipo}}"
     :procedimientodata="{{$informe_procedimiento}}"
     :tipo_peliculadata="{{$infome_tipo_pelicula}}"
     :icidata="{{$informe_ici}}"
     :norma_evaluaciondata="{{$informe_norma_evaluacion}}"
     :norma_ensayodata="{{$informe_norma_ensayo}}"
     :ejecutor_ensayodata="{{$informe_ejecutor_ensayo}}"
     :detalledata="{{$informe_detalle}}"
     :pasada_juntas_data="{{$informe_pasada_juntas}}"
     :tablaModelos3d_data="{{$informe_modelos_3d}}"
     editmode

  ></informe-ri>

 </div>

@endsection

@section('script')

<script type="text/javascript" src="{{asset('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset('adminlte/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/lodash.js')}}"></script>

@endsection
