const ADMIN = ['M_roles_edita', 'M_usuarios_edita'];
const VER_ROLES = ['M_roles', 'M_roles_edita'];

export default {
    hero: {
        titulo: 'Gestionar roles',
        descripcion:
            'Los roles definen qué puede hacer cada persona en el sistema. Acá encontrás cómo se arman, qué hace cada permiso ' +
            'y cómo se combinan con la asignación a las OTs para decidir qué ve cada usuario.',
    },

    ir_a: {
        label: 'Ir a Roles',
        ruta: '/area/enod/roles',
        icono: 'key',
        permiso: 'M_roles',
    },

    acciones: [
        { icono: 'list',        titulo: 'Consultar los roles', detalle: 'La tabla muestra todos los roles que hay. Revisala antes de crear uno nuevo.' },
        { icono: 'plus-circle', titulo: 'Crear un rol',        detalle: 'Le ponés un nombre y marcás los permisos que incluye.' },
        { icono: 'edit',        titulo: 'Modificar un rol',    detalle: 'Agregás o quitás permisos. El cambio alcanza a todas las personas que tienen ese rol.' },
        { icono: 'trash',       titulo: 'Eliminar un rol',     detalle: 'Solo para roles que ya no se usan.' },
    ],

    secciones_destacadas: [
        {
            titulo: 'Cómo se relacionan permisos, roles y usuarios',
            componente: 'ayuda-guia-pasos',
            props: {
                pasos: [
                    { titulo: 'Un permiso habilita una pantalla o una acción.', detalle: 'Por ejemplo: ver los informes de una OT, o crear una OT.' },
                    { titulo: 'Un rol agrupa los permisos de una función.', detalle: 'Por ejemplo, Operador reúne lo que necesita quien carga informes y partes.' },
                    { titulo: 'Un usuario recibe uno o más roles.', detalle: 'Sus permisos son la suma de todos sus roles. Si falta una función, se resuelve sumando un rol.' },
                ],
            },
        },
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
            permiso: 'M_roles_edita',
            titulo: 'Crear o modificar un rol',
            componente: 'ayuda-guia-pasos',
            props: {
                pasos: [
                    { titulo: 'Entrá a Configuración > Roles.', detalle: 'Mirá primero la lista: puede que ya exista uno igual.' },
                    { titulo: 'Tocá Nuevo y poné un nombre claro.', detalle: 'Que se entienda el puesto o la función, por ejemplo "Supervisor de obra".' },
                    { titulo: 'Marcá solo lo que esa función necesita.', detalle: 'Mejor pocos permisos bien elegidos que muchos por las dudas. En el catálogo de abajo está lo que hace cada uno.' },
                    { titulo: 'Para cada sección de OT, pensá en el par.', detalle: 'Ver (acceder) y modificar (edita o actualiza) se marcan por separado. Quien modifica casi siempre necesita también ver.' },
                    { titulo: 'Guardá y avisá a las personas afectadas.', detalle: 'Si es un rol que ya se usa, el cambio le llega a todos los que lo tienen. Pueden necesitar cerrar sesión y volver a entrar.' },
                ],
                callouts: [
                    { tipo: 'warning', titulo: 'Antes de editar un rol que ya se usa',
                      texto: 'Quitar un permiso le saca esa función a todas las personas que tienen el rol. Si es para un caso puntual, creá un rol nuevo.' },
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
            permiso: VER_ROLES,
            titulo: 'Qué hace cada permiso',
            componente: 'ayuda-guia-permisos',
        },
    ],

    botones: [
        { label: 'Nuevo',    icono: 'plus-circle', estilo: '',     descripcion: 'Abre el formulario para crear un rol: nombre y lista de permisos.' },
        { label: 'Editar',   icono: 'edit',        estilo: '',     descripcion: 'Abre el rol para cambiar su nombre o sus permisos.' },
        { label: 'Eliminar', icono: 'trash',       estilo: 'rojo', descripcion: 'Quita el rol. Antes revisá que ninguna persona dependa de él.' },
    ],

    errores: [
        { permiso: VER_ROLES,
          mensaje: 'Los botones Nuevo, Editar y Eliminar están deshabilitados',
          causa: 'Tu usuario puede ver los roles pero no modificarlos.',
          solucion: 'Pedile a quien administra los accesos que te habilite la edición de roles.' },
        { permiso: VER_ROLES,
          mensaje: 'Cambié un rol y la persona no ve la diferencia',
          causa: 'Su sesión abierta todavía muestra lo anterior.',
          solucion: 'Que cierre sesión y vuelva a entrar.' },
        { permiso: VER_ROLES,
          mensaje: 'Una persona necesita una función puntual',
          causa: 'Ampliar un rol general le da esa función a todos los que lo tienen.',
          solucion: 'Creá un rol nuevo solo con esa función y sumáselo a esa persona.' },
        { permiso: ADMIN,
          mensaje: 'Una persona ve todas las OTs y no debería',
          causa: 'Tiene el rol Ve-todas-las-OT, o está dentro de otro rol que ella tiene.',
          solucion: 'Sacale ese rol en Usuarios. Si viene dentro de un rol general, quitalo de ese rol.' },
    ],

    impacto: [
        { modulo: 'Usuarios con el rol', efecto: 'Ganan o pierden las pantallas y acciones del rol en cuanto vuelven a entrar.', reversible: true },
        { modulo: 'Menú y tablero', efecto: 'Las opciones del menú y los cuadros del tablero aparecen o se deshabilitan según los permisos.', reversible: true },
        { modulo: 'Qué OTs se ven', efecto: 'No cambia. Eso depende de la asignación a cada OT o del rol Ve-todas-las-OT.', reversible: true },
    ],

    relacionados: [
        { titulo: 'Dar acceso a un usuario, paso a paso', ruta: '/ayuda_guia_acceso_usuario', permiso: ['M_usuarios_edita', 'M_usuarios', 'M_roles_edita'] },
        { titulo: 'Un usuario no ve una OT o una sección', ruta: '/ayuda_guia_no_veo' },
        { titulo: 'Gestionar usuarios',                    ruta: '/gestionar_usuarios', permiso: ['M_usuarios', 'M_usuarios_edita'] },
        { titulo: 'Gestionar permisos',                    ruta: '/ayuda_gestion_permisos', permiso: ['M_permisos', 'M_permisos_edita'] },
    ],
};
