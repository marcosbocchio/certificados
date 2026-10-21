export default {
    hero: {
        titulo: 'Cómo llega un equipo a un informe',
        descripcion:
            'El recorrido completo: qué se carga en los maestros, qué ve quien arma el informe y qué sale en el PDF. ' +
            'Sirve para entender por qué un equipo aparece, o no, en cada informe.',
    },

    ir_a: {
        label: 'Ir al listado de OT',
        ruta: '/area/enod/ots',
        icono: 'file-text-o',
    },

    secciones_destacadas: [
        { titulo: 'El recorrido, de punta a punta',  componente: 'ayuda-equipo-recorrido' },
        { titulo: 'Qué equipos ofrece cada informe', componente: 'ayuda-equipo-condiciones' },
    ],

    demo: 'ayuda-demo-equipo-informe',

    errores: [
        { mensaje: 'No aparece el interno que busco',
          causa: 'Está inactivo (fila roja en Internos de equipos).',
          solucion: 'Marcá Activo en Internos de equipos.' },
        { mensaje: 'Aparece el equipo en RI pero no en RD',
          causa: 'El equipo no tiene RD entre sus métodos.',
          solucion: 'Se agrega editando el equipo en Maestros > Equipos.' },
        { mensaje: 'Es un palpador, una lámpara o un luxómetro',
          causa: 'Estos no salen en el selector de equipo común.',
          solucion: 'Buscalos en el selector de palpador (US) o de instrumento (PM, LP).' },
        { mensaje: 'Cargué el equipo pero no tiene interno',
          causa: 'El informe trabaja con internos.',
          solucion: 'Creá uno en Internos de equipos.' },
    ],

    relacionados: [
        { titulo: 'Gestionar equipos',            ruta: '/ayuda_gestion_equipos' },
        { titulo: 'Gestionar internos de equipos', ruta: '/ayuda_gestion_interno_equipos' },
        { titulo: 'Creación de informes',         ruta: '/generar_informes' },
    ],
};
