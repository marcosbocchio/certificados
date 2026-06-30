@extends('layouts.enod.master')

@section('contenido')

@php
    $secciones = [
        [
            'titulo' => 'Primeros pasos',
            'descripcion' => 'Acciones básicas para ubicarte en la plataforma y mantener tu cuenta operativa.',
            'icono' => 'play-circle',
            'color' => 'turquesa',
            'categoria' => 'inicio',
            'links' => [
                ['label' => 'Cómo cambiar o restablecer la contraseña', 'href' => route('ayuda-cambiar-clave')],
                ['label' => 'Buscar en los formularios de la aplicación', 'href' => route('ayuda-buscar-formularios')],
                ['label' => 'Perfil de usuario', 'href' => route('ayuda-perfil')],
            ],
        ],
        [
            'titulo' => 'Órdenes de trabajo',
            'descripcion' => 'Cómo se crea una OT, qué información concentra y qué módulos operativos se habilitan a partir de ella.',
            'icono' => 'clipboard',
            'color' => 'azul',
            'categoria' => 'operativo',
            'links' => array_values(array_filter([
                ['label' => 'Visualización general de una OT', 'href' => route('ayuda-visualizar-ot')],
                auth()->user()->can('enod') ? ['label' => 'Cómo crear una OT', 'href' => route('ayuda-crear-ot')] : null,
                auth()->user()->can('enod') ? ['label' => 'Asignar operadores', 'href' => route('ayuda-asignar-operadores')] : null,
                auth()->user()->can('enod') ? ['label' => 'Asignar soldadores y usuarios de cliente', 'href' => route('ayuda-asignar-soldadores-y-usuarios')] : null,
                auth()->user()->can('enod') ? ['label' => 'Asignar procedimientos', 'href' => route('ayuda-asignar-procedimientos')] : null,
                auth()->user()->can('enod') ? ['label' => 'Asignar vehículos y documentación complementaria', 'href' => route('ayuda-asignar-vehiculos')] : null,
                ['label' => 'Visualizar documentación de operadores', 'href' => route('ayuda-visualizar-doc-operadores')],
                ['label' => 'Visualizar procedimientos asignados', 'href' => route('ayuda-visualizar-procedimientos')],
                ['label' => 'Visualizar vehículos y documentación complementaria', 'href' => route('ayuda-visualizar-vehiculos')],
            ])),
        ],
        [
            'titulo' => 'Informes, partes, certificados y remitos',
            'descripcion' => 'Núcleo documental: generación de informes, partes diarios, certificados y remitos a partir de una OT activa.',
            'icono' => 'file-text',
            'color' => 'violeta',
            'categoria' => 'documental',
            'links' => array_values(array_filter([
                auth()->user()->can('enod') ? ['label' => 'Creación de informes', 'href' => route('ayuda-generar-informes')] : null,
                auth()->user()->can('enod') ? ['label' => 'Creación de partes diarios', 'href' => route('ayuda-crear-parte-diario')] : null,
                auth()->user()->can('enod') ? ['label' => 'Creación de certificados', 'href' => route('ayuda-crear-certificados')] : null,
                ['label' => 'Visualización de informes', 'href' => route('ayuda-visualizar-informes')],
                ['label' => 'Visualización de partes diarios', 'href' => route('ayuda-visualizar-parte-diario')],
                ['label' => 'Visualización de certificados', 'href' => route('ayuda-visualizar-certificados')],
                ['label' => 'Remitos', 'href' => route('ayuda-creacion-remito')],
            ])),
        ],
        [
            'titulo' => 'Maestros',
            'descripcion' => 'Datos base del sistema. Si un maestro falta o está mal cargado impacta en OT, informes, stock y reportes.',
            'icono' => 'database',
            'color' => 'naranja',
            'categoria' => 'maestros',
            'links' => [
                ['label' => 'Gestionar usuarios', 'href' => route('ayuda-gestion-usuario')],
                ['label' => 'Gestionar clientes', 'href' => route('ayuda-gestion-cliente')],
                ['label' => 'Gestionar comitentes', 'href' => route('ayuda-gestion-comitente')],
                ['label' => 'Gestionar proveedores', 'href' => route('ayuda-gestion-proveedores')],
                ['label' => 'Gestionar frentes', 'href' => route('ayuda-gestion-frentes')],
                ['label' => 'Gestionar contratistas', 'href' => route('ayuda-gestion-contratistas')],
                ['label' => 'Gestionar materiales', 'href' => route('ayuda-gestion-materiales')],
                ['label' => 'Gestionar normas', 'href' => route('ayuda-gestion-normas')],
                ['label' => 'Gestionar documentaciones', 'href' => route('ayuda-gestion-documentaciones')],
                ['label' => 'Gestionar unidades de medida', 'href' => route('ayuda-gestion-unidades-de-medida')],
                ['label' => 'Gestionar medidas', 'href' => route('ayuda-gestion-medidas')],
                ['label' => 'Gestionar servicios', 'href' => route('ayuda-gestion-servicios')],
                ['label' => 'Gestionar productos', 'href' => route('ayuda-gestion-productos')],
                ['label' => 'Gestionar soldadores', 'href' => route('ayuda-gestion-soldadores')],
                ['label' => 'Gestionar equipos', 'href' => route('ayuda-gestion-equipos')],
                ['label' => 'Gestionar internos de equipos', 'href' => route('ayuda-gestion-interno-equipos')],
                ['label' => 'Gestionar fuentes', 'href' => route('ayuda-gestion-fuentes')],
                ['label' => 'Gestionar internos de fuente', 'href' => route('ayuda-gestion-interno-fuente')],
                ['label' => 'Gestionar vehículos', 'href' => route('ayuda-gestion-vehiculos')],
                ['label' => 'Gestionar plantas', 'href' => route('ayuda-gestion-plantas')],
                ['label' => 'Gestionar roles', 'href' => route('ayuda-gestionar-roles')],
                ['label' => 'Gestionar permisos', 'href' => route('ayuda-gestion-permisos')],
            ],
        ],
        [
            'titulo' => 'Operación interna',
            'descripcion' => 'Módulos transversales para control, seguimiento, movimientos, consultas y reportes internos.',
            'icono' => 'briefcase',
            'color' => 'verde',
            'categoria' => 'interno',
            'links' => [
                ['label' => 'Gestión de stock', 'href' => route('ayuda-stock')],
                ['label' => 'Control de asistencia', 'href' => route('ayuda-asistencia')],
                ['label' => 'Asignación de EPP', 'href' => route('ayuda-epp')],
                ['label' => 'Reportes', 'href' => route('ayuda-reportes')],
                ['label' => 'QR y documentación asociada', 'href' => route('ayuda-qr')],
                ['label' => 'Notificaciones y alarmas', 'href' => route('ayuda-notificaciones')],
            ],
        ],
        [
            'titulo' => 'Dosimetría',
            'descripcion' => 'Carga, seguimiento e histórico de información dosimétrica y estados asociados.',
            'icono' => 'bolt',
            'color' => 'rosa',
            'categoria' => 'dosimetria',
            'links' => [
                ['label' => 'Dosimetría de operador', 'href' => route('ayuda-dosimetria-operador')],
                ['label' => 'Dosimetría RX', 'href' => route('ayuda-dosimetria-rx')],
                ['label' => 'Estados de film', 'href' => route('ayuda-dosimetria-estados')],
                ['label' => 'Resumen de dosimetría', 'href' => route('ayuda-dosimetria-resumen')],
                ['label' => 'Historial de operadores', 'href' => route('ayuda-historial-operadores')],
            ],
        ],
        [
            'titulo' => 'Multimedia, 3D y alertas',
            'descripcion' => 'Herramientas de publicación, consulta visual y seguimiento de avisos del sistema.',
            'icono' => 'image',
            'color' => 'gris',
            'categoria' => 'extras',
            'links' => [
                ['label' => 'Gestión de multimedia', 'href' => route('ayuda-multimedia-gestion')],
                ['label' => 'Visualización de multimedia', 'href' => route('ayuda-multimedia-visualizacion')],
                ['label' => 'Modelos 3D', 'href' => route('ayuda-modelos-3d')],
                ['label' => 'Notificaciones, alarmas y receptores', 'href' => route('ayuda-notificaciones')],
            ],
        ],
    ];
@endphp

<div id="app">
    <ayuda-indice :secciones='@json($secciones)'></ayuda-indice>
</div>

@endsection
