export default {
    hero: {
        titulo: 'Visualización general de una OT',
        descripcion:
            'Al entrar a una Orden de Trabajo, ves el tablero principal con 8 secciones (cards). Cada card es una pantalla del flujo: ' +
            'operadores, equipos, procedimientos, vehículos / documentación, soldadores / usuarios cliente, informes, partes y certificados.',
    },

    ir_a: {
        label: 'Ir al listado de OT',
        ruta: '/area/enod/ots',
        icono: 'clipboard',
    },

    acciones: [
        { icono: 'th-large',     titulo: 'Ver las 8 secciones de la OT',  detalle: 'Cada card lleva a la pantalla correspondiente.' },
        { icono: 'hashtag',      titulo: 'Ver cuántos elementos hay cargados', detalle: 'El número arriba a la derecha de cada card indica la cantidad.' },
        { icono: 'plus-circle',  titulo: 'Crear una OT nueva',             detalle: 'Botón "+ Nueva OT" abajo a la izquierda.' },
        { icono: 'search',       titulo: 'Buscar una OT',                   detalle: 'Buscador abajo a la derecha. Filtra por número, cliente, proyecto o estado.' },
    ],

    bloques: [
        { titulo: 'Operadores',          icono: 'users',          descripcion: 'Operadores y ayudantes asignados a la OT.',                          campos: [] },
        { titulo: 'Equipos',             icono: 'cogs',            descripcion: 'Equipos internos (RX, palpadores, etc.) que van a usarse.',          campos: [] },
        { titulo: 'Procedimientos',      icono: 'shield',          descripcion: 'Procedimientos Enod y del cliente vinculados.',                       campos: [] },
        { titulo: 'Vehículos | Doc.',    icono: 'truck',           descripcion: 'Vehículos asignados y documentación complementaria.',                campos: [] },
        { titulo: 'Cuños | Usuarios',    icono: 'fire',            descripcion: 'Soldadores del cliente y usuarios que pueden acceder a la OT.',      campos: [] },
        { titulo: 'Informes',            icono: 'file-text',       descripcion: 'Informes técnicos cargados (RI, PM, LP, US, etc.).',                  campos: [] },
        { titulo: 'Partes',              icono: 'calendar-check-o',descripcion: 'Partes diarios consolidados.',                                         campos: [] },
        { titulo: 'Certificados',        icono: 'certificate',     descripcion: 'Certificados emitidos.',                                               campos: [] },
    ],

    botones: [
        { label: '+ Nueva OT', icono: 'plus',   estilo: '', descripcion: 'Abre el formulario en blanco para crear una OT.' },
        { label: 'Buscar',     icono: 'search', estilo: '', descripcion: 'Filtra el listado por número, cliente, proyecto o estado.' },
    ],

    errores: [
        { mensaje: 'No veo la OT que busco',
          causa: 'Tu usuario puede tener visibilidad limitada (cliente externo ve solo sus OT).',
          solucion: 'Si sos cliente, pedile a tu administrador que te asigne la OT desde "Soldadores y usuarios cliente".' },
        { mensaje: 'Las cards están en gris claro',
          causa: 'No tenés permiso para entrar a esa sección.',
          solucion: 'Pedile a sistemas que te active el permiso correspondiente.' },
    ],

    relacionados: [
        { titulo: 'Cómo crear una OT',                                ruta: '/crear_ot' },
        { titulo: 'Asignar operadores',                                ruta: '/asignar_operadores' },
        { titulo: 'Asignar soldadores y usuarios de cliente',          ruta: '/asignar_soldadores_y_usuarios' },
        { titulo: 'Asignar procedimientos',                            ruta: '/asignar_procedimientos' },
        { titulo: 'Asignar vehículos y documentación complementaria',  ruta: '/asignar_vehiculos' },
        { titulo: 'Visualizar documentación de operadores',            ruta: '/visualizar_documentacion_operadores' },
        { titulo: 'Visualizar procedimientos asignados',                ruta: '/visualizar_procedimientos' },
        { titulo: 'Visualizar vehículos y documentación complementaria', ruta: '/visualizar_vehiculos' },
    ],

    demo: 'ayuda-demo-tablero-ot',
};
