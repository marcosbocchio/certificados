@extends('layouts.enod.master')

@section('css')
<link rel="stylesheet" href="{{ asset('adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/timepicker/bootstrap-timepicker.min.css') }}">
@endsection

@section('contenido')
<div id="app">
    <partes-manuales-edit
        :parte_manual_data="{{ $parteManual }}"
        :fecha_data="'{{ $fecha_sin_hora }}'"
        :ot_data="{{ $ot }}"
        :cliente_data="{{ $cliente }}"
        :cliente_nombre_data="'{{ $clienteNombre }}'"
        :proyecto_data="'{{ $proyecto }}'"
        :orden_de_trabajo_data="'{{ $ordenTrabajoNumero }}'"
        :detalles_data="{{ $detalles }}"
        :plantas_data="{{ $plantas}}"
        :operadores_data='@json($operador_opcion)'
    ></partes-manuales-edit>
</div>
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('adminlte/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/lodash.js') }}"></script>
@endsection