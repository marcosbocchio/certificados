export default {
    hero: {
        titulo: 'Crear una Orden de Trabajo (OT)',
        descripcion:
            'La OT es la "carpeta" del trabajo. Acá cargás cliente, comitente, lugar de ensayo, ' +
            'responsable, servicios contratados, productos, EPP y riesgos. Una vez creada, ' +
            'desde la OT vas a asignar operadores, soldadores, vehículos y procedimientos.',
    },

    ir_a: {
        label: 'Abrir el tablero de OT',
        ruta: '/area/enod',
        icono: 'clipboard',
    },

    acciones: [
        { icono: 'plus-circle', titulo: 'Crear una OT nueva',         detalle: 'Desde el botón "Nueva OT" del tablero principal.' },
        { icono: 'pencil',      titulo: 'Editar una OT en borrador',  detalle: 'Mientras esté en estado Editando, podés modificar todos los datos.' },
        { icono: 'check-circle',titulo: 'Firmar la OT',                detalle: 'La pasa a Activa. A partir de ahí ya podés cargar informes y partes.' },
        { icono: 'cogs',        titulo: 'Cargar servicios y productos', detalle: 'Definen qué métodos de ensayo van a estar disponibles después.' },
        { icono: 'archive',     titulo: 'Cerrar la OT',                detalle: 'Cuando el trabajo terminó. Queda como antecedente, ya no se edita.' },
    ],

    dependencias_intro:
        'Si alguno de estos datos no está cargado, vas a tener que crearlos primero en el menú "Maestros".',

    dependencias: [
        { entidad: 'Cliente',     descripcion: 'Tiene que estar dado de alta con al menos un contacto.', ruta: '/ayuda_gestion_cliente',    critico: true },
        { entidad: 'Comitente',   descripcion: 'Solo si el trabajo lo terceriza otra empresa.',          ruta: '/ayuda_gestion_comitente', critico: false },
        { entidad: 'Servicios',   descripcion: 'Sin servicios cargados, después no podés hacer informes.', ruta: '/ayuda_gestion_servicios', critico: true },
        { entidad: 'Productos',   descripcion: 'Solo si vas a consumir materiales (placas, líquidos, etc.).', ruta: '/ayuda_gestion_productos', critico: false },
        { entidad: 'Responsable', descripcion: 'Un usuario interno de Enod, que también vas a asignar como operador.', ruta: '/ayuda_gestion_usuario', critico: true },
    ],

    demo_intro:
        'Esta es la cabecera del formulario tal como la vas a ver en el sistema. Más abajo encontrás ' +
        'el detalle de qué se carga en cada campo.',
    demo: 'ayuda-demo-form-ot',

    campos_intro:
        'Los campos con asterisco rojo no se pueden dejar vacíos. Si te falta algún dato, el sistema ' +
        'no te deja guardar hasta que lo completes.',

    campos: [
        { nombre: 'Proyecto',        tipo: 'texto',     obligatorio: true,  origen: 'Lo escribís vos',                notas: 'Nombre del proyecto, hasta 60 caracteres.' },
        { nombre: 'FST N°',          tipo: 'número',    obligatorio: true,  origen: 'Número de presupuesto',          notas: 'El número de presupuesto comercial que dio origen al trabajo.' },
        { nombre: 'OT N°',           tipo: 'número',    obligatorio: true,  origen: 'Sugerido por el sistema',         notas: 'No puede repetirse. El sistema sugiere el siguiente libre, podés cambiarlo.' },
        { nombre: 'Fecha',           tipo: 'fecha',     obligatorio: true,  origen: 'Por defecto la de hoy',           notas: 'La fecha de creación de la OT.' },
        { nombre: 'Obra N° / OC',    tipo: 'texto',     obligatorio: 'condicional', condicion: 'OT de una sola obra', origen: 'Número que dio el cliente', notas: 'Si la OT es multiobra, este campo lo dejás vacío.' },
        { nombre: 'Fecha estimada',  tipo: 'fecha',     obligatorio: true,  origen: 'Lo elegís vos',                  notas: 'Cuándo se va a hacer el ensayo.' },
        { nombre: 'Hora',            tipo: 'hora',      obligatorio: true,  origen: 'HH:MM',                          notas: 'Hora estimada de inicio.' },
        { nombre: 'Cliente',         tipo: 'lista',     obligatorio: true,  origen: 'Maestro de clientes',            notas: 'Al elegirlo, se cargan los contactos disponibles automáticamente.' },
        { nombre: 'Contacto',        tipo: 'lista',     obligatorio: true,  origen: 'Contactos del cliente',          notas: 'Podés elegir hasta 3 contactos del cliente para que figuren en la OT.' },
        { nombre: 'Comitente',       tipo: 'lista',     obligatorio: false, origen: 'Maestro de comitentes',          notas: 'Solo si aplica.' },
        { nombre: 'Responsable OT',  tipo: 'lista',     obligatorio: true,  origen: 'Usuarios internos de Enod',      notas: 'Esta persona también tiene que estar asignada después como operador de la OT.' },
        { nombre: 'Mostrar logo',    tipo: 'tilde',     obligatorio: false, origen: 'Sí / No',                        notas: 'Si lo tildás, el logo del cliente o del comitente sale en los PDFs.' },
        { nombre: 'Provincia',       tipo: 'lista',     obligatorio: true,  origen: 'Maestro de provincias',          notas: 'Al elegirla, se filtran las localidades.' },
        { nombre: 'Localidad',       tipo: 'lista',     obligatorio: true,  origen: 'Localidades de la provincia',     notas: '' },
        { nombre: 'Lugar de ensayo', tipo: 'texto',     obligatorio: true,  origen: 'Lo escribís vos',                notas: 'Sector descriptivo (planta, taller, frente de obra, etc.).' },
        { nombre: 'Latitud / Longitud', tipo: 'mapa',  obligatorio: true,  origen: 'Google Maps',                    notas: 'Si las cargás manualmente, el mapa se reubica en ese punto.' },
        { nombre: 'Servicios',       tipo: 'subtabla',  obligatorio: true,  origen: 'Maestro de servicios',           notas: 'Agregá uno por uno con el botón +. Definen qué métodos podrás informar después.' },
        { nombre: 'Productos',       tipo: 'subtabla',  obligatorio: false, origen: 'Maestro de productos',           notas: 'Solo si presupuestaste consumibles por trabajo.' },
        { nombre: 'EPP',             tipo: 'subtabla',  obligatorio: false, origen: 'Maestro de EPP',                 notas: 'Elementos de seguridad requeridos para el trabajo.' },
        { nombre: 'Riesgos',         tipo: 'subtabla',  obligatorio: false, origen: 'Maestro de riesgos',             notas: 'Riesgos detectados para el ensayo.' },
        { nombre: 'Observaciones',   tipo: 'texto',     obligatorio: false, origen: 'Lo escribís vos',                notas: 'Aclaraciones generales. No reemplaza datos estructurados del formulario.' },
    ],

    botones: [
        { label: '+ Nueva OT',  icono: 'plus',    estilo: '',     descripcion: 'Abre el formulario vacío para crear una OT nueva.' },
        { label: '+',           icono: '',         estilo: '',     descripcion: 'Suma una fila a las subtablas (servicios, productos, EPP, riesgos).' },
        { label: 'Guardar',     icono: 'save',    estilo: '',     descripcion: 'Graba la OT en estado Editando. Podés volver a modificarla.' },
        { label: 'Firmar',      icono: 'check',   estilo: '',     descripcion: 'Pasa la OT a Activa. Es irreversible.' },
        { label: 'Cancelar',    icono: '',         estilo: 'gris', descripcion: 'Sale sin guardar cambios.' },
    ],

    estados_intro: 'Una OT pasa por tres momentos. Lo que podés hacer en cada uno cambia:',

    estados: [
        { nombre: 'Editando', color: 'amarillo', icono: 'pencil',  descripcion: 'Recién creada. Modificás todo libremente.',                                editable: true },
        { nombre: 'Activa',   color: 'verde',    icono: 'check',   descripcion: 'Firmada. Podés cargar informes, partes y certificados.',                    editable: 'parcial' },
        { nombre: 'Cerrada',  color: 'gris',     icono: 'archive', descripcion: 'Trabajo terminado. Queda como consulta, no se edita más.',                  editable: false },
    ],

    transiciones: [
        { de: 'Editando', a: 'Activa',  accion: 'Firmar la OT', irreversible: true },
        { de: 'Activa',   a: 'Cerrada', accion: 'Cerrar la OT', irreversible: true },
    ],

    errores: [
        { mensaje: 'No me deja guardar',
          causa: 'Falta completar algún campo obligatorio (marcado con *).',
          solucion: 'Revisá los campos que aparecen resaltados en rojo. Suele faltar cliente, contacto, responsable o servicios.' },
        { mensaje: 'El número de OT ya existe',
          causa: 'Hay otra OT con el mismo número.',
          solucion: 'Usá el correlativo que sugiere el sistema, o elegí otro distinto.' },
        { mensaje: 'El contacto que elegí ya no aparece',
          causa: 'Cambiaste el cliente después de elegir el contacto. Cada contacto pertenece a un cliente.',
          solucion: 'Volvé a elegir el contacto. Si no aparece el que necesitás, agregálo desde el maestro de clientes.' },
        { mensaje: 'No hay localidades para elegir',
          causa: 'No elegiste provincia, o la provincia no tiene localidades cargadas.',
          solucion: 'Primero seleccioná la provincia. Si igual no aparecen, pedile a sistemas que agregue la localidad.' },
        { mensaje: 'No me deja editar la OT',
          causa: 'La OT ya fue cerrada. No se puede revertir desde la pantalla.',
          solucion: 'Si necesitás corregir algo, pedile a sistemas que la reabra manualmente.' },
        { mensaje: 'No me aparecen los métodos en informes',
          causa: 'No agregaste el servicio del método (por ejemplo, servicio "RI" para hacer informes de radiografía).',
          solucion: 'Volvé a la OT y agregá el servicio correspondiente desde la subtabla de Servicios.' },
    ],

    calculos: [
        { que: 'Número de OT',  como: 'El sistema sugiere el siguiente número libre. Lo podés cambiar, siempre que no se repita.' },
        { que: 'Contactos',     como: 'Cuando elegís cliente, la lista de contactos se actualiza sola con los que tiene ese cliente.' },
        { que: 'Localidades',   como: 'Al elegir provincia, las localidades disponibles se filtran solas.' },
        { que: 'Mapa',          como: 'Si cargás latitud y longitud manualmente, el mapa se mueve a esa ubicación.' },
    ],

    edicion: {
        texto:
            'Mientras la OT está en Editando, podés cambiar todo. Una vez que la Firmás, queda en Activa: ' +
            'algunos datos de cabecera (como el número de OT) quedan bloqueados, pero podés seguir cargando ' +
            'servicios, asignaciones y demás. Cuando la Cerrás, la OT queda como consulta y ya no se modifica.',
        callouts: [
            {
                tipo: 'irreversible',
                titulo: 'Firmar es irreversible',
                contenido:
                    'No hay un botón para "desfirmar". Antes de firmar, revisá: cliente, comitente, ' +
                    'responsable, servicios y los datos visibles en cabecera. Si algo está mal, lo único que queda es pedirle a sistemas que lo arregle.',
            },
            {
                tipo: 'warning',
                titulo: 'Cuidado al editar servicios y productos',
                contenido:
                    'Al editar una OT, las subtablas (servicios, productos, EPP, riesgos) se reemplazan completas con lo que dejaste en el formulario. ' +
                    'Si quitás un servicio sin querer, los informes de ese método dejan de estar disponibles.',
            },
        ],
    },

    impacto: [
        { modulo: 'Informes',         efecto: 'Recién después de firmar la OT, podés crear informes. Los métodos disponibles dependen de los servicios cargados.', reversible: 'parcial' },
        { modulo: 'Partes diarios',   efecto: 'Cada parte se asocia a la OT. Si la OT está cerrada, ya no se pueden crear partes nuevos.',                            reversible: false },
        { modulo: 'Certificados',     efecto: 'Toman partes firmados de la OT. Pueden seguir generándose aún con la OT cerrada.',                                     reversible: true },
        { modulo: 'Asignaciones',     efecto: 'Operadores, soldadores, vehículos y procedimientos cuelgan de la OT. Se pueden modificar mientras la OT no esté cerrada.', reversible: true },
        { modulo: 'PDF de la OT',     efecto: 'Si tildaste "Mostrar logo", el logo del cliente o comitente sale en el PDF generado.',                                  reversible: true },
    ],

    relacionados: [
        { titulo: 'Ver listado de OT',                     ruta: '/visualizar_ot' },
        { titulo: 'Asignar operadores a la OT',             ruta: '/asignar_operadores' },
        { titulo: 'Asignar soldadores y usuarios cliente',  ruta: '/asignar_soldadores_y_usuarios' },
        { titulo: 'Asignar vehículos',                       ruta: '/asignar_vehiculos' },
        { titulo: 'Asignar procedimientos',                  ruta: '/asignar_procedimientos' },
        { titulo: 'Generar informes',                        ruta: '/generar_informes' },
    ],
};
