@extends('layouts.enod.master')


@section('css')

<link rel="stylesheet"  href="{{asset('adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet"  href="{{asset('adminlte/plugins/timepicker/bootstrap-timepicker.min.css')}}">
   
@endsection


@section('contenido')
 
 <div id="app">


  <ots :otdata="{{$ot}}" 
      :clientedata="{{$cliente}}" 
      :ot_serviciosdata="{{$ot_servicios}}" 
      :ot_productosdata="{{$ot_productos}}"
      acciondata="{{$accion}}"
      :otcontacto1data="{{$ot_contacto1}}"
      :otcontacto2data="{{$ot_contacto2}}"
      :ot_eppsdata="{{$ot_epps}}"
      :ot_riesgosdata="{{$ot_epps}}"
       ></ots>

 </div>

@endsection


@section('script')

    <script type="text/javascript" src="{{asset('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <script type="text/javascript" src="{{asset('adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('adminlte/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/lodash.js')}}"></script>


    <script>



/*

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    $('.timepicker').timepicker({
      showInputs: false
    })
   
*/
    </script>

@endsection
