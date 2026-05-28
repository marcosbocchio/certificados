@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Asignar procedimientos a una orden de trabajo (OT)</h1>
        <p>
            Esta pantalla se usa para vincular a la OT los procedimientos que van a quedar disponibles durante el trabajo.
            Aqui pueden asociarse procedimientos propios de Empresa y procedimientos del cliente.
        </p>
    </div>

    @include('ayuda.partials.functional_summary')

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <p>
                Los procedimientos asignados despues pueden consultarse desde la OT y tambien se utilizan al momento de generar informes.
                Para asociar procedimientos de Empresa, la documentacion debe estar creada previamente en el modulo correspondiente.
            </p>
            <p>A continuacion se muestra un ejemplo de asignacion de procedimientos:</p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/Asignar_procedimiento.gif') }}" alt="Asignacion de procedimientos a una OT" />
            </div>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como usar esta pantalla</h2>
            <ol>
                <li>Ingresar a la OT correspondiente.</li>
                <li>Abrir la seccion de procedimientos.</li>
                <li>Buscar y seleccionar los procedimientos que correspondan al trabajo.</li>
                <li>Guardar o actualizar la asignacion.</li>
            </ol>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Importante</h2>
            <p>
                Si no se asignan procedimientos de Empresa, en la generacion de informes solo podran elegirse los procedimientos standard de cada metodo.
            </p>
            <p>
                Si no se asigna al menos un procedimiento de cliente, la generacion de informes puede quedar limitada o no estar disponible segun el caso.
            </p>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-visualizar-procedimientos') }}">Visualizar procedimientos asignados</a></li>
                <li><a href="{{ route('ayuda-gestion-documentaciones') }}">Gestionar documentacion</a></li>
                <li><a href="{{ route('ayuda-generar-informes') }}">Creacion de informes</a></li>
            </ul>
        </div>
    </section>
</div>

@endsection
