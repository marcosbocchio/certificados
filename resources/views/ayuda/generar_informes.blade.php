@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Creacion de informes</h1>
        <p>
            El modulo de informes permite registrar la evidencia tecnica del trabajo realizado en una OT.
            El sistema no ofrece cualquier informe de forma libre: habilita solo los metodos que se desprenden de los servicios cargados en esa OT.
        </p>
        <p>
            Segun el metodo elegido, el formulario puede pedir operadores, soldadores, procedimientos, tecnicas,
            plantas, placas, modelos o informacion adicional. Por eso conviene entrar a esta pantalla cuando la OT ya tiene
            bien definidos sus datos base.
        </p>
    </div>

    @include('ayuda.partials.functional_summary')

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Antes de ingresar a informes</h2>
            <ul>
                <li><strong>Servicios:</strong> definen que metodos de ensayo se habilitan.</li>
                <li><strong>Operadores:</strong> suelen intervenir como ejecutores del ensayo.</li>
                <li><strong>Procedimientos:</strong> segun el metodo, pueden ser obligatorios para informar.</li>
                <li><strong>Soldadores y usuarios cliente:</strong> son especialmente relevantes en RI y en circuitos donde el cliente necesita acceso posterior.</li>
            </ul>
            <p>
                Si un metodo no aparece, lo primero a revisar es que la OT tenga cargado el servicio correspondiente y sus asignaciones basicas.
            </p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Flujo recomendado</h2>
            <ol>
                <li>Entrar a la OT correcta y abrir el bloque de <strong>Informes</strong>.</li>
                <li>Verificar que el metodo de ensayo esperado este habilitado.</li>
                <li>Crear el informe nuevo o clonar uno existente si comparte encabezado.</li>
                <li>Completar el formulario del metodo elegido y guardar.</li>
                <li>Firmar cuando la revision actual quede cerrada y lista para su uso operativo.</li>
            </ol>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como decidir entre nuevo, clonar o editar</h2>
            <ul>
                <li><strong>Nuevo:</strong> conviene cuando el informe no comparte base con otro ya existente.</li>
                <li><strong>Clonar:</strong> acelera la carga si el siguiente informe repite encabezado, contexto o parte de la informacion tecnica.</li>
                <li><strong>Editar:</strong> sirve para corregir una revision. Si el informe ya estaba firmado, el sistema conserva trazabilidad mediante una nueva revision.</li>
            </ul>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Metodos disponibles</h2>
            <p>El flujo comun concentra RI, PM, LP y US, pero la OT tambien puede habilitar otros metodos segun su configuracion.</p>
            <ul>
                <li>RI</li>
                <li>PM</li>
                <li>LP</li>
                <li>US</li>
                <li>TT</li>
                <li>CV</li>
                <li>DZ</li>
                <li>RG</li>
                <li>PMI</li>
                <li>RD</li>
            </ul>
            <p>Todos estos se enrutan desde un mismo punto de entrada y despues abren el formulario especifico de cada metodo.</p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Si algo no aparece o no deja avanzar</h2>
            <ul>
                <li>Revisar que la OT tenga cargado el servicio correspondiente.</li>
                <li>Confirmar que operadores, procedimientos o soldadores necesarios ya esten asignados si el metodo los necesita.</li>
                <li>Verificar que la OT este siendo trabajada sobre la obra o contexto correcto.</li>
                <li>Revisar si falta completar algun dato obligatorio propio del metodo antes de intentar firmar o cerrar la revision.</li>
            </ul>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como trabajar en esta pantalla</h2>
            <p>Desde la OT seleccionada se ingresa al bloque de Informes y se trabaja sobre el listado de esa OT.</p>
            <div class="ayuda_media">
                <img src="{{ asset('img/ayuda/Generar_informe.gif') }}" class="img-responsive" alt="Acceso a informes" />
            </div>
            <p>En ese listado se ven los informes ya creados, su metodo, numero, revision, obra, usuario y fecha.</p>
            <div class="ayuda_media">
                <img src="{{ asset('img/ayuda/Listado_informes.PNG') }}" class="img-responsive" alt="Listado de informes" />
            </div>
            <p>
                El listado es la referencia principal para ver que ya fue creado, que revision esta vigente y que acciones siguen disponibles para cada informe.
            </p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Que revisar antes de firmar</h2>
            <ul>
                <li>Que el metodo y la obra correspondan al trabajo real.</li>
                <li>Que el encabezado no arrastre datos incorrectos de una clonacion previa.</li>
                <li>Que la revision actual refleje la version que debe quedar disponible para PDF, partes y consultas.</li>
                <li>Que la documentacion complementaria, si existe, ya este adjunta o controlada.</li>
            </ul>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Resultado esperado</h2>
            <p>
                Al finalizar este proceso, la OT queda con informes tecnicos listos para consulta, PDF, revisiones posteriores
                y uso en otros modulos, especialmente partes diarios y reportes.
            </p>
            <p>
                El objetivo no es solo guardar un formulario: es dejar una revision trazable y utilizable por el resto del circuito documental.
            </p>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-visualizar-informes') }}">Visualizacion de informes</a></li>
                <li><a href="{{ route('ayuda-asignar-operadores') }}">Asignar operadores</a></li>
                <li><a href="{{ route('ayuda-asignar-procedimientos') }}">Asignar procedimientos</a></li>
                <li><a href="{{ route('ayuda-asignar-soldadores-y-usuarios') }}">Asignar soldadores y usuarios de cliente</a></li>
                <li><a href="{{ route('ayuda-crear-parte-diario') }}">Creacion de partes diarios</a></li>
            </ul>
        </div>
    </section>
</div>

@endsection
