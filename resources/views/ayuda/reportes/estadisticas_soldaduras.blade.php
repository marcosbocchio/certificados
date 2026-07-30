@extends('layouts.enod.master')

@section('contenido')

<div id="app">
<div class="ayuda_enod">
    <div class="ayuda_hero">
        <h1>Estadisticas de soldaduras</h1>
        @if($user->hasRole('Cliente'))
        <p>
            Desde este reporte puede consultar las estadisticas de soldadura de sus ordenes de trabajo:
            cuantas soldaduras se ensayaron, cuantas se rechazaron, que defectos aparecen con mas frecuencia
            y donde se ubican las indicaciones, a partir de los informes de Radiografia (RI y RD) de su obra.
        </p>
        <p>
            Su empresa ya viene seleccionada automaticamente. Solo tiene que elegir la OT que quiere consultar
            y, si lo necesita, filtrar por obra, componente o fechas.
        </p>
        @else
        <p>
            Este reporte resume el trabajo de soldadura registrado en los informes de Radiografia (RI y RD). Permite ver
            cuantas soldaduras se rechazaron, que tipos de defecto aparecen mas seguido, que soldadores tienen mas
            observaciones y donde se ubican las indicaciones.
        </p>
        <p>
            Es la herramienta principal para control de calidad y seguimiento del rendimiento por soldador.
        </p>
        @endif
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
        .ayuda_origen {
            background: #f7f9fb;
            border-left: 4px solid #d99000;
            border-radius: 6px;
            padding: 14px 18px;
            margin: 18px 0;
        }
        .ayuda_clave {
            background: #fff8ea;
            border: 1px solid #f0d9a8;
            border-radius: 8px;
            padding: 16px 18px;
            margin: 18px 0;
        }
        .ayuda_ejemplo_wrap { margin: 18px 0; }
        .ayuda_ejemplo_cap {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
            color: #6b7a86;
            margin-bottom: 6px;
        }
        table.ayuda_tabla_ejemplo {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            background: #fff;
        }
        table.ayuda_tabla_ejemplo th,
        table.ayuda_tabla_ejemplo td {
            padding: 8px 12px;
            border: 1px solid #e2e8ed;
            text-align: right;
        }
        table.ayuda_tabla_ejemplo th:first-child,
        table.ayuda_tabla_ejemplo td:first-child { text-align: left; }
        table.ayuda_tabla_ejemplo thead th { background: #f0f3f6; }
        table.ayuda_tabla_ejemplo tfoot td { font-weight: 700; background: #faf6ee; }
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
    {{-- DE DONDE SALEN LOS DATOS --}}
    {{-- =========================================================== --}}
    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>De donde salen los datos</h2>
            <p>
                El reporte no inventa informacion: <strong>cuenta lo que los inspectores cargaron en los informes de
                Radiografia (RI y RD)</strong>. Entender como se carga un informe ayuda a entender por que aparece
                (o por que falta) cada dato en cada pestaña.
            </p>

            <h3>1. La soldadura y sus placas</h3>
            <p>
                Cada soldadura (junta) se revisa por partes, llamadas <strong>placas</strong>. Al cargar cada placa, el
                inspector marca si es <strong>Aceptable</strong> o no. Con eso solo ya se puede calcular el porcentaje de
                rechazo (pestaña 1).
            </p>

            <h3>2. Como se registra una falla</h3>
            <p>
                Cuando el inspector encuentra una falla, <strong>no la escribe con sus palabras</strong>: la elige de una
                <strong>lista fija de defectos</strong> (cada uno con su codigo y descripcion, por ejemplo "PO - Porosidad").
                En el mismo recuadro puede ademas indicar:
            </p>
            <ul>
                <li><strong>La posicion (hora):</strong> la ubicacion de la falla como una hora del reloj (por ejemplo, 120-150).</li>
                <li><strong>La pasada:</strong> raiz, relleno o sobremonta (para cañeria tipo ducto).</li>
            </ul>

            <div class="ayuda_clave">
                <p style="margin:0 0 6px;"><strong>El detalle que define todo: ¿le cargo la hora o no?</strong></p>
                <ul style="margin:0;">
                    <li>Si carga la falla <strong>CON su hora</strong> &rarr; la placa queda <strong>rechazada</strong> y esa
                        falla cuenta como <strong>DEFECTO</strong>. Aparece en <em>Defectologia</em> y en
                        <em>Defectologia / Produccion</em> (se le puede atribuir a un soldador).</li>
                    <li>Si carga la falla <strong>SIN hora</strong> &rarr; la placa <strong>no</strong> se rechaza y esa falla
                        cuenta como <strong>INDICACION</strong>. Aparece solo en la pestaña <em>Indicaciones</em>, como
                        registro informativo.</li>
                </ul>
            </div>

            <h3>3. Dos "posiciones" que conviene no confundir</h3>
            <ul>
                <li><strong>Posicion de la placa:</strong> todas las placas tienen una. Es la que usan los graficos de torta
                    para mostrar en que zona de la soldadura se concentran las fallas.</li>
                <li><strong>Posicion (hora) de la falla:</strong> es opcional. Es la que decide si una falla es defecto o
                    indicacion (ver el recuadro de arriba).</li>
            </ul>

            <h3>4. El diametro y el espesor</h3>
            <p>
                No se cargan por soldadura: salen de la <strong>cabecera del informe</strong> (el diametro y el espesor de la
                cañeria). Por eso las tablas de la pestaña 1 pueden agrupar por esos valores.
            </p>

            <h3>5. Los soldadores</h3>
            <p>
                Se cargan aparte, en las <strong>pasadas</strong> de cada soldadura (el lado P y el lado Z). Hacen falta
                <strong>los dos</strong> para que un defecto pueda atribuirse a quien lo hizo en la pestaña de Produccion.
            </p>
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

            <div class="ayuda_origen">
                <p style="margin:0;"><strong>De donde salen estos datos:</strong> una soldadura aparece aca apenas se carga
                con sus placas y se marca cuales son aceptables y cuales no. El <strong>diametro</strong> y el
                <strong>espesor</strong> con que se agrupan las filas salen de la cabecera del informe (no de cada soldadura).
                Basta una placa no aceptable para que toda la soldadura cuente como rechazada.</p>
            </div>

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

            <div class="ayuda_origen">
                <p style="margin:0 0 8px;"><strong>De donde salen estos datos:</strong> un defecto aparece en esta tabla
                cuando el inspector, en una placa, <strong>eligio la falla de la lista y le cargo su posicion (la hora)</strong>.</p>
                <p style="margin:0;"><em>Ejemplo:</em> si carga "PO - Porosidad" con la posicion 120-150, se suma una fila
                "Porosidad" en esta pestaña. Si marco la placa como rechazada pero <strong>no eligio el tipo de falla de la
                lista</strong>, no puede contarse aca (el sistema no sabe que defecto fue). El grafico de torta agrupa por la
                posicion de la placa dentro de la soldadura.</p>
            </div>

            <div class="ayuda_ejemplo_wrap">
                <div class="ayuda_ejemplo_cap">Ejemplo de la tabla que arma esta pestaña</div>
                <table class="ayuda_tabla_ejemplo">
                    <thead>
                        <tr><th>Defecto</th><th>Codigo</th><th>Cantidad</th><th>%</th></tr>
                    </thead>
                    <tbody>
                        <tr><td>Falta de fusion</td><td>FF</td><td>18</td><td>40%</td></tr>
                        <tr><td>Porosidad</td><td>PO</td><td>12</td><td>27%</td></tr>
                        <tr><td>Socavacion</td><td>SC</td><td>9</td><td>20%</td></tr>
                        <tr><td>Inclusion</td><td>IN</td><td>6</td><td>13%</td></tr>
                    </tbody>
                    <tfoot>
                        <tr><td>Total</td><td></td><td>45</td><td>100%</td></tr>
                    </tfoot>
                </table>
                <p style="font-size:12px;color:#6b7a86;margin:6px 0 0;">Valores de ejemplo, no datos reales.</p>
            </div>

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

            <div class="ayuda_origen">
                <p style="margin:0;"><strong>De donde salen estos datos:</strong> esta pestaña toma los mismos defectos de la
                pestaña 2 (los que se cargaron <strong>con su hora</strong>) y los cruza con los <strong>soldadores cargados en
                las pasadas</strong> (lado P y lado Z). Si falta cargar uno de los dos soldadores, los defectos de ese lado no
                se pueden atribuir y no aparecen aca. El detalle esta mas abajo, en "Como se calcula la atribucion del defecto".</p>
            </div>

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
                Las <strong>indicaciones</strong> son fallas que el inspector cargo <strong>sin la hora exacta</strong>. Al no
                tener hora, la placa no se rechaza y la observacion queda como <strong>registro informativo</strong>: no
                contabiliza como defecto ni en el rendimiento del soldador. Se cargan por el mismo recuadro que los defectos;
                la unica diferencia es que se dejo vacio el campo de la hora.
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

            <div class="ayuda_origen">
                <p style="margin:0 0 8px;"><strong>De donde salen estos datos:</strong> una indicacion aparece cuando el
                inspector <strong>eligio la falla de la lista pero dejo vacia la posicion (la hora)</strong>.</p>
                <p style="margin:0;"><em>Ejemplo:</em> elige "MO - Mordedura" y no le pone hora &rarr; aparece en esta pestaña,
                no en Defectologia. <strong>Aclaracion:</strong> aunque la falla no tenga hora, la placa a la que pertenece si
                tiene su posicion dentro de la soldadura, y por eso el grafico igual puede agruparlas por posicion.</p>
            </div>

            <div class="ayuda_ejemplo_wrap">
                <div class="ayuda_ejemplo_cap">Ejemplo de la tabla que arma esta pestaña</div>
                <table class="ayuda_tabla_ejemplo">
                    <thead>
                        <tr><th>Indicacion</th><th>Codigo</th><th>Cantidad</th></tr>
                    </thead>
                    <tbody>
                        <tr><td>Mordedura leve</td><td>MO</td><td>8</td></tr>
                        <tr><td>Refuerzo excesivo</td><td>RE</td><td>5</td></tr>
                        <tr><td>Salpicadura</td><td>SP</td><td>4</td></tr>
                    </tbody>
                </table>
                <p style="font-size:12px;color:#6b7a86;margin:6px 0 0;">Valores de ejemplo, no datos reales.</p>
            </div>

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
                Un <strong>defecto</strong> es una falla que se cargo <strong>con su hora</strong> (posicion exacta): rechaza
                la placa y cuenta para el rendimiento del soldador. Una <strong>indicacion</strong> es una falla que se cargo
                <strong>sin la hora</strong>: queda como informacion, no rechaza la placa y no se usa para evaluar al soldador.
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
