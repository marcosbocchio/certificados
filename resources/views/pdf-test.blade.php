@extends('layouts.enod.master')

@section('css')

<link  rel="stylesheet" href="{{asset('adminlte/plugins/iCheck/icheck.js')}}">


@endsection

@section('contenido')

    <div id="app">

    <pdf-test></pdf-test>

    </div>

@endsection

@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>

@endsection