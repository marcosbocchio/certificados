@extends('layouts.enod.master')

@section('contenido')

<div id="app">

   <ot-partes
    :ot_id_data = "{{$ot_id}}"    
   ></ot-partes>

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