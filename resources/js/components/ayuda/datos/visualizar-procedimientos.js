export default {
    hero: {
        titulo: 'Visualizar procedimientos asignados',
        descripcion:
            'Versión solo lectura de la pantalla de procedimientos. Ves los procedimientos Enod (internos) y los del cliente ' +
            '(EPS/WPS, PQR y Procedimiento de reparación) que están vinculados a la OT.',
    },

    ir_a: {
        label: 'Ir a la OT',
        ruta: '/area/enod/ots',
        icono: 'shield',
    },

    acciones: [
        { icono: 'eye',        titulo: 'Ver procedimientos Enod',     detalle: 'Tabla con tipo, título, descripción y método.' },
        { icono: 'file-pdf-o', titulo: 'Descargar PDF del procedimiento Enod', detalle: 'Click en el ícono de PDF en la fila.' },
        { icono: 'eye',        titulo: 'Ver procedimientos del cliente', detalle: 'EPS/WPS, PQR y Procedimiento de reparación cargados para la OT.' },
    ],

    bloques: [
        { titulo: 'Procedimientos Enod',     icono: 'book',      descripcion: 'Procedimientos internos vinculados a la OT.',
          campos: [
              { nombre: 'Tipo',        obligatorio: false, detalle: 'Tipo de documento.' },
              { nombre: 'Título',      obligatorio: false, detalle: '' },
              { nombre: 'Descripción', obligatorio: false, detalle: '' },
              { nombre: 'Método',      obligatorio: false, detalle: 'RI, PM, LP, US, etc.' },
              { nombre: 'PDF',         obligatorio: false, detalle: 'Click para descargar.' },
          ] },
        { titulo: 'Procedimientos clientes', icono: 'file-text', descripcion: 'Procedimientos del cliente cargados para la OT.',
          campos: [
              { nombre: 'Tipo Sol.',         obligatorio: false, detalle: 'Tipo de soldadura.' },
              { nombre: 'Obra N°',           obligatorio: false, detalle: 'Número de la OT.' },
              { nombre: 'EPS / WPS',         obligatorio: false, detalle: 'Especificación de procedimiento del cliente.' },
              { nombre: 'PQR',               obligatorio: false, detalle: 'Record de calificación.' },
              { nombre: 'Proc. Reparación',  obligatorio: false, detalle: 'Procedimiento que aplica a soldaduras de reparación.' },
          ] },
    ],

    errores: [
        { mensaje: 'No tengo procedimientos Enod cargados',
          causa: 'No se vincularon procedimientos internos a esta OT.',
          solucion: 'Pedile a un usuario con permiso "Asignar procedimientos" que los cargue.' },
        { mensaje: 'Faltan datos en procedimientos cliente',
          causa: 'No se completaron EPS/WPS, PQR o Procedimiento de reparación al asignar.',
          solucion: 'Se completan en la pantalla "Asignar procedimientos".' },
    ],

    relacionados: [
        { titulo: 'Asignar procedimientos',           ruta: '/asignar_procedimientos' },
        { titulo: 'Visualización general de una OT',  ruta: '/visualizar_ot' },
    ],

    demo: 'ayuda-demo-visualizar-procedimientos',
};
