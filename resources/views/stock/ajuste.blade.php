@extends('layouts.enod.master')

@section('contenido')
<div id="app">
   <enod-back-button fallback-url="/area/enod/stock-total"></enod-back-button>
   <stock-ajuste
   :producto-p="{{ $stockItem }}"
   :compra-detalle-p="{{ $stockItemCompra }}"
   :proveedores-p="{{ $proveedor }}"
   ></stock-ajuste>
</div>
@endsection
