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
     :informe_lpdata ="{{$informe_lp}}"
     :materialdata="{{$informe_material}}"
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
  
     :iluminacion_data = "{{$informe_lp_iluminacion}}"   
     :detalledata="{{$informe_detalle}}"     
     
     editmode  
    
  ></informe-lp>

 </div>

@endsection


@section('script')

<script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
        'user' => Auth::user()
    ]) !!};
</script>

    <script type="text/javascript" src="{{asset('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <script type="text/javascript" src="{{asset('adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('adminlte/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/lodash.js')}}"></script>





@endsection