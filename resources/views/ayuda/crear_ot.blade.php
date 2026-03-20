@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Como crear una orden de trabajo (OT)</h1>
        <p>
            La orden de trabajo es el registro principal desde el cual se organiza el resto de la documentacion operativa.
            Antes de generar informes, partes o certificados, primero debe existir una OT correctamente cargada.
        </p>
    </div>

    @include('ayuda.partials.functional_summary')

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Antes de empezar</h2>
            <ul>
                <li>Conviene revisar que cliente, comitente, servicios y productos ya existan en sus maestros.</li>
                <li>La OT es el punto de partida del circuito documental. Si queda incompleta, despues impacta en informes, partes, certificados y remitos.</li>
                <li>El responsable de OT debe poder asociarse como operador de la orden.</li>
            </ul>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Pasos para crear una OT</h2>
            <ol>
                <li>Hacer click en el menu <strong>Tablero Principal</strong>.</li>
                <li>Hacer click en el boton <strong>Nueva OT</strong>.</li>
                <li>Completar el formulario con la informacion solicitada.</li>
                <li>Hacer click en <strong>Guardar</strong>.</li>
            </ol>
            <p>
                Guardar crea la OT y deja disponible su circuito de trabajo. A partir de ese momento ya puede completarse,
                editarse o prepararse para firma segun el estado de avance del trabajo.
            </p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Datos principales del formulario</h2>
            <ul>
                <li><strong>Proyecto:</strong> nombre del proyecto.</li>
                <li><strong>FST N°:</strong> numero de presupuesto.</li>
                <li><strong>OT N°:</strong> numero de OT.</li>
                <li><strong>Fecha:</strong> fecha de creacion de la OT.</li>
                <li><strong>Obra N° / OC:</strong> numero de obra asignado por el cliente. Debe ingresarse para OT de obra unica. Si la OT es multiobra, este campo puede quedar vacio.</li>
                <li><strong>Fecha estimada y hora:</strong> momento estimado de inicio del trabajo.</li>
                <li><strong>Cliente:</strong> cliente que solicita el ensayo.</li>
                <li><strong>Mostrar logo:</strong> define si el logo se visualiza en los informes.</li>
                <li><strong>Comitente:</strong> comitente asociado al trabajo.</li>
                <li><strong>Contacto:</strong> contactos del cliente que se desea mostrar en la OT.</li>
                <li><strong>Responsable OT:</strong> responsable de Enod. Debe estar asignado como <a href="{{ route('ayuda-asignar-operadores') }}"><strong>operador de la OT</strong></a>.</li>
                <li><strong>Lugar de ensayo:</strong> sector descriptivo y datos de ubicacion. Si se completa latitud y longitud, el mapa se reubica con esa informacion.</li>
            </ul>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como conviene completar la cabecera</h2>
            <ul>
                <li><strong>Cliente y comitente:</strong> conviene definirlos desde el inicio porque despues aparecen en documentos y referencias visibles.</li>
                <li><strong>Obra / OC:</strong> ayuda a distinguir el trabajo dentro del cliente y ordenar la documentacion posterior.</li>
                <li><strong>Responsable OT:</strong> debe ser una referencia real de la operacion, porque despues impacta en seguimiento y lectura del circuito.</li>
                <li><strong>Lugar de ensayo:</strong> cuanto mas claro quede este dato, mas facil sera interpretar informes, partes y movimientos asociados.</li>
            </ul>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Servicios, productos y otros datos</h2>
            <ul>
                <li><strong>Servicios:</strong> agregar cada servicio presupuestado con el boton <strong>+</strong>. Puede indicarse norma de evaluacion y de ensayo.</li>
                <li><strong>Productos:</strong> agregar cada producto presupuestado indicando la medida correspondiente.</li>
                <li><strong>Elementos de seguridad:</strong> EPP requeridos para el trabajo.</li>
                <li><strong>Riesgos:</strong> riesgos detectados para el ensayo.</li>
                <li><strong>Observaciones:</strong> comentarios generales de la OT.</li>
            </ul>
            <p>Mira un ejemplo:</p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/Nueva_ot.gif') }}" alt="Creacion de nueva OT" />
            </div>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Decisiones clave</h2>
            <ul>
                <li><strong>Servicios:</strong> son el dato mas sensible porque determinan que metodos podran usarse despues en informes.</li>
                <li><strong>Productos:</strong> ordenan referencias que mas tarde pueden reaparecer en remitos, stock o formularios relacionados.</li>
                <li><strong>EPP y riesgos:</strong> ayudan a dejar preparado el contexto operativo y de seguridad del trabajo.</li>
                <li><strong>Observaciones:</strong> conviene usarlas para aclaraciones generales, no para reemplazar datos estructurados del formulario.</li>
            </ul>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Que revisar antes de seguir</h2>
            <ul>
                <li>Que cliente, comitente y responsable esten correctos.</li>
                <li>Que los servicios cargados coincidan con el trabajo real que despues se informara.</li>
                <li>Que la OT quede lo suficientemente completa como para asignar operadores, procedimientos, soldadores o vehiculos sin volver a corregir la base.</li>
                <li>Que los datos visibles en cabecera representen correctamente el trabajo a ejecutar.</li>
            </ul>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Resultado esperado</h2>
            <p>
                Cuanto mejor quede definida la OT al momento de crearla, mas ordenado sera despues el trabajo de asignaciones,
                informes, partes, certificados y remitos.
            </p>
            <p>
                La orden debe quedar lista para firmarse y habilitar despues el resto del circuito operativo sin tener que volver a corregir datos base.
            </p>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-visualizar-ot') }}">Visualizacion general de una OT</a></li>
                <li><a href="{{ route('ayuda-gestion-cliente') }}">Gestionar clientes</a></li>
                <li><a href="{{ route('ayuda-gestion-comitente') }}">Gestionar comitentes</a></li>
                <li><a href="{{ route('ayuda-gestion-servicios') }}">Gestionar servicios</a></li>
                <li><a href="{{ route('ayuda-gestion-productos') }}">Gestionar productos</a></li>
            </ul>
        </div>
    </section>
</div>

@endsection
