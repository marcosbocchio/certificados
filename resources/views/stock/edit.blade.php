@extends('layouts.enod.master')

@section('contenido')
<div id="app">
   <enod-back-button fallback-url="/area/enod/stock-total"></enod-back-button>
   <stock-edit
   :producto="{{ $producto }}"
   ></stock-edit>
</div>
@endsection
