@extends('layouts.enod.master')

@section('contenido')

<div id="app">
<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Remitos</h1>
        <p>
            El remito registra movimientos entre frentes y deja trazabilidad de productos, equipos internos y observaciones
            asociadas a una entrega o traslado. Puede trabajar como borrador o como remito definitivo.
        </p>
    </div>

    @include('ayuda.partials.functional_summary')

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
            <ayuda-demo-form-remito></ayuda-demo-form-remito>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Antes de empezar</h2>
            <ul>
                <li>Conviene revisar que el frente origen y destino sean los correctos porque eso define el efecto posterior del remito.</li>
                <li>Si hay productos involucrados, es importante que ya esten correctamente dados de alta y disponibles dentro del circuito.</li>
                <li>Si hay internos de equipos, conviene confirmar que el movimiento que se quiere reflejar sea el definitivo y no una referencia provisional.</li>
            </ul>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Flujo recomendado</h2>
            <ol>
                <li>Definir origen, destino y receptor del remito.</li>
                <li>Cargar productos, internos y observaciones necesarias.</li>
                <li>Revisar si el movimiento debe quedar todavia como borrador o si ya corresponde guardarlo como definitivo.</li>
                <li>Guardar y luego validar el impacto en stock o trazabilidad segun el contenido del remito.</li>
            </ol>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como decidir entre borrador y definitivo</h2>
            <ul>
                <li><strong>Borrador:</strong> conviene cuando el movimiento todavia no esta cerrado o falta confirmar parte del contenido.</li>
                <li><strong>Definitivo:</strong> conviene cuando el traslado ya debe impactar operativamente y dejar trazabilidad estable.</li>
                <li>Si hay dudas sobre cantidades, destino o internos involucrados, es preferible revisar antes de cerrar el remito como definitivo.</li>
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
            <h2>Que revisar despues de guardar</h2>
            <ul>
                <li>Si el remito fue definitivo, confirmar que el stock o el movimiento esperado se refleje correctamente.</li>
                <li>Si incluye internos de equipos, revisar que el frente destino haya quedado actualizado como se esperaba.</li>
                <li>Si el remito sirve de base para otros circuitos, validar que la referencia quede disponible para consultas posteriores.</li>
            </ul>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Resultado esperado</h2>
            <ul>
                <li><strong>Stock:</strong> puede generar egresos y movimientos historicos.</li>
                <li><strong>Internos de equipos:</strong> actualiza ubicacion y trazabilidad.</li>
                <li><strong>EPP:</strong> desde el circuito operativo del proyecto, remitos puede servir como base para asignaciones.</li>
            </ul>
            <p>
                Por eso remitos no es solo una impresion administrativa: impacta sobre inventario y ubicacion de recursos.
            </p>
            <ayuda-demo-tabla-remitos></ayuda-demo-tabla-remitos>
            <p>
                El remito debe dejar una referencia clara del movimiento y permitir despues revisar su efecto desde stock, equipos o circuitos relacionados.
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
</div>

@endsection
