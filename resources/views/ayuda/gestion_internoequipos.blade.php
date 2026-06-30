@extends('layouts.enod.master')

@section('contenido')

<div id="app">
<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Gestionar internos de equipos</h1>
        <p>
            Esta pantalla se usa para registrar las unidades fisicas de cada equipo.
            A diferencia del maestro de equipos, aqui se carga cada interno con su numero de serie, numero interno, estado y datos propios.
        </p>
    </div>
</div>

<section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como usar el listado</h2>
            <p>
                Al ingresar a la seccion se muestra una grilla con los internos registrados. El listado permite revisar numero interno,
                equipo asociado, metodo, fuente asignada, actividad, ubicacion y estado.
            </p>
            
            <p>
                Puede filtrarse por activos y usar el buscador para localizar rapidamente un interno.
            </p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Crear o editar un interno</h2>
            <p>
                Para dar de alta un interno debe usarse el boton <strong>Nuevo</strong>. El formulario permite cargar numero de serie,
                numero interno, equipo, estado y otros campos segun el tipo de equipo seleccionado.
            </p>
            
            <p>
                Segun el equipo elegido pueden habilitarse campos adicionales como fuente asignada, foco, voltaje, amperaje,
                probeta o dureza de calibracion.
            </p>
            
            <p>
                Al crear un interno nuevo el sistema lo vincula a un frente inicial y registra su trazabilidad.
            </p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel detalle_iconos">
            <h2>Importante</h2>
            <p><strong>Permite consultar el historial de fuentes vinculadas al equipo.</strong></p>
            
            <p><strong>Permite modificar la informacion del interno seleccionado.</strong></p>
            <p><strong>Permite dar de baja o eliminar el registro, segun el caso.</strong></p>
            <p>
                Conviene revisar bien el equipo asociado, la fuente asignada y el estado activo antes de guardar, porque esos datos
                despues impactan en informes, trazabilidad y disponibilidad operativa.
            </p>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-gestion-equipos') }}">Gestionar equipos</a></li>
                <li><a href="{{ route('ayuda-gestion-internofuente') }}">Gestionar internos de fuente</a></li>
                <li><a href="{{ route('ayuda-gestion-documentaciones') }}">Gestionar documentacion</a></li>
            </ul>
        </div>
    </section>
    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Ejemplo en pantalla</h2>
            <p>Asi se ve este maestro en el sistema. Probá el buscador y mirá los iconos de accion en cada fila.</p>
            <ayuda-demo-abm-tabla entidad="internoequipo"></ayuda-demo-abm-tabla>
            <ayuda-demo-abm-form entidad="internoequipo"></ayuda-demo-abm-form>
        </div>
    </section>
</div>
</div>

@endsection
