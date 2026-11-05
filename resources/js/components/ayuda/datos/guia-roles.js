const ADMIN = ['M_roles_edita', 'M_usuarios_edita'];

export default {
    hero: {
        titulo: 'Guía de roles y accesos',
        descripcion:
            'Cómo se decide qué puede hacer cada persona y en qué órdenes de trabajo. ' +
            'Si alguien no ve una OT o una sección, la respuesta casi siempre está acá.',
    },

    ir_a: {
        label: 'Ir a Roles',
        ruta: '/area/enod/roles',
        icono: 'key',
        permiso: 'M_roles',
    },

    secciones_destacadas: [
        {
            titulo: 'Dos cosas definen lo que ve cada persona',
            componente: 'ayuda-guia-pasos',
            props: {
                intro: 'Para trabajar en una OT tienen que cumplirse las dos. Si falta una, la persona no ve la OT o no puede abrir la sección.',
                pasos: [
                    { titulo: 'Qué puede hacer: lo definen los roles.',
                      detalle: 'Un rol agrupa las pantallas y acciones habilitadas: ver informes, cargar partes, editar una OT, etc.' },
                    { titulo: 'En qué OTs puede hacerlo: lo define la asignación.',
                      detalle: 'La persona tiene que figurar como operador o ayudante de la OT, o tener el rol Ve-todas-las-OT.' },
                ],
                callouts: [
                    { tipo: 'info', titulo: 'Un ejemplo',
                      texto: 'Marta tiene el rol Operador pero no está asignada a la OT 125. No la ve, aunque otra persona con el mismo rol sí. ' +
                             'Si la asignan a la OT, la ve y trabaja con lo que su rol le permite.' },
                ],
            },
        },
        {
            titulo: 'Quién ve qué',
            componente: 'ayuda-guia-matriz',
            props: {
                columnas: ['Usuario', 'Qué OTs ve', 'Para tener en cuenta'],
                filas: [
                    ['Personal con el rol Ve-todas-las-OT', 'Todas', 'Dalo solo a quien necesita el seguimiento general de las OTs.'],
                    ['Personal asignado a una o más OTs', 'Solo esas OTs', 'Cuenta igual figurar como operador que como ayudante.'],
                    ['Personal sin OTs asignadas', 'Ninguna', 'Ve el tablero sin órdenes y un aviso al tocar un cuadro.'],
                    ['Usuario de un cliente', 'Solo las OTs donde se lo asignó como usuario del cliente', 'El rol Ve-todas-las-OT no le agrega nada.'],
                    ['Usuario con rol Sistemas', 'Todas', 'No necesita asignación.'],
                ],
                callouts: [
                    { tipo: 'tip', titulo: 'Al crear una OT',
                      texto: 'Quien la crea y el responsable de la OT quedan asignados solos, así que la ven aunque no tengan el rol Ve-todas-las-OT.' },
                ],
            },
        },
        {
            permiso: ADMIN,
            titulo: 'El rol Ve-todas-las-OT: cómo usarlo bien',
            componente: 'ayuda-guia-pasos',
            props: {
                intro: 'Es un rol aparte, pensado para sumarlo a una persona puntual desde su ficha en Usuarios.',
                pasos: [
                    { titulo: 'Dalo persona por persona.', detalle: 'Se tilda en la lista de Roles del usuario, junto a los demás roles.' },
                    { titulo: 'Combinalo con un rol que habilite las secciones.', detalle: 'Por sí solo permite ver el listado completo, pero no abrir informes, partes ni certificados. Para eso hace falta un rol como Visualiza OT.' },
                    { titulo: 'No lo sumes dentro de roles generales.', detalle: 'Si lo agregás a un rol como Operador, todos los que tengan ese rol pasan a ver todas las OTs.' },
                ],
                callouts: [
                    { tipo: 'warning', titulo: 'Un error común',
                      texto: 'Marcar el permiso de ver todas las OTs al armar un rol amplio. El cambio alcanza a todas las personas que tienen ese rol.' },
                ],
            },
        },
        {
            permiso: 'M_roles_edita',
            titulo: 'Crear o modificar un rol',
            componente: 'ayuda-guia-pasos',
            props: {
                pasos: [
                    { titulo: 'Entrá a Configuración > Roles.', detalle: 'Mirá primero la lista: puede que ya exista uno igual.' },
                    { titulo: 'Tocá Nuevo y poné un nombre claro.', detalle: 'Que se entienda el puesto o la función, por ejemplo "Supervisor de obra".' },
                    { titulo: 'Marcá solo lo que esa función necesita.', detalle: 'Mejor pocos permisos bien elegidos que muchos por las dudas.' },
                    { titulo: 'Guardá y avisá a las personas afectadas.', detalle: 'Si es un rol que ya se usa, el cambio le llega a todos los que lo tienen. Pueden necesitar recargar la pantalla.' },
                ],
                callouts: [
                    { tipo: 'warning', titulo: 'Antes de editar un rol que ya se usa',
                      texto: 'Quitar un permiso le saca esa función a todas las personas que tienen el rol. Si es para un caso puntual, creá un rol nuevo.' },
                ],
            },
        },
    ],

    relacionados: [
        { titulo: 'Dar acceso a un usuario, paso a paso', ruta: '/ayuda_guia_acceso_usuario', permiso: ['M_usuarios_edita', 'M_usuarios', 'M_roles_edita'] },
        { titulo: 'Un usuario no ve una OT o una sección', ruta: '/ayuda_guia_no_veo' },
        { titulo: 'Gestionar roles',                       ruta: '/ayuda_gestionar_roles', permiso: ['M_roles', 'M_roles_edita'] },
        { titulo: 'Gestionar usuarios',                    ruta: '/gestionar_usuarios',    permiso: ['M_usuarios', 'M_usuarios_edita'] },
    ],
};
