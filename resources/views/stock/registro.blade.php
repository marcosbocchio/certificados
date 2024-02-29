@extends('layouts.enod.master')

@section('contenido')
<div id="app">
   <stock-registro
   :id="{{ $id }}">
   </stock-registro>
</div>
@endsection