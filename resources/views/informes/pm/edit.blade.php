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
     :materialdata="{{$informe_material}}"
     :diametrodata="{{$informe_diametro}}"
     :diametro_espesordata="{{$informe_diametroEspesor}}"  
     :tecnicadata="{{$informe_tecnica}}"     
     :equipodata="{{$informe_equipo}}"
     :procedimientodata="{{$informe_procedimiento}}" 
     :norma_evaluaciondata="{{$informe_norma_evaluacion}}"
     :norma_ensayodata="{{$informe_norma_ensayo}}"
     :ejecutor_ensayodata="{{$informe_ejecutor_ensayo}}"
     :metodo_trabajo_pmdata="{{$informe_pm_metodo_trabajo_pm}}"
     :tipo_magnetizacion_data = "{{$informe_pm_tipo_magnetizacion}}"  
     :magnetizacion_data = "{{$informe_pm_magnetizacion}}"   
     :desmagnetizacion_sn_data = "{{$informe_pm_desmagnetizacion_sn}}"   
     :color_particula_data = "{{$infome_pm_color_particula}}"      
     :iluminacion_data = "{{$informe_pm_iluminacion}}"   
     :detalledata="{{$informe_detalle}}"     
     
     editmode  
    
  ></informe-pm>

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