@extends('layouts.enod.master')

@section('contenido')

    <div id="app">

    <elementos
        :user= "{{ $user }}"
        :ot_prop= "{{ $ot_prop === null ? 'null' : $ot_prop }}"
    ></elementos>

    </div>

@endsection


