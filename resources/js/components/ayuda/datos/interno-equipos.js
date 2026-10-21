export default {
    hero: {
        titulo: 'Gestionar internos de equipos',
        descripcion:
            'Un interno es la unidad concreta de un equipo: tiene su número interno, su número de serie, su fuente y su estado. ' +
            'Los informes no se arman con el equipo sino con el interno, por eso este maestro es el paso que sigue a Equipos.',
    },

    ir_a: {
        label: 'Ir al maestro de Internos de equipos',
        ruta: '/area/enod/interno_equipos',
        icono: 'tag',
    },

    secciones_destacadas: [
        { titulo: 'Equipo e interno: cuál es cuál', componente: 'ayuda-equipo-vs-interno' },
    ],

    acciones: [
        { icono: 'search', titulo: 'Ver y buscar internos',        detalle: 'El buscador encuentra por número interno, equipo, método, tipo de equipamiento o frente. Con Mostrar activos se ocultan los dados de baja.' },
        { icono: 'plus',   titulo: 'Crear un interno',             detalle: 'Con Nuevo elegís el equipo y cargás serie, número interno y los datos que pida ese equipo.' },
        { icono: 'table',  titulo: 'Ver el historial de fuentes',  detalle: 'El ícono de grilla de cada fila abre qué fuentes tuvo el interno y desde cuándo.' },
        { icono: 'pencil', titulo: 'Editar o dar de baja',         detalle: 'Cambiás datos, la fuente o desmarcás Activo para darlo de baja.' },
        { icono: 'trash',  titulo: 'Eliminar un interno',          detalle: 'Solo si no tiene informes ni otros registros asociados.' },
    ],

    dependencias: [
        { entidad: 'Un equipo en el maestro', descripcion: 'Sin equipo no se puede crear el interno. Los métodos del equipo definen qué campos aparecen.', ruta: '/ayuda_gestion_equipos', critico: true },
        { entidad: 'Un interno de fuente',    descripcion: 'Si el equipo es RI o RD, la fuente se elige de los internos de fuente ya cargados.', ruta: '/ayuda_gestion_interno_fuente', critico: false },
        { entidad: 'Un número interno libre', descripcion: 'Hasta 10 caracteres. Es el número con el que se lo reconoce en el campo y en los informes.', critico: false },
    ],

    bloques_intro: 'El formulario cambia según los métodos del equipo elegido. Si el equipo tiene más de un método, aparecen los campos de todos ellos.',

    bloques: [
        { titulo: 'Identificación', icono: 'tag', descripcion: 'Siempre se piden, sea cual sea el método.',
          campos: [
              { nombre: 'N° Serie',   obligatorio: false, detalle: 'hasta 45 caracteres. La pantalla lo marca con asterisco, pero el sistema deja guardar sin él.' },
              { nombre: 'N° Interno', obligatorio: true,  detalle: 'hasta 10 caracteres.' },
              { nombre: 'Equipo',     obligatorio: true,  detalle: 'se elige del maestro. Acá se toma el tipo de equipamiento.' },
              { nombre: 'Activo',     obligatorio: false, detalle: 'casilla. Viene marcada al crear.' },
          ] },
        { titulo: 'Si el equipo es RI o RD', icono: 'bolt', descripcion: 'Datos de la fuente y del tubo.',
          campos: [
              { nombre: 'Fuente',   obligatorio: false, detalle: 'interno de fuente que usa este equipo.' },
              { nombre: 'Foco',     obligatorio: false, detalle: 'tamaño del foco.' },
              { nombre: 'Voltaje',  obligatorio: false, detalle: 'valor de trabajo.' },
              { nombre: 'Amperaje', obligatorio: false, detalle: 'valor de trabajo.' },
          ] },
        { titulo: 'Si el equipo es DZ', icono: 'cube', descripcion: 'Datos de calibración de dureza.',
          campos: [
              { nombre: 'Probeta',               obligatorio: true, detalle: 'hasta 15 caracteres.' },
              { nombre: 'Dureza de calibración', obligatorio: true, detalle: 'hasta 5 caracteres.' },
          ] },
    ],

    demo: 'ayuda-demo-interno-equipos',

    botones: [
        { label: 'Nuevo',                icono: 'plus-circle', estilo: '',     descripcion: 'Abre el formulario de alta del interno.' },
        { label: 'Historial de fuentes', icono: 'table',       estilo: '',     descripcion: 'Ícono de grilla en cada fila: muestra las fuentes que tuvo y las fechas de alta y baja.' },
        { label: 'Editar',               icono: 'edit',        estilo: '',     descripcion: 'Abre el formulario con los datos del interno.' },
        { label: 'Eliminar',             icono: 'trash',       estilo: 'rojo', descripcion: 'Quita el interno cuando no tiene registros asociados.' },
        { label: 'Mostrar activos',      icono: 'check-square-o', estilo: 'gris', descripcion: 'Oculta los internos dados de baja.' },
    ],

    errores: [
        { mensaje: 'No aparece el interno que acabo de crear',
          causa: 'Está tildado Mostrar activos y el interno quedó inactivo, o la búsqueda tiene texto.',
          solucion: 'Destildá Mostrar activos y limpiá el buscador.' },
        { mensaje: 'El equipo no aparece en el selector del interno',
          causa: 'El equipo no está cargado en el maestro.',
          solucion: 'Cargalo primero en Equipos.' },
        { mensaje: 'Pide probeta y dureza y no sé qué poner',
          causa: 'El equipo tiene DZ entre sus métodos.',
          solucion: 'Cargá los valores de la calibración. Son obligatorios.' },
        { mensaje: 'El interno no aparece en el informe',
          causa: 'Está inactivo, o el equipo no tiene el método del informe.',
          solucion: 'Revisá Activo y los métodos del equipo. Ver "Cómo llega un equipo a un informe".' },
    ],

    secciones_extras: [
        { titulo: 'Activo, inactivo y fecha de baja', componente: 'ayuda-interno-baja' },
    ],

    relacionados: [
        { titulo: 'Gestionar equipos',                 ruta: '/ayuda_gestion_equipos' },
        { titulo: 'Cómo llega un equipo a un informe', ruta: '/ayuda_equipo_en_informe' },
        { titulo: 'Gestionar internos de fuente',      ruta: '/ayuda_gestion_interno_fuente' },
    ],
};
