@extends('layouts.enod.master')

@section('contenido')

<div id="app">
<div class="ayuda_enod">
    <div class="ayuda_hero">
        <h1>Seguimiento de costuras / Plano-isometrico</h1>
        <p>
            Este reporte permite buscar y seguir el estado de las costuras (juntas soldadas) ensayadas por
            Radiografia (RI y RD) dentro de una OT. Para cada costura muestra en que informe fue ensayada,
            su ubicacion (linea, plano isometrico, hoja o PK) y si quedo aprobada o rechazada.
        </p>
        <p>
            Es la herramienta principal para responder rapido: <em>¿esta costura ya fue ensayada? ¿paso o hay que repararla?</em>
        </p>
        @can('R_costuras')
            <p style="margin-top: 14px;">
                <a href="{{ route('reporte-costuras','0') }}" class="ayuda_ir_reporte_btn">
                    <i class="fa fa-external-link"></i> Ir al reporte real
                </a>
            </p>
        @endcan
    </div>

    <style>
        .ayuda_ir_reporte_btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            background: #d99000;
            color: #fff !important;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none !important;
            transition: all 0.15s ease;
        }
        .ayuda_ir_reporte_btn:hover,
        .ayuda_ir_reporte_btn:focus {
            background: #b57400;
            color: #fff !important;
            box-shadow: 0 3px 10px rgba(217, 144, 0, 0.3);
        }
    </style>

    {{-- =========================================================== --}}
    {{-- ¿PARA QUE SIRVE? --}}
    {{-- =========================================================== --}}
    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>¿Para que sirve?</h2>
            <ul>
                <li>Verificar si una costura puntual ya fue ensayada y con que resultado (aprobada o rechazada).</li>
                <li>Listar todas las costuras de un plano isometrico, una linea o una progresiva (PK) de ducto.</li>
                <li>Ver solo las costuras rechazadas, para organizar las reparaciones pendientes.</li>
                <li>Ver solo las reparaciones (costuras cuyo codigo termina en "R") y controlar su resultado.</li>
                <li>Buscar las costuras en las que intervino un soldador determinado.</li>
                <li>Acceder directo al informe donde se registro cada costura, con un clic sobre el numero de informe.</li>
            </ul>
        </div>
    </section>

    {{-- =========================================================== --}}
    {{-- COMO ENTRAR --}}
    {{-- =========================================================== --}}
    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como entrar</h2>
            <p>Desde el menu lateral, ingresa a <strong>Reportes</strong> y luego a <strong>Costuras</strong>.</p>
            <p>
                Si no aparece esta opcion en tu menu, tu usuario no tiene el permiso necesario. Consulta con un administrador
                para que te habilite el permiso <em>R_costuras</em>.
            </p>
        </div>
    </section>

    {{-- =========================================================== --}}
    {{-- COMO USARLO --}}
    {{-- =========================================================== --}}
    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como usarlo paso a paso</h2>

            <h3>1. Elegir Cliente y OT</h3>
            <p>
                Primero selecciona el <strong>Cliente</strong> y despues la <strong>OT</strong>. Estos dos datos son
                obligatorios: el reporte siempre trabaja sobre una OT concreta. El resto de los filtros es opcional.
            </p>

            <h3>2. Acotar la busqueda (opcional)</h3>
            <ul>
                <li><strong>Obra:</strong> limita el resultado a una obra de la OT.</li>
                <li><strong>Componente:</strong> limita a un componente dentro de la obra.</li>
                <li><strong>PK:</strong> para ductos, busca por progresiva kilometrica exacta.</li>
                <li><strong>Plano Isometrico:</strong> busca por coincidencia parcial — alcanza con escribir una parte del nombre del plano.</li>
                <li><strong>Costura:</strong> busca por coincidencia parcial del codigo de la junta.</li>
                <li><strong>Soldador:</strong> muestra solo las costuras donde ese soldador intervino en alguna pasada (como Z, L o P).</li>
            </ul>

            <h3>3. Casillas Rechazados y Reparaciones</h3>
            <ul>
                <li>
                    <strong>Rechazados:</strong> si esta marcada, el reporte muestra <strong>solo</strong> las costuras
                    rechazadas (las que tienen al menos una posicion no aceptable). Si esta desmarcada, muestra todas.
                </li>
                <li>
                    <strong>Reparaciones:</strong> si esta marcada, muestra <strong>solo</strong> las costuras que son
                    reparaciones, es decir las que su codigo termina en la letra <strong>R</strong> (ej: "J15R").
                </li>
                <li>Se pueden combinar: marcando las dos se ven las reparaciones que volvieron a ser rechazadas.</li>
            </ul>

            <h3>4. Presionar Buscar</h3>
            <p>El sistema arma el listado y lo muestra paginado de a 10 filas.</p>
        </div>
    </section>

    {{-- =========================================================== --}}
    {{-- COMO LEER LA TABLA --}}
    {{-- =========================================================== --}}
    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como leer la tabla de resultados</h2>
            <ul>
                <li><strong>Fecha:</strong> fecha del informe donde se ensayo la costura. El listado viene ordenado de la fecha mas reciente a la mas antigua.</li>
                <li>
                    <strong>Informe Nº:</strong> numero del informe. Es un <strong>link</strong>: al hacer clic se abre la
                    pantalla de informes de la OT, ya posicionada en ese informe. En ductos el numero se muestra como
                    <em>PK - tipo de soldadura - numero</em>.
                </li>
                <li><strong>Costura:</strong> codigo de la junta. Si termina en "R" es una reparacion de la costura original.</li>
                <li><strong>Linea:</strong> linea de cañeria a la que pertenece.</li>
                <li>
                    <strong>Plano Isometrico:</strong> plano donde esta dibujada la costura. Si el informe tiene cargado el
                    numero de <strong>hoja</strong> (lamina del plano), se muestra al lado como <em>(Hoja X)</em>.
                </li>
                <li>
                    <strong>Aprob.:</strong> resultado de la costura. <strong>SI</strong> significa que todas las posiciones
                    ensayadas fueron aceptables. <strong>NO</strong> significa que al menos una posicion fue rechazada, y la
                    costura requiere reparacion.
                </li>
            </ul>
            <p>
                <strong>Importante:</strong> la aprobacion se evalua a nivel costura completa. Una sola posicion no aceptable
                alcanza para que toda la costura figure como NO aprobada.
            </p>
        </div>
    </section>

    {{-- =========================================================== --}}
    {{-- DE DONDE SALEN LOS DATOS --}}
    {{-- =========================================================== --}}
    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>De donde salen los datos</h2>
            <ul>
                <li>El reporte toma las costuras cargadas en los informes de <strong>Radiografia Industrial (RI)</strong> y <strong>Radiografia Digital (RD)</strong> de la OT.</li>
                <li>Solo se consideran informes propios (no los importados de otros sistemas).</li>
                <li>Una misma costura puede aparecer varias veces si fue ensayada en mas de un informe (por ejemplo, el ensayo original y luego su reparacion).</li>
            </ul>
        </div>
    </section>

    {{-- =========================================================== --}}
    {{-- PREGUNTAS FRECUENTES --}}
    {{-- =========================================================== --}}
    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Preguntas frecuentes</h2>

            <h3>Una costura que se que esta cargada no aparece</h3>
            <ul>
                <li>Verifica que el informe sea de RI o RD: este reporte no incluye otros metodos de ensayo (PM, LP, US, etc.).</li>
                <li>Verifica que la junta tenga <strong>pasadas cargadas</strong> en el informe. Las costuras sin pasadas no se listan.</li>
                <li>Revisa que los filtros (obra, componente, PK) coincidan exactamente con lo cargado en el informe.</li>
            </ul>

            <h3>Busco por soldador y no aparecen costuras</h3>
            <p>
                El filtro de soldador busca en las pasadas de cada junta (roles Z, L y P). Si en la carga del informe no se
                asigno al soldador en ninguna pasada, la costura no va a aparecer al filtrar por el.
            </p>

            <h3>¿Como sigo una costura rechazada hasta su reparacion?</h3>
            <p>
                Busca el codigo de la costura en el filtro <strong>Costura</strong> (sin la "R"). El resultado va a mostrar
                tanto la costura original como su reparacion (mismo codigo terminado en "R"), cada una con su fecha,
                su informe y su resultado.
            </p>

            <h3>¿Por que algunos planos muestran "(Hoja X)" y otros no?</h3>
            <p>
                La hoja es la lamina del plano isometrico y se carga en el informe (tipico de informes de planta). Los
                informes de ducto no usan hoja: ahi la ubicacion se identifica por PK.
            </p>
        </div>
    </section>

    {{-- =========================================================== --}}
    {{-- ARTICULOS RELACIONADOS --}}
    {{-- =========================================================== --}}
    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Articulos relacionados</h2>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-generar-informes-ri') }}">Como generar informes RI</a></li>
                <li><a href="{{ route('ayuda-visualizar-informes') }}">Visualizar informes</a></li>
                <li><a href="{{ route('ayuda-reportes-estadisticas-soldaduras') }}">Estadisticas de soldaduras</a></li>
                <li><a href="{{ route('ayuda-reportes') }}">Volver al indice de reportes</a></li>
            </ul>
        </div>
    </section>
</div>
</div>

@endsection
