@extends('layouts.enod.master')

@section('contenido')
<div id="app">
   <stock-ajuste
   :producto-p="{{ $stockItem }}"
   :compra-detalle-p="{{ $stockItemCompra }}"
   :proveedores-p="{{ $proveedor }}"
   ></stock-ajuste>
</div>
@endsection