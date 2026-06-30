@extends('layouts.enod.master')


@section('css')

<link rel="stylesheet"  href="{{asset('adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet"  href="{{asset('adminlte/plugins/timepicker/bootstrap-timepicker.min.css')}}">
   
@endsection


@section('contenido')
 
 <div id="app">
  <div class="ot_topbar">
    <enod-back-button fallback-url="/area/enod"></enod-back-button>
    <a href="{{ route('ayuda-crear-ot') }}" class="ot_ayuda_btn" title="Cómo usar esta pantalla">
      <i class="fa fa-question-circle"></i> Ayuda
    </a>
  </div>


  <ots  acciondata="{{$accion}}" ></ots>

 </div>

<style>
.ot_topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 10px;
}
.ot_ayuda_btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #fff;
    border: 1px solid #FFCC00;
    color: #1a1a1a;
    padding: 7px 14px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    line-height: 1;
    transition: all 0.12s ease;
}
.ot_ayuda_btn:hover,
.ot_ayuda_btn:focus {
    background: #FFCC00;
    color: #1a1a1a;
    text-decoration: none;
}
.ot_ayuda_btn i { font-size: 14px; }
</style>

@endsection


@section('script')

<script type="text/javascript" src="{{asset('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset('adminlte/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/lodash.js')}}"></script>

@endsection

