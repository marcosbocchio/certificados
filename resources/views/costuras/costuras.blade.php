@extends('layouts.enod.master')

@section('contenido')

    <div id="app">
  <enod-help-button url="{{ route('ayuda-reportes-costuras') }}"></enod-help-button>

    <costuras
        :user= "{{ $user }}"
        :ot_prop= "{{ $ot_prop === null ? 'null' : $ot_prop }}"
        ayuda-url="{{ route('ayuda-reportes-costuras') }}"
    ></costuras>

    </div>

@endsection


