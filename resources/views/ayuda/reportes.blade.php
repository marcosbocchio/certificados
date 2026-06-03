@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="ayuda_hero">
        <h1>Reportes</h1>
        <p>
            Esta seccion agrupa los reportes y consultas consolidadas del sistema. Sirven para mirar la informacion ya cargada
            desde otro angulo: agrupada, totalizada, comparada o lista para exportar a Excel o PDF.
        </p>
        <p>
            No reemplazan las pantallas operativas. Las pantallas operativas son para cargar y editar datos. Los reportes son
            para leer, analizar y compartir lo que ya esta cargado.
        </p>
    </div>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Reportes disponibles</h2>
            <p>Elegi el reporte que necesitas segun la informacion que estes buscando.</p>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-reportes-estadisticas-soldaduras') }}">Estadisticas de soldaduras</a></li>
            </ul>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Que tienen en comun todos los reportes</h2>
            <ul>
                <li>Trabajan sobre informacion que ya esta cargada en informes, OT y demas modulos.</li>
                <li>Tienen filtros para acotar los resultados (cliente, OT, fechas, etc.).</li>
                <li>Permiten exportar la informacion a Excel y a PDF cuando aplica.</li>
                <li>Muestran graficos y totales para facilitar la lectura rapida.</li>
            </ul>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Articulos relacionados</h2>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-visualizar-informes') }}">Visualizacion de informes</a></li>
                <li><a href="{{ route('ayuda-visualizar-parte-diario') }}">Visualizacion de partes diarios</a></li>
                <li><a href="{{ route('ayuda-visualizar-certificados') }}">Visualizacion de certificados</a></li>
            </ul>
        </div>
    </section>
</div>

@endsection
