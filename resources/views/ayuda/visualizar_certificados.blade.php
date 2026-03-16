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
            <h2>Cuando conviene revisar esta pantalla</h2>
            <ul>
                <li>Cuando se necesita ubicar la salida final emitida para una OT.</li>
                <li>Cuando se quiere confirmar que un conjunto de partes ya fue certificado.</li>
                <li>Cuando hace falta abrir el PDF correcto antes de compartir o controlar documentacion final.</li>
                <li>Cuando se revisa si un certificado todavia requiere edicion o si ya puede tomarse como referencia final del circuito.</li>
            </ul>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Que conviene revisar</h2>
            <p>
                Mientras el informe documenta el trabajo tecnico y el parte consolida la jornada, el certificado resume
                y formaliza la salida final sobre partes ya asociados.
            </p>
            <ul>
                <li>Que el certificado encontrado corresponda efectivamente al conjunto de partes que se queria cerrar.</li>
                <li>Que el PDF visible sea la salida final correcta para esa OT.</li>
                <li>Que la relacion entre OT, partes y certificado quede clara antes de seguir con controles o entrega documental.</li>
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
