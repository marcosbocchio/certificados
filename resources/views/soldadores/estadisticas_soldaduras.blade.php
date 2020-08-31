@extends('layouts.enod.master')

@section('contenido')

    <div id="app">

    <estadisticas-soldaduras
            :user= "{{ $user }}"
    ></estadisticas-soldaduras>

    </div>

@endsection

@section('script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/jspdf-autotable@3.5.9/dist/jspdf.plugin.autotable.js"></script>

@endsection
