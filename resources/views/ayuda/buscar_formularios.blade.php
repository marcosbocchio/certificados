@extends('layouts.enod.master')

@section('contenido')

<div id="app">
<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Buscar en los formularios de la aplicacion</h1>
        <p>
            Muchos listados del sistema tienen un campo de busqueda en la parte superior derecha.
            Ese campo permite filtrar la informacion visible sin tener que recorrer toda la tabla.
        </p>
    </div>

    @include('ayuda.partials.functional_summary')

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <p>
                Cada formulario que contiene un icono de <i class="fa fa-search" style="color:#FFCC00;"></i> <strong>lupa</strong> arriba a la derecha
                brinda la posibilidad de filtrar el listado o buscar un item en particular.
            </p>
            <p>
                La busqueda puede ser parcial y se realiza por cualquiera de los datos visibles en la lista.
                A continuacion se muestra un ejemplo de busqueda sobre el listado de OTs:
            </p>

            <ayuda-demo-buscador></ayuda-demo-buscador>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como usar la busqueda</h2>
            <ol>
                <li>Ubica el campo de busqueda en la parte superior derecha del listado.</li>
                <li>Escribe el dato que deseas encontrar, completo o parcial.</li>
                <li>Presiona Enter o espera a que el listado se filtre.</li>
                <li>Revisa los resultados mostrados en la tabla.</li>
            </ol>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Importante</h2>
            <p>
                Cuando la busqueda se realiza sobre el listado de OTs, los resultados no solo dependen del texto ingresado,
                sino tambien del usuario actual.
            </p>
            <p>
                Si el usuario pertenece a un cliente, solo podra visualizar las OTs de ese cliente y, ademas,
                aquellas a las que este autorizado.
            </p>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-visualizar-ot') }}">Visualizacion general de una OT</a></li>
            </ul>
        </div>
    </section>
</div>
</div>

@endsection
