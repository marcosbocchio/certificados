export default {
    hero: {
        titulo: 'Visualizar documentación de operadores',
        descripcion:
            'Versión solo lectura de la pantalla de operadores. Ves quiénes están asignados como operadores y como ayudantes, ' +
            'y la documentación de cada uno (certificaciones, ART, capacitaciones, etc.).',
    },

    ir_a: {
        label: 'Ir a la OT',
        ruta: '/area/enod/ots',
        icono: 'users',
    },

    acciones: [
        { icono: 'eye',       titulo: 'Ver operadores asignados', detalle: 'Listado de operadores activos en la OT.' },
        { icono: 'eye',       titulo: 'Ver ayudantes asignados',  detalle: 'Quiénes asisten en el trabajo.' },
        { icono: 'file-pdf-o', titulo: 'Descargar documentación',  detalle: 'Click en el ícono de PDF para abrir o bajar el archivo.' },
    ],

    bloques: [
        { titulo: 'Operadores asignados',  icono: 'list', descripcion: 'Tabla con los nombres de los operadores activos.',
          campos: [{ nombre: 'Nombre', obligatorio: false, detalle: 'Como vino del maestro de usuarios.' }] },
        { titulo: 'Ayudantes asignados',   icono: 'list', descripcion: 'Tabla con los nombres de los ayudantes.',
          campos: [{ nombre: 'Nombre', obligatorio: false, detalle: '' }] },
        { titulo: 'Documentación',         icono: 'file-text-o', descripcion: 'Documentos asociados a los operadores y ayudantes asignados.',
          campos: [
              { nombre: 'Título', obligatorio: false, detalle: 'Nombre del documento.' },
              { nombre: 'Descripción', obligatorio: false, detalle: 'Detalle breve.' },
              { nombre: 'PDF', obligatorio: false, detalle: 'Click para abrir o descargar.' },
          ] },
    ],

    errores: [
        { mensaje: 'No veo documentación para un operador',
          causa: 'El operador no tiene documentos cargados en el maestro de usuarios.',
          solucion: 'Pedile a sistemas o al admin que cargue los documentos del operador.' },
        { mensaje: 'La lista de operadores está vacía',
          causa: 'No hay operadores asignados a esta OT.',
          solucion: 'Un usuario con permiso de "Asignar operadores" tiene que asignarlos primero.' },
    ],

    relacionados: [
        { titulo: 'Asignar operadores a la OT', ruta: '/asignar_operadores' },
        { titulo: 'Visualización general de una OT', ruta: '/visualizar_ot' },
    ],

    demo: 'ayuda-demo-visualizar-operadores',
};
