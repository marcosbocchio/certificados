export default {
    hero: {
        titulo: 'Dar acceso a un usuario, paso a paso',
        descripcion:
            'Cómo dejar a una persona lista para trabajar: crear su usuario, elegir sus roles y asignarla a las OTs que le corresponden.',
    },

    ir_a: {
        label: 'Ir a Usuarios',
        ruta: '/area/enod/usuarios',
        icono: 'users',
        permiso: 'M_usuarios',
    },

    secciones_destacadas: [
        {
            permiso: ['M_usuarios_edita', 'M_usuarios'],
            titulo: 'Antes de empezar: ¿personal de la empresa o de un cliente?',
            componente: 'ayuda-guia-matriz',
            props: {
                columnas: ['Opción en el formulario', 'Para quién es', 'Qué ve'],
                filas: [
                    ['Enod', 'Personal de la empresa', 'Las OTs donde está asignado, o todas si tiene el rol Ve-todas-las-OT.'],
                    ['Cliente', 'Personas de una empresa cliente', 'Solo las OTs donde se lo asignó como usuario del cliente.'],
                ],
                callouts: [
                    { tipo: 'warning', titulo: 'Elegí bien desde el principio',
                      texto: 'Un usuario de cliente no puede ver todas las OTs aunque tenga roles de más. Si necesita acceso interno, creale un usuario de personal.' },
                ],
            },
        },
        {
            permiso: 'M_usuarios_edita',
            titulo: 'Los pasos, en orden',
            componente: 'ayuda-guia-pasos',
            props: {
                pasos: [
                    { titulo: 'Entrá a Usuarios y tocá Nuevo.', detalle: 'Antes buscá por nombre: si ya existe, editalo en lugar de crear otro.' },
                    { titulo: 'Elegí Enod o Cliente.', detalle: 'Si es Cliente, elegí también a qué cliente pertenece.' },
                    { titulo: 'Completá los datos.', detalle: 'Nombre, correo y clave. El correo es con el que va a ingresar.' },
                    { titulo: 'Tildá sus roles.', detalle: 'Elegí lo que necesita para trabajar. Si la persona tiene que ver todas las OTs, tildá también Ve-todas-las-OT.' },
                    { titulo: 'Guardá.', detalle: 'El usuario queda creado, pero todavía no ve ninguna OT si no tiene Ve-todas-las-OT.' },
                    { titulo: 'Asignalo a sus OTs.', detalle: 'Abrí cada OT, entrá a Operadores y agregalo como operador o ayudante. Confirmá con Actualizar.' },
                    { titulo: 'Verificá con la persona.', detalle: 'Pedile que cierre sesión y vuelva a entrar. Tiene que ver sus OTs y poder abrir las secciones que necesita.' },
                ],
            },
        },
        {
            permiso: 'M_usuarios_edita',
            titulo: 'Combinaciones de roles más comunes',
            componente: 'ayuda-guia-matriz',
            props: {
                columnas: ['Roles del usuario', 'Qué pasa'],
                filas: [
                    ['Operador + Visualiza OT', 'Ve y abre las OTs donde está asignado y trabaja con lo que Operador le permite.'],
                    ['Operador sin Visualiza OT', 'Ve sus OTs en el tablero, pero los cuadros quedan deshabilitados y no puede entrar a las secciones.'],
                    ['Visualiza OT + Ve-todas-las-OT', 'Consulta todas las OTs. Qué puede modificar lo define el resto de sus roles.'],
                    ['Solo Ve-todas-las-OT', 'Ve el listado completo, pero no puede abrir las secciones. Necesita sumar un rol como Visualiza OT.'],
                ],
                callouts: [
                    { tipo: 'tip', titulo: 'Para el seguimiento general',
                      texto: 'Si alguien solo necesita mirar todas las OTs, dale Visualiza OT + Ve-todas-las-OT y nada más.' },
                ],
            },
        },
        {
            permiso: ['M_usuarios_edita', 'T_operador_actualiza'],
            titulo: 'Asignar o quitar a una persona en una OT',
            componente: 'ayuda-guia-pasos',
            props: {
                pasos: [
                    { titulo: 'Entrá a la OT y abrí Operadores.' },
                    { titulo: 'Elegí a la persona y agregala como operador o ayudante.', detalle: 'Para la OT cuenta igual una u otra figura.' },
                    { titulo: 'Tocá Actualizar para confirmar.', detalle: 'Desde ese momento la persona ve la OT.' },
                ],
                callouts: [
                    { tipo: 'warning', titulo: 'Para asignar a alguien tenés que poder ver esa OT',
                      texto: 'Si nadie con acceso puede hacerlo, pedile a una persona con el rol Ve-todas-las-OT que la asigne.' },
                    { tipo: 'warning', titulo: 'Cuidado al quitarte a vos mismo',
                      texto: 'Si te sacás de una OT dejás de verla. Antes de quitarte, asegurate de que otra persona pueda volver a asignarte.' },
                ],
            },
        },
    ],

    errores: [
        { permiso: 'M_usuarios_edita',
          mensaje: 'Creé el usuario, entra, pero no ve ninguna OT',
          causa: 'No está asignado a ninguna OT y no tiene el rol Ve-todas-las-OT.',
          solucion: 'Asignalo desde Operadores en cada OT, o tildá Ve-todas-las-OT si corresponde.' },
        { permiso: 'M_usuarios_edita',
          mensaje: 'Cambié sus roles y no ve la diferencia',
          causa: 'La sesión abierta todavía muestra lo anterior.',
          solucion: 'Pedile que cierre sesión y vuelva a entrar, o que recargue la pantalla.' },
        { permiso: 'M_usuarios_edita',
          mensaje: 'Un usuario de cliente no ve su OT',
          causa: 'No fue asignado como usuario del cliente en esa OT.',
          solucion: 'En la OT, entrá a Soldadores y usuarios y agregalo.' },
    ],

    relacionados: [
        { titulo: 'Gestionar roles',                         ruta: '/ayuda_gestionar_roles' },
        { titulo: 'Un usuario no ve una OT o una sección', ruta: '/ayuda_guia_no_veo' },
        { titulo: 'Asignar operadores',                    ruta: '/asignar_operadores', permiso: 'T_operador_acceder' },
    ],
};
