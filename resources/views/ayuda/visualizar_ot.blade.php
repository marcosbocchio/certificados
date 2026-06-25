@extends('layouts.enod.master')

@section('contenido')

<div id="app">
<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Visualizacion general de una orden de trabajo</h1>
        <p>
            La OT es el registro principal del trabajo operativo. Desde esta pantalla se puede revisar la informacion general
            de cada orden y entrar a los modulos asociados.
        </p>
        <p>
            El listado principal muestra solo la informacion que el usuario puede consultar. Un usuario cliente no ve cualquier
            OT del sistema: solo accede a las que le fueron asociadas.
        </p>
    </div>

    @include('ayuda.partials.functional_summary')

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Que se ve en el listado</h2>
            <p>
                Las OT se listan en orden descendente de alta. Desde esta pantalla se puede identificar rapidamente
                el cliente, la fecha, el estado y las acciones disponibles sobre cada registro.
            </p>
            <ayuda-demo-filtros-ot></ayuda-demo-filtros-ot>
            <ayuda-demo-tabla-ots></ayuda-demo-tabla-ots>
            <h3>Estados de la OT</h3>
            <ul>
                <li><strong>Editando:</strong> la OT todavia puede ajustarse antes de quedar formalmente activa.</li>
                <li><strong>Activa:</strong> la OT ya fue firmada y habilita el circuito operativo normal.</li>
                <li><strong>Cerrada:</strong> la OT ya no sigue en proceso operativo y queda como antecedente consultable.</li>
            </ul>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Importante</h2>
            <p>La OT se relaciona con cliente, contactos, ubicacion, responsable y otros datos tecnicos que despues se usan en el resto del circuito.</p>
            <ul>
                <li>Cliente y datos de contacto.</li>
                <li>Servicios que despues habilitan metodos e informes.</li>
                <li>Productos, EPP y riesgos si forman parte del alcance.</li>
                <li>Responsable de OT y ubicacion de obra.</li>
            </ul>
            <p>
                Cuanto mejor quede definida la OT al inicio, mas ordenado sera despues el trabajo en informes, partes,
                certificados y remitos.
            </p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Articulos relacionados</h2>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-crear-ot') }}">Como crear una OT</a></li>
                <li><a href="{{ route('ayuda-visualizar-doc-operadores') }}">Visualizar documentacion de operadores</a></li>
                <li><a href="{{ route('ayuda-visualizar-procedimientos') }}">Visualizar procedimientos asignados</a></li>
                <li><a href="{{ route('ayuda-visualizar-vehiculos') }}">Visualizar vehiculos y documentacion complementaria</a></li>
                <li><a href="{{ route('ayuda-visualizar-informes') }}">Visualizar informes de la OT</a></li>
                <li><a href="{{ route('ayuda-visualizar-parte-diario') }}">Visualizar partes diarios</a></li>
                <li><a href="{{ route('ayuda-visualizar-certificados') }}">Visualizar certificados</a></li>
                <li><a href="{{ route('ayuda-creacion-remito') }}">Remitos</a></li>
            </ul>
        </div>
    </section>
</div>
</div>

@endsection
