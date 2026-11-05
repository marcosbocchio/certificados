export default {
    hero: {
        titulo: 'Un usuario no ve una OT o una sección',
        descripcion:
            'Revisá estos puntos en orden. La mayoría de los casos se resuelve en los primeros dos.',
    },

    ir_a: {
        label: 'Ir a Usuarios',
        ruta: '/area/enod/usuarios',
        icono: 'users',
        permiso: 'M_usuarios',
    },

    secciones_destacadas: [
        {
            titulo: 'Qué revisar, en este orden',
            componente: 'ayuda-guia-pasos',
            props: {
                pasos: [
                    { titulo: '¿Figura en la OT?', detalle: 'Abrí la OT y mirá Operadores. Si la persona no está como operador ni ayudante, no la ve.' },
                    { titulo: '¿Tiene el rol que habilita la sección?', detalle: 'En Usuarios, editá a la persona y mirá sus roles. Cada sección de la OT depende de un rol distinto.' },
                    { titulo: '¿Es personal o de un cliente?', detalle: 'Un usuario de cliente solo ve las OTs donde se lo asignó como usuario del cliente.' },
                    { titulo: '¿Tiene la sesión actualizada?', detalle: 'Si cambiaste algo hace poco, pedile que cierre sesión y vuelva a entrar.' },
                    { titulo: '¿Debería ver todas las OTs?', detalle: 'Entonces le falta el rol Ve-todas-las-OT.' },
                ],
            },
        },
    ],

    errores: [
        { mensaje: 'No ve ninguna OT en el tablero',
          causa: 'No está asignado a ninguna OT y no tiene el rol Ve-todas-las-OT.',
          solucion: 'Asignalo desde Operadores en la OT, o pedí que le den Ve-todas-las-OT si corresponde.' },
        { mensaje: 'Ve algunas OTs pero le falta una',
          causa: 'No figura como operador ni ayudante en esa OT.',
          solucion: 'Pedí que lo agreguen en Operadores de esa OT.' },
        { mensaje: 'Al tocar un cuadro aparece "No tiene órdenes de trabajo asignadas"',
          causa: 'El tablero no tiene ninguna OT seleccionada porque la persona no tiene OTs.',
          solucion: 'Igual que el primer caso: necesita que lo asignen a una OT.' },
        { mensaje: 'Aparece "No tiene acceso a esta orden de trabajo"',
          causa: 'Abrió el enlace de una OT donde no está asignado.',
          solucion: 'Pedí que lo asignen, o que entre desde el tablero por una OT propia.' },
        { mensaje: 'Los cuadros del tablero aparecen deshabilitados',
          causa: 'Su rol no habilita esa sección.',
          solucion: 'Sumale un rol que la incluya, por ejemplo Visualiza OT para consultar.' },
        { mensaje: 'Ve la OT pero no puede modificar nada',
          causa: 'Su rol permite consultar pero no editar.',
          solucion: 'Pedí que revisen sus roles. Para modificar, necesita un rol de edición.' },
        { mensaje: 'No le aparece el botón Nueva OT',
          causa: 'Su rol no incluye crear OTs.',
          solucion: 'Pedí un rol que lo permita. Quien crea una OT queda asignado solo a ella.' },
        { mensaje: 'Cambié un rol y no ve la diferencia',
          causa: 'Su sesión abierta muestra lo anterior.',
          solucion: 'Que cierre sesión y vuelva a entrar.' },
        { permiso: ['M_usuarios_edita', 'M_roles_edita'],
          mensaje: 'Una persona ve todas las OTs y no debería',
          causa: 'Tiene el rol Ve-todas-las-OT, o está dentro de otro rol que ella tiene.',
          solucion: 'Sacale ese rol en Usuarios. Si viene dentro de un rol general, quitalo de ese rol en Roles.' },
        { permiso: ['M_usuarios_edita', 'T_soldadores_actualiza'],
          mensaje: 'Un usuario de cliente no ve su OT',
          causa: 'No fue asignado como usuario del cliente en esa OT.',
          solucion: 'En la OT, entrá a Soldadores y usuarios y agregalo.' },
    ],

    relacionados: [
        { titulo: 'Guía de roles y accesos',              ruta: '/ayuda_guia_roles',          permiso: ['M_roles', 'M_roles_edita', 'M_usuarios', 'M_usuarios_edita'] },
        { titulo: 'Dar acceso a un usuario, paso a paso', ruta: '/ayuda_guia_acceso_usuario', permiso: ['M_usuarios', 'M_usuarios_edita'] },
    ],
};
