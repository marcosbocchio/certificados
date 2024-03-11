@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="row">
        <div class="col-sm-12">
            <h2>Ver Certificado</h2>
            <p>Para visualizar un certificado, seguimos los siguientes pasos:</p>
            <ol>
                <li>Nos dirigimos al menú lateral izquierdo y seleccionamos <strong>Reporte > Certificados</strong>.</li>
                <li>En los filtros disponibles, seleccionamos el cliente deseado y su correspondiente Orden de Trabajo (OT).</li>
                <li>Se mostrará una tabla con la información filtrada. Dentro de la columna "Certificado", encontraremos un número similar a <em>'0000082'</em>. Al hacer clic en este número, seremos redirigidos a un PDF del certificado.</li>
            </ol>
            <p>El siguiente video ilustra el proceso de visualización de un certificado:</p>

            <div class="col-md-6 col-md-offset-3">
                <img  class="img-responsive" src="{{ asset('img/ayuda/visualizar_certificado.gif') }}"  alt="img-clave"/>
            </div>

        </div>

        <!-- Sección para incluir íconos o pasos adicionales, si es necesario -->

        <div class="col-sm-12">
            <h3>Artículos relacionados</h3>
            <ul>
                <li><a href="#">-</a></li>
                <li><a href="#">-</a></li>
                <!-- Incluir otros artículos relacionados según sea necesario -->
            </ul>
        </div>
    </div>
</div>

@endsection