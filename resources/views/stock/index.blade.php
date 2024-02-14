@extends('layouts.app') <!-- Asegúrate de extender el layout correcto -->

@section('content')
<div id="app">
  <stock-table></stock-table> <!-- Asegúrate de que el nombre del componente coincida -->
</div>
@endsection

@section('script')
<script src="{{ mix('js/app.js') }}"></script> <!-- Asegúrate de que app.js tenga el componente registrado -->
@endsection