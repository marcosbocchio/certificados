@extends('layouts.enod.master')

@section('contenido')

<div id="app">
<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Asignar operadores a una orden de trabajo (OT)</h1>
        <p>
            La asignacion de operadores y ayudantes permite definir que personas podran intervenir en la OT.
            Estos operadores luego podran ser seleccionados en informes y partes diarios.
        </p>
    </div>

    @include('ayuda.partials.functional_summary')

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <p>
                Ademas de ordenar el trabajo operativo, esta asignacion permite que los clientes visualicen
                la documentacion asociada a los operadores cargados en la OT.
            </p>
            <p>A continuacion se muestra un ejemplo de asignacion de operadores y ayudantes:</p>
            <ayuda-demo-asignacion entidad="operador"></ayuda-demo-asignacion>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como usar esta pantalla</h2>
            <ol>
                <li>Ingresar a la OT correspondiente.</li>
                <li>Abrir la seccion de operadores.</li>
                <li>Seleccionar los usuarios que participaran en la OT.</li>
                <li>Guardar o actualizar la asignacion.</li>
            </ol>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Importante</h2>
            <p>
                La documentacion de cada operador se visualiza despues de hacer click en el boton de actualizar.
            </p>
            <p>
                Esta asignacion impacta directamente en la seleccion de responsables dentro de informes y partes diarios.
            </p>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-gestion-usuario') }}">Gestionar usuarios</a></li>
                <li><a href="{{ route('ayuda-visualizar-doc-operadores') }}">Visualizar documentacion de operadores</a></li>
                <li><a href="{{ route('ayuda-generar-informes') }}">Creacion de informes</a></li>
            </ul>
        </div>
    </section>
</div>
</div>

@endsection
