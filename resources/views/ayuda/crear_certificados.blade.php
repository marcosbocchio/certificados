@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Creacion de certificados</h1>
        <p>
            El certificado es un documento final armado a partir de partes diarios ya registrados para una OT.
            No nace de cero: consolida informacion operativa previa y la transforma en una salida formal lista para PDF.
        </p>
    </div>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Antes de crear un certificado</h2>
            <ul>
                <li>Una OT existente.</li>
                <li>Partes diarios ya cargados y disponibles para seleccion.</li>
                <li>Datos generales del certificado: fecha, numero, titulo e informacion adicional si aplica.</li>
            </ul>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Que se carga en la pantalla</h2>
            <ul>
                <li><strong>Servicios:</strong> cantidades originales y finales, con combinaciones si corresponden.</li>
                <li><strong>Productos por placa o costura:</strong> segun la forma en que se informo el trabajo previo.</li>
                <li><strong>Partes asociados:</strong> el sistema deja vinculacion entre el certificado y los partes que lo componen.</li>
            </ul>
            <p>
                Esto permite que el certificado no sea solo una hoja independiente, sino una salida trazable respecto del trabajo ya registrado.
            </p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Importante</h2>
            <p>
                Una vez guardado, el certificado queda disponible en el listado de la OT y se puede emitir en PDF.
                Si luego hace falta corregirlo, existe tambien circuito de edicion sobre el mismo modulo.
            </p>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-visualizar-certificados') }}">Visualizacion de certificados</a></li>
                <li><a href="{{ route('ayuda-crear-parte-diario') }}">Creacion de partes diarios</a></li>
                <li><a href="{{ route('ayuda-visualizar-parte-diario') }}">Visualizacion de partes diarios</a></li>
            </ul>
        </div>
    </section>
</div>

@endsection
