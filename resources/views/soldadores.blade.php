@extends('layouts.enod.master')

@section('contenido')

<div id="app">

   <soldadores></soldadores>

</div>
@endsection


@section('script')

<script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
        'user' => Auth::user()
    ]) !!};
</script>

@endsection