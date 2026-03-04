@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Remitos</h1>
        <p>
            El remito registra movimientos entre frentes y deja trazabilidad de productos, equipos internos y observaciones
            asociadas a una entrega o traslado. Puede trabajar como borrador o como remito definitivo.
        </p>
    </div>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Que se carga en la pantalla</h2>
            <ul>
                <li><strong>Cabecera:</strong> prefijo, numero, fecha, frente origen, frente destino, receptor y destino.</li>
                <li><strong>Productos:</strong> detalle por producto, medida y cantidad.</li>
                <li><strong>Internos de equipos:</strong> equipos que se trasladan con el remito.</li>
                <li><strong>Observaciones:</strong> notas generales o detalles adicionales.</li>
                <li><strong>Estado borrador:</strong> permite guardar sin cerrar el movimiento.</li>
            </ul>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Antes de guardar</h2>
            <ul>
                <li><strong>Borrador:</strong> guarda el remito sin ejecutar los efectos finales del movimiento.</li>
                <li><strong>Definitivo:</strong> si el frente origen es centro de distribucion, descuenta stock de productos y registra el movimiento.</li>
            </ul>
            <p>
                Cuando el remito incluye internos de equipos y se guarda como definitivo, el sistema actualiza el frente destino
                del equipo y guarda su trazabilidad.
            </p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Importante</h2>
            <ul>
                <li><strong>Stock:</strong> puede generar egresos y movimientos historicos.</li>
                <li><strong>Internos de equipos:</strong> actualiza ubicacion y trazabilidad.</li>
                <li><strong>EPP:</strong> desde el circuito operativo del proyecto, remitos puede servir como base para asignaciones.</li>
            </ul>
            <p>
                Por eso remitos no es solo una impresion administrativa: impacta sobre inventario y ubicacion de recursos.
            </p>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-stock') }}">Gestion de stock</a></li>
                <li><a href="{{ route('ayuda-epp') }}">Asignacion de EPP</a></li>
                <li><a href="{{ route('ayuda-visualizar-ot') }}">Visualizacion general de la OT</a></li>
            </ul>
        </div>
    </section>
</div>

@endsection
