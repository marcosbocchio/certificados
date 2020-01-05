@extends('layouts.enod.master')



@section('contenido')


<div id="app">

   <dosimetria-rx
         :operador_data= "{{ $operador }}"
   ></dosimetria-rx>

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