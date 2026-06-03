@extends('layouts.enod.master')

@section('contenido')

<div id="app">
<div class="ayuda_enod">
    <div class="ayuda_hero">
        <h1>Estadisticas de soldaduras</h1>
        <p>
            Este reporte resume el trabajo de soldadura registrado en los informes de Radiografia (RI y RD). Permite ver
            cuantas soldaduras se rechazaron, que tipos de defecto aparecen mas seguido, que soldadores tienen mas
            observaciones y donde se ubican las indicaciones.
        </p>
        <p>
            Es la herramienta principal para control de calidad y seguimiento del rendimiento por soldador.
        </p>
        @can('R_estadisticas_soldaduras')
            <p style="margin-top: 14px;">
                <a href="{{ route('estadisticas-soldaduras') }}" class="ayuda_ir_reporte_btn">
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

    {{-- Vista previa interactiva del reporte completo --}}
    <section class="ayuda_section">
        <ayuda-demo-pestanas></ayuda-demo-pestanas>
    </section>

    {{-- =========================================================== --}}
    {{-- ¿PARA QUE SIRVE? --}}
    {{-- =========================================================== --}}
    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>¿Para que sirve?</h2>
            <ul>
                <li>Saber que porcentaje de soldaduras fue rechazado en un periodo, obra o cliente.</li>
                <li>Identificar que tipo de defecto aparece con mas frecuencia.</li>
                <li>Conocer el rendimiento individual de cada soldador (cuantos defectos tiene segun los cordones que hizo).</li>
                <li>Detectar zonas (posiciones) de la soldadura donde se concentran las fallas.</li>
                <li>Exportar la informacion a Excel o PDF para reportes internos o entrega al cliente.</li>
            </ul>
        </div>
    </section>

    {{-- =========================================================== --}}
    {{-- COMO ENTRAR --}}
    {{-- =========================================================== --}}
    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como entrar</h2>
            <p>Desde el menu lateral, ingresa a <strong>Reportes</strong> y luego a <strong>Estadisticas de soldaduras</strong>.</p>
            <p>
                Si no aparece esta opcion en tu menu, tu usuario no tiene el permiso necesario. Consulta con un administrador
                para que te habilite el permiso <em>R_estadisticas_soldaduras</em>.
            </p>
            {{-- IMAGEN A AGREGAR:
                Captura del menu lateral con la opcion "Reportes > Estadisticas de soldaduras" destacada.
                Sugerido nombre: img/ayuda/Estadisticas_menu.PNG
            --}}
            {{-- <img class="img-responsive" src="{{ asset('img/ayuda/Estadisticas_menu.PNG') }}" alt="Menu Reportes - Estadisticas de soldaduras" /> --}}
        </div>
    </section>

    {{-- =========================================================== --}}
    {{-- COMO USARLO (paso a paso) --}}
    {{-- =========================================================== --}}
    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como usarlo paso a paso</h2>

            <h3>1. Aplicar filtros</h3>
            <p>En la parte de arriba de la pantalla hay un panel de filtros. Completa los que necesites:</p>
            <ul>
                <li><strong>Cliente:</strong> para ver solo informes de un cliente.</li>
                <li><strong>OT:</strong> para enfocar el analisis en una orden de trabajo especifica.</li>
                <li><strong>Obra y Componente:</strong> para acotar mas el resultado.</li>
                <li><strong>PK:</strong> si el caso tiene progresiva kilometrica.</li>
                <li><strong>Fechas Desde / Hasta:</strong> para definir el rango temporal del analisis.</li>
            </ul>
            <p>No es obligatorio completar todos los filtros. Cuantos menos filtros pongas, mas amplio sera el resultado.</p>

            <ayuda-demo-filtros></ayuda-demo-filtros>

            <h3>2. Presionar Buscar</h3>
            <p>
                Cuando termines de poner los filtros, presiona el boton <strong>Buscar</strong>. El sistema cargara los
                informes que cumplen con esos criterios y completara las cuatro pestañas del reporte.
            </p>

            <h3>3. Revisar las pestañas</h3>
            <p>
                El reporte tiene cuatro pestañas. Cada una muestra una vista distinta de los mismos informes. Podes moverte
                entre ellas haciendo clic sobre los titulos.
            </p>

            <h3>4. Exportar lo que necesites</h3>
            <p>
                Cada pestaña tiene su propio boton de <strong>Exportar a Excel</strong> y de <strong>Exportar PDF</strong>.
                Estos botones generan archivos descargables con la informacion que estas viendo.
            </p>
            {{-- IMAGEN A AGREGAR:
                Captura mostrando los botones Excel (icono verde) y PDF en la cabecera de una pestaña.
                Sugerido nombre: img/ayuda/Estadisticas_exportar.PNG
            --}}
            {{-- <img class="img-responsive" src="{{ asset('img/ayuda/Estadisticas_exportar.PNG') }}" alt="Botones de exportacion" /> --}}
        </div>
    </section>

    {{-- =========================================================== --}}
    {{-- PESTAÑA 1: INDICES DE RECHAZOS --}}
    {{-- =========================================================== --}}
    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Pestaña 1 — Indices de rechazos</h2>
            <p>
                Es la pestaña mas general. Responde a la pregunta: <em>¿cuantas soldaduras fueron rechazadas en este conjunto
                de informes?</em>
            </p>

            <h3>Que muestra</h3>
            <ul>
                <li>Una <strong>tabla agrupada por diametro</strong> de la cañeria: aprobadas, rechazadas, total y porcentaje.</li>
                <li>Una <strong>tabla agrupada por espesor</strong> del material: mismas columnas.</li>
                <li>Un <strong>grafico de torta</strong> mostrando el porcentaje global de aprobados vs rechazados.</li>
                <li>Totales generales en la parte inferior.</li>
            </ul>

            <h3>Como leerla</h3>
            <p>
                Cada fila representa un diametro o espesor distinto. Si una soldadura tiene <strong>al menos una placa
                rechazada</strong>, la soldadura entera se cuenta como rechazada en este reporte.
            </p>

            <h3>Cuando conviene mirarla</h3>
            <ul>
                <li>Cuando se necesita un numero global del porcentaje de rechazo del periodo.</li>
                <li>Cuando se quiere comparar el rendimiento por tipo de cañeria (diametro / espesor).</li>
                <li>Para armar reportes mensuales o de cierre de obra.</li>
            </ul>

            <ayuda-demo-tabla-rechazos></ayuda-demo-tabla-rechazos>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <ayuda-demo-grafico-pie></ayuda-demo-grafico-pie>
                </div>
            </div>
        </div>
    </section>

    {{-- =========================================================== --}}
    {{-- PESTAÑA 2: DEFECTOLOGIA --}}
    {{-- =========================================================== --}}
    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Pestaña 2 — Defectologia</h2>
            <p>
                Responde a la pregunta: <em>¿que tipos de defecto aparecen con mas frecuencia y donde estan ubicados?</em>
            </p>

            <h3>Que muestra</h3>
            <ul>
                <li>Una <strong>tabla con todos los defectos detectados</strong>, con su codigo, descripcion, cantidad y porcentaje sobre el total.</li>
                <li>Un <strong>grafico de torta</strong> con la distribucion de defectos por posicion horaria.</li>
                <li>Un <strong>selector de diametro</strong> arriba del grafico para filtrar por tamaño de cañeria.</li>
            </ul>

            <h3>Como leerla</h3>
            <p>
                La tabla esta ordenada de mayor a menor cantidad: el defecto mas frecuente aparece primero. El grafico de
                torta muestra en que posicion del reloj se ubican los defectos (ej: a las 12, a las 3, etc.) — util para
                detectar si las fallas se concentran siempre en la misma zona de la soldadura.
            </p>

            <h3>Cuando conviene mirarla</h3>
            <ul>
                <li>Para identificar el tipo de defecto mas comun y planificar acciones correctivas (capacitacion, cambio de equipo, etc.).</li>
                <li>Para detectar si hay un patron geometrico en la aparicion de defectos.</li>
                <li>Cuando se necesita un detalle tecnico de la causa de rechazo, mas alla del numero global.</li>
            </ul>

            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <ayuda-demo-grafico-doughnut></ayuda-demo-grafico-doughnut>
                </div>
            </div>
        </div>
    </section>

    {{-- =========================================================== --}}
    {{-- PESTAÑA 3: DEFECTOLOGIA/PRODUCCION --}}
    {{-- =========================================================== --}}
    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Pestaña 3 — Defectologia / Produccion</h2>
            <p>
                Responde a la pregunta: <em>¿que soldador tiene mas defectos y en que proporcion comparado con lo que produjo?</em>
            </p>
            <p>
                Esta es la pestaña mas usada para evaluacion individual del personal. Cruza la cantidad de defectos con
                la cantidad de cordones que hizo cada soldador.
            </p>

            <h3>Que muestra</h3>
            <ul>
                <li>
                    <strong>Tabla principal:</strong> una fila por soldador, con las columnas:
                    <ul>
                        <li><strong>Cuño:</strong> codigo y nombre del soldador.</li>
                        <li><strong>Cord.:</strong> cantidad de cordones que realizo en los informes filtrados.</li>
                        <li><strong>Cant.:</strong> cantidad de defectos que se le atribuyen.</li>
                        <li><strong>Porcentaje:</strong> defectos sobre cordones (cuanto mas bajo, mejor).</li>
                        <li><strong>Placas Total:</strong> total de placas radiograficas en las que intervino.</li>
                        <li><strong>Placas Rech.:</strong> cuantas de esas placas terminaron rechazadas.</li>
                    </ul>
                </li>
                <li>
                    <strong>Grafico de barras:</strong> al hacer clic sobre una fila, debajo aparece un grafico con los
                    tipos de defecto que tuvo ese soldador.
                </li>
            </ul>

            <h3>Como se calcula la atribucion del defecto</h3>
            <p>
                El sistema reparte cada defecto entre los soldadores segun la posicion en la que esta ubicado:
            </p>
            <ul>
                <li>
                    El sistema toma como referencia los <strong>dos lados</strong> de la soldadura (el lado del soldador P
                    y el lado del soldador Z) y mira la <strong>posicion exacta del defecto</strong> para asignarlo al
                    soldador del lado que corresponde.
                </li>
                <li>
                    Si el defecto esta <strong>justo en el medio</strong> entre los dos lados, se reparte mitad y mitad
                    (cada soldador recibe 0.5).
                </li>
                <li>
                    En caso de <strong>ductos con varias capas</strong> (raiz, relleno, sobremonta), tambien se considera
                    en que pasada ocurrio el defecto para identificar al soldador responsable.
                </li>
            </ul>
            <p>
                <strong>Importante:</strong> para que la asignacion funcione correctamente, en la carga de pasadas se deben
                cargar <strong>los dos soldadores</strong> (P y Z). Si solo se carga uno, los defectos del lado que no tiene
                soldador asignado no se contabilizan en este reporte.
            </p>

            <h3>Como leerla</h3>
            <p>
                La tabla esta ordenada de mayor a menor cantidad de defectos. <strong>Hace clic sobre la fila de un
                soldador</strong> para ver el detalle de sus defectos en el grafico de barras de abajo. La fila seleccionada
                queda destacada.
            </p>

            <h3>Cuando conviene mirarla</h3>
            <ul>
                <li>Para evaluar el rendimiento individual de cada soldador.</li>
                <li>Para identificar soldadores que necesitan capacitacion o seguimiento.</li>
                <li>Como insumo para reuniones de calidad o evaluacion de desempeño.</li>
                <li>Para comparar el porcentaje de defectos entre soldadores que trabajaron en condiciones similares.</li>
            </ul>

            <p><strong>Nota importante:</strong> el porcentaje (Cant. / Cord.) no es un numero absoluto: depende de la cantidad
            de cordones que hizo cada soldador. Un soldador con 1 defecto en 10 cordones tiene 10% — el mismo defecto en
            100 cordones es solo 1%. Conviene mirar el porcentaje junto con la cantidad de cordones.</p>

            <ayuda-demo-tabla-soldadores></ayuda-demo-tabla-soldadores>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <ayuda-demo-grafico-barras></ayuda-demo-grafico-barras>
                </div>
            </div>
        </div>
    </section>

    {{-- =========================================================== --}}
    {{-- PESTAÑA 4: INDICACIONES --}}
    {{-- =========================================================== --}}
    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Pestaña 4 — Indicaciones</h2>
            <p>
                Responde a la pregunta: <em>¿que indicaciones (no defectos formales) se registraron y donde se ubican?</em>
            </p>
            <p>
                Las <strong>indicaciones</strong> son observaciones detectadas en el ensayo que <strong>no se cargan como
                defectos formales</strong> porque no tienen posicion o pasada exacta. Sirven como registro informativo y no
                contabilizan en el reporte de produccion del soldador.
            </p>

            <h3>Que muestra</h3>
            <ul>
                <li>Tabla con el listado de indicaciones agrupadas por codigo.</li>
                <li>Grafico de torta con la distribucion de indicaciones por posicion (filtrable por diametro).</li>
                <li><strong>Drilldown interactivo:</strong> al hacer clic sobre una porcion del grafico, abajo aparece un detalle de las indicaciones de esa posicion.</li>
            </ul>

            <h3>Como leerla</h3>
            <p>
                Esta pestaña funciona de forma similar a "Defectologia", pero se enfoca en lo que <strong>no</strong> es
                defecto formal. Es util para tener registro de todo lo observado durante los ensayos, no solo lo que tiene
                ubicacion exacta.
            </p>

            <h3>Cuando conviene mirarla</h3>
            <ul>
                <li>Para tener un panorama completo de lo registrado durante los ensayos.</li>
                <li>Cuando se necesita auditar las observaciones que no terminaron como rechazo formal.</li>
                <li>Como insumo para revisiones tecnicas mas detalladas.</li>
            </ul>

            {{-- Para esta pestaña se reutiliza el componente demo doughnut con datos de indicaciones --}}
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <ayuda-demo-grafico-doughnut></ayuda-demo-grafico-doughnut>
                </div>
            </div>
        </div>
    </section>

    {{-- =========================================================== --}}
    {{-- EXPORTACION --}}
    {{-- =========================================================== --}}
    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como exportar la informacion</h2>
            <h3>A Excel</h3>
            <p>
                Cada tabla del reporte tiene un boton con icono de Excel en la esquina superior derecha del recuadro.
                Al hacer clic se descarga un archivo <code>.xls</code> con los datos de esa tabla.
            </p>

            <h3>A PDF</h3>
            <p>
                Cada pestaña tiene su boton <strong>Exportar PDF</strong> en la parte superior. El PDF incluye la tabla
                con los datos y los graficos correspondientes.
            </p>

            <h3>Que hacer despues</h3>
            <ul>
                <li>El Excel se puede editar libremente, ordenar, filtrar y agregar columnas propias.</li>
                <li>El PDF es ideal para imprimir, enviar al cliente o adjuntar a documentacion formal.</li>
            </ul>
        </div>
    </section>

    {{-- =========================================================== --}}
    {{-- PREGUNTAS FRECUENTES --}}
    {{-- =========================================================== --}}
    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Preguntas frecuentes</h2>

            <h3>El reporte no muestra datos</h3>
            <ul>
                <li>Verifica que los filtros no esten demasiado acotados (por ejemplo, fechas que no incluyen informes cargados).</li>
                <li>Confirma que los informes del periodo esten cargados en el sistema.</li>
                <li>Si una pestaña en particular sale vacia, puede ser un tema de permisos. Consulta con un administrador.</li>
            </ul>

            <h3>Un soldador aparece con porcentaje muy alto</h3>
            <p>
                Mira primero cuantos cordones tiene (columna <strong>Cord.</strong>). Si el numero es muy bajo (por ejemplo,
                2 o 3 cordones), basta con un defecto para que el porcentaje sea alto. Conviene esperar a que tenga mas
                produccion antes de sacar conclusiones.
            </p>

            <h3>Un soldador no aparece en la pestaña Produccion</h3>
            <p>Puede deberse a alguna de estas razones:</p>
            <ul>
                <li>El soldador no tuvo defectos en el periodo (entonces no figura en la tabla).</li>
                <li>El soldador solo esta asignado como <strong>lateral (L)</strong> en pasadas — actualmente los cordones del rol lateral no se contabilizan en esta version del reporte.</li>
                <li>En la carga de pasadas no se asigno al soldador en ningun rol (P o Z), por lo que el sistema no puede atribuirle defectos.</li>
            </ul>

            <h3>Hay defectos cargados en una soldadura pero ningun soldador los muestra</h3>
            <p>
                Suele pasar cuando en la carga de pasadas solo se asigno un soldador (por ejemplo, solo el P pero no el Z, o viceversa).
                Los defectos que estan del lado del soldador que <strong>no fue cargado</strong> se quedan sin asignar y no aparecen en
                el reporte. Revisar la carga de pasadas del informe y completar los dos roles (P y Z).
            </p>

            <h3>¿Por que el porcentaje da diferente entre pestañas?</h3>
            <p>
                Cada pestaña usa una base de calculo distinta: la pestaña 1 cuenta soldaduras enteras, la pestaña 2 cuenta
                defectos individuales, y la pestaña 3 cruza defectos con cordones. Los porcentajes <strong>no son comparables
                entre pestañas</strong>.
            </p>

            <h3>¿Que diferencia hay entre defectos e indicaciones?</h3>
            <p>
                Un <strong>defecto</strong> es una falla con ubicacion y pasada definidas, que cuenta para el rendimiento del
                soldador. Una <strong>indicacion</strong> es una observacion sin ubicacion exacta, registrada como informacion
                pero no contabilizada para evaluar el trabajo del soldador.
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
                <li><a href="{{ route('ayuda-gestion-soldadores') }}">Gestionar soldadores</a></li>
                <li><a href="{{ route('ayuda-reportes') }}">Volver al indice de reportes</a></li>
            </ul>
        </div>
    </section>
</div>
</div>

@endsection
