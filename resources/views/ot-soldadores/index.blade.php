@extends('layouts.enod.master')

@section('contenido')

<div id="app">

   <ot-soldadores
    :ot_data = "{{$ot}}" 
    :soldadores_data = "{{$ot_soldadores}}"
    :usuarios_cliente_data = "{{$ot_usuarios_cliente}}"
   
   ></ot-soldadores>

</div>
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