export default {
    hero: {
        titulo: 'Asignar a la Orden de Trabajo',
        descripcion:
            'Definí quiénes y qué van a intervenir en la OT: operadores, soldadores, vehículos y procedimientos. ' +
            'Estas asignaciones después aparecen en informes, partes y certificados.',
    },

    variantes: [
        { id: 'operador',       label: 'Operadores',     hero: { titulo: 'Asignar operadores y ayudantes a la OT', descripcion: 'Definí quiénes ejecutan el ensayo y quiénes asisten. Los operadores asignados van a aparecer después como responsables en informes y partes.' } },
        { id: 'soldador',       label: 'Soldadores',     hero: { titulo: 'Asignar soldadores y usuarios cliente',   descripcion: 'Indicá qué soldadores del cliente pueden aparecer en pasadas RI y qué usuarios del cliente acceden a la documentación de la OT.' } },
        { id: 'vehiculo',       label: 'Vehículos',      hero: { titulo: 'Asignar vehículos y documentación',         descripcion: 'Vinculá a la OT los vehículos que van a intervenir y la documentación complementaria que querés dejar disponible para el cliente.' } },
        { id: 'procedimiento',  label: 'Procedimientos', hero: { titulo: 'Asignar procedimientos a la OT',            descripcion: 'Vinculá los procedimientos de Enod y los del cliente (EPS/WPS, PQR, Procedimiento de reparación).' } },
    ],

    ir_a: {
        label: 'Ir a las asignaciones de la OT',
        ruta: '/area/enod/ots',
        icono: 'users',
    },

    /* ---------------- ACCIONES ---------------- */
    acciones: {
        operador: [
            { icono: 'plus-circle',  titulo: 'Agregar un operador',  detalle: 'Elegís uno de la lista y tocás +.' },
            { icono: 'plus-circle',  titulo: 'Agregar un ayudante',  detalle: 'Misma lista que operador, separados por rol.' },
            { icono: 'minus-circle', titulo: 'Quitar un asignado',   detalle: 'Tocás el botón − al lado del nombre.' },
            { icono: 'save',         titulo: 'Confirmar los cambios', detalle: 'El botón "Actualizar" graba la asignación.' },
        ],
        soldador: [
            { icono: 'plus-circle',  titulo: 'Agregar un soldador',         detalle: 'Solo aparecen los soldadores cargados para el cliente de la OT.' },
            { icono: 'plus-circle',  titulo: 'Agregar un usuario cliente',  detalle: 'Para que el cliente pueda ver los documentos de la OT desde su login.' },
            { icono: 'minus-circle', titulo: 'Quitar uno asignado',          detalle: 'Tocás el − al lado de la fila.' },
            { icono: 'save',         titulo: 'Confirmar los cambios',        detalle: 'El botón "Actualizar" graba.' },
        ],
        vehiculo: [
            { icono: 'plus-circle',  titulo: 'Agregar un vehículo',          detalle: 'Lo elegís del maestro de vehículos.' },
            { icono: 'file-text',    titulo: 'Ver documentación del vehículo', detalle: 'VTV, seguro y otros documentos del vehículo aparecen solos al asignarlo.' },
            { icono: 'plus-circle',  titulo: 'Agregar documentación extra',  detalle: 'Otras documentaciones complementarias que querés sumar.' },
            { icono: 'save',         titulo: 'Actualizar',                   detalle: 'Graba los cambios.' },
        ],
        procedimiento: [
            { icono: 'plus',         titulo: 'Crear procedimiento Enod (Nuevo)', detalle: 'Abre el formulario para subir un procedimiento interno con PDF.' },
            { icono: 'plus-circle',  titulo: 'Cargar procedimiento del cliente', detalle: 'Inline: EPS/WPS, PQR y Procedimiento de reparación (los tres obligatorios).' },
            { icono: 'minus-circle', titulo: 'Quitar un procedimiento cliente', detalle: 'Tocás el − en la fila.' },
            { icono: 'save',         titulo: 'Actualizar',                       detalle: 'Graba los cambios.' },
        ],
    },

    /* ---------------- BLOQUES (campos que se ven en pantalla) ---------------- */
    bloques: {
        operador: [
            { titulo: 'Operador',  icono: 'user',     descripcion: 'Lista de usuarios internos. Elegís uno y tocás +.',
              campos: [{ nombre: 'Operador (lista)', obligatorio: false, detalle: 'Usuarios internos de Enod habilitados.' },
                       { nombre: '+ (agregar)',     obligatorio: false, detalle: 'Suma al operador a la tabla "Operadores asignados".' }] },
            { titulo: 'Ayudante',  icono: 'user-plus', descripcion: 'Misma lista, queda registrado como ayudante (no como responsable de ensayo).',
              campos: [{ nombre: 'Ayudante (lista)', obligatorio: false, detalle: 'Mismo maestro de usuarios.' },
                       { nombre: '+ (agregar)',      obligatorio: false, detalle: 'Suma al ayudante a la tabla "Ayudantes asignados".' }] },
            { titulo: 'Operadores asignados', icono: 'list', descripcion: 'Tabla con los operadores ya cargados. El − los quita.',
              campos: [{ nombre: 'Nombre', obligatorio: false, detalle: 'Como vino del maestro de usuarios.' },
                       { nombre: '− (quitar)', obligatorio: false, detalle: '' }] },
            { titulo: 'Ayudantes asignados', icono: 'list', descripcion: 'Tabla con los ayudantes ya cargados.',
              campos: [{ nombre: 'Nombre', obligatorio: false, detalle: '' },
                       { nombre: '− (quitar)', obligatorio: false, detalle: '' }] },
            { titulo: 'Documentación', icono: 'file-text-o', descripcion: 'Después de tocar Actualizar, aparece la documentación de cada operador asignado.',
              campos: [{ nombre: 'Título', obligatorio: false, detalle: '' },
                       { nombre: 'Descripción', obligatorio: false, detalle: '' },
                       { nombre: 'PDF', obligatorio: false, detalle: 'Click para abrir o descargar.' }] },
        ],
        soldador: [
            { titulo: 'Soldadores', icono: 'fire', descripcion: 'Lista filtrada por cliente de la OT. Si está vacía, hay que cargar soldadores para ese cliente.',
              campos: [{ nombre: 'Soldadores (lista)', obligatorio: false, detalle: 'Maestro de soldadores filtrado por el cliente de la OT.' },
                       { nombre: '+ (agregar)', obligatorio: false, detalle: 'Suma a la tabla "Soldadores Asignados".' }] },
            { titulo: 'Soldadores Asignados Orden de Trabajo', icono: 'list', descripcion: 'Tabla con los soldadores ya cargados. Aparecen después en pasadas RI.',
              campos: [{ nombre: 'CODIGO', obligatorio: false, detalle: 'Código del soldador.' },
                       { nombre: 'NOMBRE', obligatorio: false, detalle: '' },
                       { nombre: '− (quitar)', obligatorio: false, detalle: '' }] },
            { titulo: 'Usuarios Cliente', icono: 'users', descripcion: 'Lista de usuarios pertenecientes al cliente de la OT.',
              campos: [{ nombre: 'Usuarios Cliente (lista)', obligatorio: false, detalle: 'Usuarios externos del cliente.' },
                       { nombre: '+ (agregar)', obligatorio: false, detalle: '' }] },
            { titulo: 'Usuarios del Cliente Asignados Orden de Trabajo', icono: 'list', descripcion: 'Quiénes del lado del cliente pueden ver los documentos de la OT.',
              campos: [{ nombre: 'NOMBRE', obligatorio: false, detalle: '' },
                       { nombre: 'EMAIL', obligatorio: false, detalle: '' },
                       { nombre: '− (quitar)', obligatorio: false, detalle: '' }] },
        ],
        vehiculo: [
            { titulo: 'Vehículos', icono: 'truck', descripcion: 'Lista del maestro de vehículos habilitados.',
              campos: [{ nombre: 'Vehículos (lista)', obligatorio: false, detalle: 'N° interno + marca + patente.' },
                       { nombre: '+ (agregar)', obligatorio: false, detalle: '' }] },
            { titulo: 'Vehículos asignados a la orden de trabajo', icono: 'list', descripcion: 'Tabla con los vehículos ya cargados.',
              campos: [{ nombre: 'N° INT.', obligatorio: false, detalle: 'Número interno del vehículo.' },
                       { nombre: 'Marca', obligatorio: false, detalle: '' },
                       { nombre: 'Modelo', obligatorio: false, detalle: '' },
                       { nombre: 'Patente', obligatorio: false, detalle: '' },
                       { nombre: 'Tipo', obligatorio: false, detalle: 'Camioneta, furgón, etc.' },
                       { nombre: '− (quitar)', obligatorio: false, detalle: '' }] },
            { titulo: 'Documentaciones del vehículo', icono: 'file-text-o', descripcion: 'Aparece automáticamente al asignar el vehículo (VTV, seguro, etc.).',
              campos: [{ nombre: 'TÍTULO', obligatorio: false, detalle: '' },
                       { nombre: 'DESCRIPCIÓN', obligatorio: false, detalle: '' },
                       { nombre: 'Archivo', obligatorio: false, detalle: 'Click en el icono para abrir.' }] },
            { titulo: 'Documentaciones', icono: 'folder-o', descripcion: 'Lista del maestro de documentaciones para sumar manualmente.',
              campos: [{ nombre: 'Documentaciones (lista)', obligatorio: false, detalle: '' },
                       { nombre: '+ (agregar)', obligatorio: false, detalle: '' }] },
            { titulo: 'Documentaciones asignadas a la orden de trabajo', icono: 'list', descripcion: 'Las que vos sumaste manualmente. Las verá el cliente.',
              campos: [{ nombre: 'Título', obligatorio: false, detalle: '' },
                       { nombre: 'Descripción', obligatorio: false, detalle: '' },
                       { nombre: '− (quitar)', obligatorio: false, detalle: '' }] },
        ],
        procedimiento: [
            { titulo: 'Procedimientos Enod', icono: 'book', descripcion: 'Tabla de procedimientos internos. Se cargan con el botón "Nuevo".',
              campos: [{ nombre: 'Tipo', obligatorio: false, detalle: 'Tipo de documento.' },
                       { nombre: 'Título', obligatorio: false, detalle: '' },
                       { nombre: 'Descripción', obligatorio: false, detalle: '' },
                       { nombre: 'Método', obligatorio: false, detalle: 'RI, PM, LP, US, etc.' },
                       { nombre: 'PDF', obligatorio: false, detalle: 'Click para abrir.' }] },
            { titulo: 'Procedimientos clientes', icono: 'file-text', descripcion: 'Se cargan inline directamente desde esta pantalla. Los tres campos con * son obligatorios.',
              campos: [{ nombre: 'Tipo Sol.', obligatorio: false, detalle: 'Tipo de soldadura (LR, CL, JT, etc.).' },
                       { nombre: 'Obra N°', obligatorio: false, detalle: 'Lo trae de la OT, no se edita.' },
                       { nombre: 'EPS / WPS', obligatorio: true, detalle: 'Especificación de procedimiento del cliente.' },
                       { nombre: 'PQR', obligatorio: true, detalle: 'Record de calificación.' },
                       { nombre: 'Proc. Reparación', obligatorio: true, detalle: 'Procedimiento que aplica a soldaduras de reparación.' },
                       { nombre: '+ (agregar)', obligatorio: false, detalle: 'Suma la fila a la tabla.' }] },
        ],
    },

    /* ---------------- BOTONES ---------------- */
    botones: {
        operador: [
            { label: '+',          icono: 'plus-circle',  estilo: 'gris', descripcion: 'Suma al operador o ayudante elegido a la tabla.' },
            { label: '−',          icono: 'minus-circle', estilo: 'gris', descripcion: 'Quita una fila ya asignada.' },
            { label: 'Actualizar', icono: 'save',         estilo: '',     descripcion: 'Graba todos los cambios.' },
        ],
        soldador: [
            { label: '+',          icono: 'plus-circle',  estilo: 'gris', descripcion: 'Agrega el soldador o usuario seleccionado.' },
            { label: '−',          icono: 'minus-circle', estilo: 'gris', descripcion: 'Quita una fila asignada.' },
            { label: 'Actualizar', icono: 'save',         estilo: '',     descripcion: 'Graba los cambios.' },
        ],
        vehiculo: [
            { label: '+',          icono: 'plus-circle',  estilo: 'gris', descripcion: 'Agrega un vehículo o una documentación.' },
            { label: '−',          icono: 'minus-circle', estilo: 'gris', descripcion: 'Quita la fila asignada.' },
            { label: 'Actualizar', icono: 'save',         estilo: '',     descripcion: 'Graba los cambios.' },
        ],
        procedimiento: [
            { label: 'Nuevo',      icono: 'plus',         estilo: '',     descripcion: 'Abre el formulario para crear un procedimiento Enod (con PDF).' },
            { label: '+',          icono: 'plus-circle',  estilo: 'gris', descripcion: 'Agrega el procedimiento cliente que cargaste inline.' },
            { label: '−',          icono: 'minus-circle', estilo: 'gris', descripcion: 'Quita una fila ya asignada.' },
            { label: 'Actualizar', icono: 'save',         estilo: '',     descripcion: 'Graba los cambios.' },
        ],
    },

    /* ---------------- ERRORES ---------------- */
    errores: {
        operador: [
            { mensaje: 'No aparece el operador que necesito',
              causa: 'No está dado de alta como usuario interno o está deshabilitado.',
              solucion: 'Cargalo o reactivalo desde "Gestionar usuarios".' },
            { mensaje: 'No veo la documentación del operador',
              causa: 'Recién aparece después de tocar "Actualizar".',
              solucion: 'Confirmá la asignación y refrescá la pantalla.' },
        ],
        soldador: [
            { mensaje: 'La lista de soldadores está vacía',
              causa: 'El cliente de la OT no tiene soldadores cargados.',
              solucion: 'Andá a "Gestionar soldadores" y cargá los soldadores para ese cliente.' },
            { mensaje: 'No me aparece el usuario cliente',
              causa: 'No está dado de alta como usuario del cliente.',
              solucion: 'Cargalo desde "Gestionar usuarios" eligiendo el cliente correspondiente.' },
        ],
        vehiculo: [
            { mensaje: 'No aparece el vehículo',
              causa: 'No está habilitado o no está cargado en el maestro.',
              solucion: 'Verificá en "Gestionar vehículos".' },
            { mensaje: 'Falta documentación del vehículo',
              causa: 'El vehículo no tiene VTV / seguro asociados en su maestro.',
              solucion: 'Cargá los documentos en "Gestionar vehículos" para ese vehículo.' },
        ],
        procedimiento: [
            { mensaje: 'No me deja agregar un procedimiento cliente',
              causa: 'Faltan EPS/WPS, PQR o Proc. de reparación.',
              solucion: 'Los tres campos con * son obligatorios para poder sumar la fila.' },
            { mensaje: 'No tengo procedimientos Enod cargados',
              causa: 'Nunca se cargó un procedimiento interno para esta OT.',
              solucion: 'Tocá "Nuevo" para subir el PDF y sus datos.' },
        ],
    },

    /* ---------------- DEMO POR VARIANTE ---------------- */
    demo: {
        operador:      'ayuda-demo-asignar-operadores',
        soldador:      'ayuda-demo-asignar-soldadores',
        vehiculo:      'ayuda-demo-asignar-vehiculos',
        procedimiento: 'ayuda-demo-asignar-procedimientos',
    },

    relacionados: [
        { titulo: 'Crear una OT',                             ruta: '/crear_ot' },
        { titulo: 'Gestionar usuarios',                        ruta: '/gestionar_usuarios' },
        { titulo: 'Gestionar soldadores',                      ruta: '/ayuda_gestion_soldadores' },
        { titulo: 'Gestionar vehículos',                       ruta: '/ayuda_gestion_vehiculos' },
        { titulo: 'Gestionar documentaciones',                 ruta: '/ayuda_gestion_documentaciones' },
        { titulo: 'Visualizar documentación de operadores',    ruta: '/visualizar_documentacion_operadores' },
    ],
};
