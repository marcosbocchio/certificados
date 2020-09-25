@extends('layouts.enod.master')

@section('contenido')

<div id="app">

   <modelo3d-viewer :modelo_3d="{{$modelo_3d}}"></modelo3d-viewer>

</div>

@endsection
