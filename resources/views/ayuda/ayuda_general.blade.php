@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod">
    <div class="ayuda_hero">
        <h1>Ayuda General</h1>
        <p>
            Esta pagina funciona como indice general de ayuda. Reune los temas principales del sistema y ordena la documentacion
            por secciones funcionales para que cada modulo tenga un punto de entrada claro.
        </p>
        <p>
            Usa este indice para entrar al modulo que necesitas segun el tipo de tarea: gestion de datos base, trabajo operativo,
            documentacion diaria o consulta final de resultados.
        </p>
    </div>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Primeros pasos</h2>
            <p>Acciones basicas para ubicarte en la plataforma y mantener tu cuenta operativa.</p>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-cambiar-clave') }}">Como cambiar o restablecer la contrasena</a></li>
                <li><a href="{{ route('ayuda-buscar-formularios') }}">Buscar en los formularios de la aplicacion</a></li>
                <li><a href="{{ route('ayuda-perfil') }}">Perfil de usuario</a></li>
            </ul>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Ordenes de trabajo</h2>
            <p>
                Este bloque explica como se crea una OT, que informacion concentra y como se habilitan los modulos
                operativos que despues dependen de ella.
            </p>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-visualizar-ot') }}">Visualizacion general de una OT</a></li>
                @can('enod')
                    <li><a href="{{ route('ayuda-crear-ot') }}">Como crear una OT</a></li>
                    <li><a href="{{ route('ayuda-asignar-operadores') }}">Asignar operadores</a></li>
                    <li><a href="{{ route('ayuda-asignar-soldadores-y-usuarios') }}">Asignar soldadores y usuarios de cliente</a></li>
                    <li><a href="{{ route('ayuda-asignar-procedimientos') }}">Asignar procedimientos</a></li>
                    <li><a href="{{ route('ayuda-asignar-vehiculos') }}">Asignar vehiculos y documentacion complementaria</a></li>
                @endcan
                <li><a href="{{ route('ayuda-visualizar-doc-operadores') }}">Visualizar documentacion de operadores</a></li>
                <li><a href="{{ route('ayuda-visualizar-procedimientos') }}">Visualizar procedimientos asignados</a></li>
                <li><a href="{{ route('ayuda-visualizar-vehiculos') }}">Visualizar vehiculos y documentacion complementaria</a></li>
            </ul>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Informes, partes, certificados y remitos</h2>
            <p>
                Es el nucleo documental de la operacion. A partir de una OT activa, el sistema permite generar informes,
                consolidarlos en partes diarios, emitir certificados y registrar movimientos mediante remitos.
            </p>
            <ul class="ayuda_links">
                @can('enod')
                    <li><a href="{{ route('ayuda-generar-informes') }}">Creacion de informes</a></li>
                    <li><a href="{{ route('ayuda-crear-parte-diario') }}">Creacion de partes diarios</a></li>
                    <li><a href="{{ route('ayuda-crear-certificados') }}">Creacion de certificados</a></li>
                @endcan
                <li><a href="{{ route('ayuda-visualizar-informes') }}">Visualizacion de informes</a></li>
                <li><a href="{{ route('ayuda-visualizar-parte-diario') }}">Visualizacion de partes diarios</a></li>
                <li><a href="{{ route('ayuda-visualizar-certificados') }}">Visualizacion de certificados</a></li>
                <li><a href="{{ route('ayuda-creacion-remito') }}">Remitos</a></li>
            </ul>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Maestros</h2>
            <p>Son los datos base del sistema. Si un maestro falta o esta mal cargado, impacta despues en OT, informes, stock o reportes.</p>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-gestion-usuario') }}">Gestionar usuarios</a></li>
                <li><a href="{{ route('ayuda-gestion-cliente') }}">Gestionar clientes</a></li>
                <li><a href="{{ route('ayuda-gestion-comitente') }}">Gestionar comitentes</a></li>
                <li><a href="{{ route('ayuda-gestion-proveedores') }}">Gestionar proveedores</a></li>
                <li><a href="{{ route('ayuda-gestion-frentes') }}">Gestionar frentes</a></li>
                <li><a href="{{ route('ayuda-gestion-contratistas') }}">Gestionar contratistas</a></li>
                <li><a href="{{ route('ayuda-gestion-materiales') }}">Gestionar materiales</a></li>
                <li><a href="{{ route('ayuda-gestion-normas') }}">Gestionar normas</a></li>
                <li><a href="{{ route('ayuda-gestion-documentaciones') }}">Gestionar documentaciones</a></li>
                <li><a href="{{ route('ayuda-gestion-unidades-de-medida') }}">Gestionar unidades de medida</a></li>
                <li><a href="{{ route('ayuda-gestion-medidas') }}">Gestionar medidas</a></li>
                <li><a href="{{ route('ayuda-gestion-servicios') }}">Gestionar servicios</a></li>
                <li><a href="{{ route('ayuda-gestion-productos') }}">Gestionar productos</a></li>
                <li><a href="{{ route('ayuda-gestion-soldadores') }}">Gestionar soldadores</a></li>
                <li><a href="{{ route('ayuda-gestion-equipos') }}">Gestionar equipos</a></li>
                <li><a href="{{ route('ayuda-gestion-interno-equipos') }}">Gestionar internos de equipos</a></li>
                <li><a href="{{ route('ayuda-gestion-fuentes') }}">Gestionar fuentes</a></li>
                <li><a href="{{ route('ayuda-gestion-interno-fuente') }}">Gestionar internos de fuente</a></li>
                <li><a href="{{ route('ayuda-gestion-vehiculos') }}">Gestionar vehiculos</a></li>
                <li><a href="{{ route('ayuda-gestion-plantas') }}">Gestionar plantas</a></li>
                <li><a href="{{ route('ayuda-gestionar-roles') }}">Gestionar roles</a></li>
                <li><a href="{{ route('ayuda-gestion-permisos') }}">Gestionar permisos</a></li>
            </ul>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Operacion interna</h2>
            <p>Incluye modulos transversales para control, seguimiento, movimientos, consultas y reportes internos.</p>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-stock') }}">Gestion de stock</a></li>
                <li><a href="{{ route('ayuda-asistencia') }}">Control de asistencia</a></li>
                <li><a href="{{ route('ayuda-epp') }}">Asignacion de EPP</a></li>
                <li><a href="{{ route('ayuda-reportes') }}">Reportes</a></li>
                <li><a href="{{ route('ayuda-qr') }}">QR y documentacion asociada</a></li>
                <li><a href="{{ route('ayuda-notificaciones') }}">Notificaciones y alarmas</a></li>
            </ul>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Dosimetria</h2>
            <p>Reune carga, seguimiento e historico de informacion dosimetrica y de estados asociados.</p>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-dosimetria-operador') }}">Dosimetria de operador</a></li>
                <li><a href="{{ route('ayuda-dosimetria-rx') }}">Dosimetria RX</a></li>
                <li><a href="{{ route('ayuda-dosimetria-estados') }}">Estados de film</a></li>
                <li><a href="{{ route('ayuda-dosimetria-resumen') }}">Resumen de dosimetria</a></li>
                <li><a href="{{ route('ayuda-historial-operadores') }}">Historial de operadores</a></li>
            </ul>
        </div>
    </section>

    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>Multimedia, 3D y alertas</h2>
            <p>Contiene herramientas de publicacion, consulta visual y seguimiento de avisos del sistema.</p>
            <ul class="ayuda_links">
                <li><a href="{{ route('ayuda-multimedia-gestion') }}">Gestion de multimedia</a></li>
                <li><a href="{{ route('ayuda-multimedia-visualizacion') }}">Visualizacion de multimedia</a></li>
                <li><a href="{{ route('ayuda-modelos-3d') }}">Modelos 3D</a></li>
                <li><a href="{{ route('ayuda-notificaciones') }}">Notificaciones, alarmas y receptores</a></li>
            </ul>
        </div>
    </section>
</div>

@endsection
