@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Asignar soldadores y usuarios de cliente a una orden de trabajo (OT)</h1>
        <p>
            En esta pantalla se definen dos cosas: que usuarios del cliente podran visualizar la documentacion de la OT
            y que soldadores quedaran disponibles para los informes donde corresponda.
        </p>
    </div>

    @include('ayuda.partials.functional_summary')

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <p>
                Para que un usuario de cliente pueda visualizar la OT, los informes, los partes diarios y los certificados,
                debe estar asignado en esta seccion.
            </p>
            <p>
                Si la OT tiene servicios de RI, tambien hay que indicar los soldadores que podran seleccionarse en ese tipo de informe.
                Para poder elegirlos, primero deben existir dentro del maestro de <a href="{{ route('ayuda-gestion-soldadores') }}"><strong>soldadores</strong></a>.
            </p>
            <p>A continuacion se muestra un ejemplo de esta asignacion:</p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/Asignar_soldador.gif') }}" alt="Asignacion de soldadores y usuarios de cliente" />
            </div>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como usar esta pantalla</h2>
            <ol>
                <li>Ingresar a la OT correspondiente.</li>
                <li>Seleccionar los usuarios de cliente que deben tener acceso a la documentacion.</li>
                <li>Seleccionar los soldadores que deban quedar disponibles para la OT.</li>
                <li>Guardar o actualizar la asignacion.</li>
            </ol>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Importante</h2>
            <p>
                Si las pasadas de los informes RI son informadas por el cliente mediante archivo CSV,
                no es necesario indicar los soldadores manualmente, ya que el sistema puede agregarlos automaticamente.
            </p>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-gestion-soldadores') }}">Gestionar soldadores</a></li>
                <li><a href="{{ route('ayuda-gestion-usuario') }}">Gestionar usuarios</a></li>
                <li><a href="{{ route('ayuda-generar-informes') }}">Creacion de informes</a></li>
            </ul>
        </div>
    </section>
</div>

@endsection
