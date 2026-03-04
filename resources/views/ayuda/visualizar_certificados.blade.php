@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Visualizacion de certificados</h1>
        <p>
            Esta vista muestra los certificados generados para una OT. Es el punto de control final del circuito documental
            que viene despues de informes y partes diarios.
        </p>
    </div>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como leer el listado</h2>
            <ul>
                <li><strong>Numero:</strong> identificador del certificado.</li>
                <li><strong>Fecha:</strong> fecha de emision o registracion.</li>
                <li><strong>Firma:</strong> estado documental visible en la grilla del modulo.</li>
            </ul>
            <p>
                La vista se usa para localizar rapidamente un certificado de una OT, abrir su PDF y revisar si ya quedo emitido.
            </p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Importante</h2>
            <p>
                Mientras el informe documenta el trabajo tecnico y el parte consolida la jornada, el certificado resume
                y formaliza la salida final sobre partes ya asociados.
            </p>
            <ul>
                <li>Permite verificar que un conjunto de partes ya fue certificado.</li>
                <li>Facilita la consulta posterior del PDF final.</li>
                <li>Ordena la relacion entre OT, partes y documento emitido.</li>
            </ul>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-crear-certificados') }}">Creacion de certificados</a></li>
                <li><a href="{{ route('ayuda-visualizar-parte-diario') }}">Visualizacion de partes diarios</a></li>
                <li><a href="{{ route('ayuda-visualizar-ot') }}">Visualizacion general de la OT</a></li>
            </ul>
        </div>
    </section>
</div>

@endsection
