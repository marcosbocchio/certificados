export default {
    hero: {
        titulo: 'Visualizar vehículos y documentación complementaria',
        descripcion:
            'Versión solo lectura de la pantalla de vehículos. Ves los vehículos vinculados a la OT, la documentación de cada vehículo ' +
            '(VTV, seguro, etc.) y las documentaciones complementarias sumadas al trabajo.',
    },

    ir_a: {
        label: 'Ir a la OT',
        ruta: '/area/enod/ots',
        icono: 'truck',
    },

    acciones: [
        { icono: 'eye',       titulo: 'Ver vehículos asignados',         detalle: 'Tabla con N° interno, marca, modelo, patente y tipo.' },
        { icono: 'file-image-o', titulo: 'Ver documentación del vehículo',  detalle: 'VTV, seguro y otros documentos del vehículo.' },
        { icono: 'file-image-o', titulo: 'Ver documentación complementaria', detalle: 'Documentaciones extra sumadas a la OT.' },
    ],

    bloques: [
        { titulo: 'Vehículos asignados a la OT', icono: 'list', descripcion: 'Tabla con los vehículos vinculados a la OT.',
          campos: [
              { nombre: 'N° INT.', obligatorio: false, detalle: 'Número interno del vehículo.' },
              { nombre: 'Marca',   obligatorio: false, detalle: '' },
              { nombre: 'Modelo',  obligatorio: false, detalle: '' },
              { nombre: 'Patente', obligatorio: false, detalle: '' },
              { nombre: 'Tipo',    obligatorio: false, detalle: 'Camioneta, furgón, etc.' },
          ] },
        { titulo: 'Documentaciones del vehículo', icono: 'file-text-o', descripcion: 'VTV, seguro, RTO, etc. (vienen del maestro del vehículo).',
          campos: [
              { nombre: 'Título',      obligatorio: false, detalle: '' },
              { nombre: 'Descripción', obligatorio: false, detalle: '' },
              { nombre: 'Archivo',     obligatorio: false, detalle: 'Click en el ícono para abrir.' },
          ] },
        { titulo: 'Documentaciones asignadas a la OT', icono: 'folder-o', descripcion: 'Documentaciones complementarias sumadas manualmente.',
          campos: [
              { nombre: 'Título',      obligatorio: false, detalle: '' },
              { nombre: 'Descripción', obligatorio: false, detalle: '' },
              { nombre: 'Archivo',     obligatorio: false, detalle: 'Click para abrir.' },
          ] },
    ],

    errores: [
        { mensaje: 'No veo vehículos asignados',
          causa: 'Nadie asignó vehículos a la OT todavía.',
          solucion: 'Un usuario con permiso "Asignar vehículos" tiene que sumarlos.' },
        { mensaje: 'Falta documentación de un vehículo',
          causa: 'El vehículo no tiene VTV / seguro cargados en su maestro.',
          solucion: 'Se cargan desde "Gestionar vehículos" en el maestro.' },
    ],

    relacionados: [
        { titulo: 'Asignar vehículos y documentación complementaria', ruta: '/asignar_vehiculos' },
        { titulo: 'Visualización general de una OT',                   ruta: '/visualizar_ot' },
    ],

    demo: 'ayuda-demo-visualizar-vehiculos',
};
