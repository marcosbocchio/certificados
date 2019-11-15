@extends('layouts.enod.master')


@section('css')

<link rel="stylesheet"  href="{{asset('adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet"  href="{{asset('adminlte/plugins/timepicker/bootstrap-timepicker.min.css')}}">
   
@endsection


@section('contenido')
 
 <div id="app">


  <ots :otdata="{{$ot}}"
      :clientedata="{{$cliente}}"
      :contratistadata="{{$contratista}}"
      :ot_serviciosdata="{{$ot_servicios}}"
      :ot_calidad_placasdata="{{$ot_calidad_placas}}"
      :ot_productosdata="{{$ot_productos}}"
      acciondata="{{$accion}}"
      :otcontacto1data="{{$ot_contacto1}}"
      :otcontacto2data="{{$ot_contacto2}}"
      :otcontacto3data="{{$ot_contacto3}}"
      :users_empresadata ="{{$responsable_ot}}"
      :ot_eppsdata="{{$ot_epps}}"
      :ot_riesgosdata="{{$ot_riesgos}}"
      :ot_provinciasdata="{{$ot_provincia}}"
      :ot_localidaddata="{{$ot_localidad}}"
       ></ots>

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
    <script type="text/javascript" src="{{asset('js/lodash.js')}}"></script>

@endsection
