@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="ayuda_panel">
        <h1>Gestionar documentacion</h1>
        <p>
            Esta pantalla centraliza la carga y administracion de documentos del sistema.
            Desde aqui se pueden registrar archivos, filtrar por tipo, controlar vencimientos y descargar documentacion.
        </p>
    </div>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Como usar el listado</h2>
            <p>
                Al ingresar a la seccion se muestra una grilla con los documentos cargados. El listado permite revisar tipo,
                titulo, descripcion, vencimiento y otros datos segun el documento.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/documentaciones/Listado_documentaciones.PNG') }}" alt="Listado de documentaciones" />
            </div>
            <p>
                Tambien pueden usarse filtros por tipo, busqueda por texto y la opcion de mostrar solo documentacion vencida.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/documentaciones/Filtro_tipo_documento.PNG') }}" alt="Filtro por tipo de documento" />
            </div>
            <p>
                Si se seleccionan uno o varios registros, el sistema permite descargarlos en un archivo comprimido.
            </p>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Crear o editar documentacion</h2>
            <p>
                Para cargar un documento nuevo debe usarse el boton <strong>Nuevo</strong>. El formulario cambia segun el tipo de documento
                elegido y permite adjuntar el archivo digital correspondiente.
            </p>
            <p>
                Los tipos mas frecuentes son:
            </p>
            <ul>
                <li><strong>Institucional:</strong> documentacion general de la empresa.</li>
                <li><strong>OT:</strong> archivos asociados a ordenes de trabajo.</li>
                <li><strong>Procedimiento general:</strong> procedimientos tecnicos o de gestion.</li>
                <li><strong>Usuario:</strong> documentacion personal o habilitaciones.</li>
                <li><strong>Equipo:</strong> documentos de equipos e internos.</li>
                <li><strong>Fuente:</strong> documentacion de fuentes.</li>
                <li><strong>Vehiculo:</strong> documentacion de vehiculos.</li>
            </ul>
            <p>
                En la mayoria de los casos se completa titulo, descripcion, fecha de caducidad y la entidad asociada,
                ademas de marcar si el documento debe quedar visible.
            </p>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/documentaciones/Form_doc_institucional.PNG') }}" alt="Documento institucional" />
            </div>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/documentaciones/Form_doc_proc_general.PNG') }}" alt="Procedimiento general" />
            </div>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/documentaciones/Form_doc_usuario.PNG') }}" alt="Documento de usuario" />
            </div>
            <div class="ayuda_media">
                <img class="img-responsive" src="{{ asset('img/ayuda/documentaciones/Form_doc_equipo.PNG') }}" alt="Documento de equipo" />
            </div>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Importante</h2>
            <p>
                Conviene revisar tipo de documento, fecha de vencimiento y entidad asociada antes de guardar, porque esos datos
                despues impactan en consultas, vencimientos y asignaciones dentro de OT, usuarios, equipos o vehiculos.
            </p>
            <p>
                Desde el listado tambien se puede editar o eliminar un documento existente.
            </p>
            <h3>Articulos relacionados</h3>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-asignar-procedimientos') }}">Asignar procedimientos</a></li>
                <li><a href="{{ route('ayuda-visualizar-doc-operadores') }}">Visualizar documentacion de operadores</a></li>
                <li><a href="{{ route('ayuda-visualizar-vehiculos') }}">Visualizar vehiculos y documentacion complementaria</a></li>
            </ul>
        </div>
    </section>
</div>

@endsection
