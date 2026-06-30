@extends('layouts.enod.master')

@section('contenido')

<div id="app">
<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Gestionar normas</h1>
        <p>
            Esta ayuda agrupa la administracion de normas de ensayo, normas de fabricacion y normas de evaluacion.
            La operatoria es similar en las tres pantallas: cambia el tipo de norma, pero no la forma de trabajar.
        </p>
    </div>
</div>

<section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Tipos de normas disponibles</h2>
            <ul>
                <li><strong>Normas de ensayo:</strong> se usan en la definicion y documentacion de ensayos.</li>
                <li><strong>Normas de fabricacion:</strong> se vinculan a componentes, procesos o referencias de construccion.</li>
                <li><strong>Normas de evaluacion:</strong> se utilizan para criterios de aceptacion o rechazo.</li>
            </ul>
            <p>
                Estas normas despues pueden aparecer en encabezados y reportes de distintos informes del sistema.
            </p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como usar los listados</h2>
            <p>
                Cada tipo de norma tiene su propia pantalla de listado. Desde alli puede revisarse el codigo y la descripcion
                de las normas cargadas.
            </p>
            
            
            
            <p>
                Segun la pantalla, puede haber buscador o paginacion para facilitar la consulta.
            </p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Crear o editar una norma</h2>
            <p>
                Para dar de alta una norma debe usarse el boton <strong>Nuevo</strong>. El formulario es similar en los tres casos
                y permite cargar codigo y descripcion.
            </p>
            
            
            <p>
                Desde el listado tambien se puede editar una norma existente o eliminarla, segun los permisos disponibles.
            </p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel detalle_iconos">
            <h2>Importante</h2>
            <p><strong>Permite modificar la informacion de la norma seleccionada.</strong></p>
            <p><strong>Permite eliminar el registro, previa confirmacion.</strong></p>
            <p>
                Conviene mantener codigos y descripciones normalizados, porque estas normas despues se reutilizan en distintos tipos de informes.
            </p>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-generar-informes') }}">Creacion de informes</a></li>
                <li><a href="{{ route('ayuda-generar-informes-ri') }}">Informes RI</a></li>
                <li><a href="{{ route('ayuda-generar-informes-us') }}">Informes US</a></li>
            </ul>
        </div>
    </section>
    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Ejemplo en pantalla</h2>
            <p>Asi se ve este maestro en el sistema. Probá el buscador y mirá los iconos de accion en cada fila.</p>
            <ayuda-demo-abm-tabla entidad="norma"></ayuda-demo-abm-tabla>
            <ayuda-demo-abm-form entidad="norma"></ayuda-demo-abm-form>
        </div>
    </section>
</div>
</div>

@endsection
