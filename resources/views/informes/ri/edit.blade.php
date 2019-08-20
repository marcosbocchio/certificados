@extends('layouts.enod.master')


@section('css')

<link rel="stylesheet"  href="{{asset('adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet"  href="{{asset('adminlte/plugins/timepicker/bootstrap-timepicker.min.css')}}">
   
@endsection


@section('contenido') 
 <div id="app">

   

  <informe-ri      
   
      metodo ="{{$metodo}}"
     :otdata  ="{{$ot}}"
     :informedata ="{{$informe}}"
     :informe_ridata ="{{$informe_ri}}"
     :materialdata="{{$informe_material}}"
     :diametrodata="{{$informe_diametro}}"
     :diametro_espesordata="{{$informe_diametroEspesor}}"
     :fuentedata="{{$informe_fuente}}"
     :tecnicadata="{{$informe_tecnica_grafico}}"
     :equipodata="{{$informe_equipo}}"
     :procedimientodata="{{$informe_procedimiento}}"
     :tipo_peliculadata="{{$infome_tipo_pelicula}}"
     :icidata="{{$informe_ici}}"
     :norma_evaluaciondata="{{$informe_norma_evaluacion}}"
     :norma_ensayodata="{{$informe_norma_ensayo}}"
     :ejecutor_ensayodata="{{$informe_ejecutor_ensayo}}"
     :detalledata="{{$informe_detalle}}"
     
     editmode  
    
  ></informe-ri>

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