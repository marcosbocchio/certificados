@extends('layouts.enod.master')

@section('contenido')
<div id="app">
   <stock-edit
   :producto="{{ $producto }}"
   ></stock-edit>
</div>
@endsection