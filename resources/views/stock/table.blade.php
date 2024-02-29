@extends('layouts.enod.master')

@section('contenido')

<div id="app">

   <stock-table 
   :proveedor="{{ $proveedor }}"
   ></stock-table>

</div>
@endsection