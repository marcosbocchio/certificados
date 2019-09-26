@extends('layouts.enod.master')

@section('contenido')

<div id="app">

   <abm-maestro modelo= "productos" ></abm-maestro>

</div>
@endsection

@section('css')
    <!-- icheck -->
    <link  rel="stylesheet" href="{{asset('adminlte/plugins/iCheck/icheck.js')}}">
@endsection


@section('script')

<script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
        'user' => Auth::user()
    ]) !!};
</script>



    <script type="text/javascript" src="{{asset('js/app.js')}}"></script>

@endsection