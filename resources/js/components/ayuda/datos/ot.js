export default {
    hero: {
        titulo: 'Crear una Orden de Trabajo (OT)',
        descripcion:
            'La OT es la "carpeta" del trabajo. Acá cargás cliente, comitente, ubicación, ' +
            'responsable, servicios contratados, productos, EPP y riesgos. Una vez creada, ' +
            'desde la OT vas a asignar operadores, soldadores, vehículos y procedimientos.',
    },

    ir_a: {
        label: 'Abrir el tablero de OT',
        ruta: '/area/enod',
        icono: 'clipboard',
    },

    acciones: [
        { icono: 'plus-circle', titulo: 'Crear una OT nueva',          detalle: 'Desde el botón "Nueva OT" del tablero principal.' },
        { icono: 'pencil',      titulo: 'Editar una OT en borrador',   detalle: 'Mientras esté en estado Editando, podés modificar todos los datos.' },
        { icono: 'check-circle',titulo: 'Firmar la OT',                 detalle: 'La pasa a Activa. Recién ahí podés cargar informes y partes.' },
        { icono: 'cogs',        titulo: 'Cargar servicios y productos', detalle: 'Definen qué métodos de ensayo van a estar disponibles después.' },
        { icono: 'map-marker',  titulo: 'Marcar la ubicación en el mapa', detalle: 'Buscás la dirección en Google y el mapa se posiciona solo.' },
        { icono: 'archive',     titulo: 'Cerrar la OT',                 detalle: 'Cuando el trabajo terminó. Queda como antecedente, ya no se edita.' },
    ],

    dependencias_intro:
        'Si alguno de estos datos no está cargado, lo primero es crearlo en el menú "Maestros".',

    dependencias: [
        { entidad: 'Cliente',     descripcion: 'Tiene que estar dado de alta con al menos un contacto.', ruta: '/ayuda_gestion_cliente',    critico: true },
        { entidad: 'Comitente',   descripcion: 'Solo si el trabajo lo terceriza otra empresa.',          ruta: '/ayuda_gestion_comitente', critico: false },
        { entidad: 'Servicios',   descripcion: 'Sin servicios cargados, después no podés hacer informes.', ruta: '/ayuda_gestion_servicios', critico: true },
        { entidad: 'Productos',   descripcion: 'Solo si vas a consumir materiales (placas, líquidos, etc.).', ruta: '/ayuda_gestion_productos', critico: false },
        { entidad: 'Responsable', descripcion: 'Un usuario interno de Enod, que también vas a asignar como operador.', ruta: '/ayuda_gestion_usuario', critico: true },
        { entidad: 'EPP',         descripcion: 'Elementos de protección personal que se van a usar.',     ruta: '/ayuda_gestion_materiales', critico: false },
        { entidad: 'Riesgos',     descripcion: 'Riesgos posibles del trabajo a ejecutar.',                ruta: '/ayuda_gestion_materiales', critico: false },
    ],

    bloques_intro:
        'La pantalla está dividida en bloques. Cada bloque se ve como una "card" en el sistema. ' +
        'Los campos con asterisco rojo son obligatorios: si te falta alguno, el sistema no te deja guardar.',

    bloques: [
        {
            titulo: 'Proyecto',
            icono: 'tag',
            descripcion: 'Nombre comercial del trabajo. Es lo primero que se ve en el listado.',
            campos: [
                { nombre: 'Proyecto', obligatorio: true, detalle: 'Hasta 60 caracteres. Es el título visible de la OT.' },
            ],
        },
        {
            titulo: 'Datos generales',
            icono: 'info-circle',
            descripcion: 'Numeración, fechas y horario estimado.',
            campos: [
                { nombre: 'FST N°',         obligatorio: true,  detalle: 'Número del presupuesto comercial que dio origen al trabajo.' },
                { nombre: 'OT N°',          obligatorio: true,  detalle: 'No puede repetirse. El sistema sugiere el siguiente libre.' },
                { nombre: 'Fecha',          obligatorio: true,  detalle: 'Fecha de creación (por defecto, la de hoy).' },
                { nombre: 'Obra N° / OC',   obligatorio: false, detalle: 'Número que dio el cliente. Si la OT es multiobra, lo dejás vacío.' },
                { nombre: 'Fecha estimada', obligatorio: true,  detalle: 'Cuándo se planea ejecutar el ensayo.' },
                { nombre: 'Hora',           obligatorio: true,  detalle: 'Hora estimada de inicio.' },
            ],
        },
        {
            titulo: 'Cliente y comitente',
            icono: 'building',
            descripcion: 'Quién pide el trabajo y para quién es. Al elegir cliente se cargan los contactos automáticamente.',
            campos: [
                { nombre: 'Cliente',         obligatorio: true,  detalle: 'Maestro de clientes. Al elegirlo, se filtran sus contactos.' },
                { nombre: 'Mostrar logo cliente', obligatorio: false, detalle: 'Si lo tildás, el logo del cliente sale en los PDFs.' },
                { nombre: 'Comitente',       obligatorio: false, detalle: 'Empresa contratista, si el trabajo lo terceriza.' },
                { nombre: 'Mostrar logo comitente', obligatorio: false, detalle: 'Si lo tildás, el logo del comitente sale en los PDFs.' },
                { nombre: 'Contacto 1',      obligatorio: true,  detalle: 'Tiene que pertenecer al cliente elegido.' },
                { nombre: 'Contacto 2',      obligatorio: false, detalle: 'Contacto adicional del cliente.' },
                { nombre: 'Contacto 3',      obligatorio: false, detalle: 'Contacto adicional del cliente.' },
                { nombre: 'Responsable OT',  obligatorio: true,  detalle: 'Usuario interno. Después tiene que estar también como operador.' },
            ],
        },
        {
            titulo: 'Ubicación del ensayo',
            icono: 'map-marker',
            descripcion:
                'Dónde se hace el trabajo. La pantalla tiene un buscador de Google integrado: ' +
                'escribís la dirección, elegís el resultado y el mapa se posiciona solo con latitud y longitud cargadas.',
            campos: [
                { nombre: 'Lugar de ensayo', obligatorio: true,  detalle: 'Sector descriptivo (planta, taller, frente de obra, etc.). Hasta 35 caracteres.' },
                { nombre: 'Provincia',       obligatorio: true,  detalle: 'Al elegirla se cargan las localidades disponibles.' },
                { nombre: 'Localidad',       obligatorio: true,  detalle: 'Localidad donde se ejecuta el trabajo.' },
                { nombre: 'Buscar Ubicación', obligatorio: false, detalle: 'Buscador de Google Maps. Tipeás la dirección, elegís el lugar y el mapa se reubica solo.' },
                { nombre: 'Latitud',         obligatorio: false, detalle: 'La completa el buscador. Podés escribirla manualmente si la conocés.' },
                { nombre: 'Longitud',        obligatorio: false, detalle: 'Idem latitud.' },
                { nombre: 'Mapa',            obligatorio: false, detalle: 'Muestra la ubicación marcada. Podés arrastrar el marcador para ajustarla.' },
            ],
        },
        {
            titulo: 'Servicios',
            icono: 'cogs',
            descripcion:
                'Servicios contratados. Definen qué métodos de ensayo (RI, PM, LP, US, etc.) ' +
                'van a estar disponibles después al cargar informes.',
            campos: [
                { nombre: 'Servicio',          obligatorio: true,  detalle: 'Maestro de servicios. Elegís uno y lo sumás con +.' },
                { nombre: 'Norma Ensayos',     obligatorio: false, detalle: 'Norma técnica por la que se hace el ensayo.' },
                { nombre: 'Norma Evaluación',  obligatorio: false, detalle: 'Norma por la que se evalúan los resultados.' },
                { nombre: 'Cant.',             obligatorio: false, detalle: 'Cantidad presupuestada del servicio.' },
                { nombre: 'Ref. (archivo)',    obligatorio: false, detalle: 'Adjunto opcional del servicio (PDF, foto, etc.).' },
                { nombre: 'Proc.',             obligatorio: false, detalle: 'Si el servicio requiere procedimiento específico.' },
                { nombre: 'C (combinado)',     obligatorio: false, detalle: 'Marcar si el servicio se factura combinado con otro.' },
            ],
        },
        {
            titulo: 'Calidad de placas',
            icono: 'film',
            descripcion: 'Aparece solo si hay servicio de RI. Permite elegir uno o más tipos de película radiográfica habilitados.',
            campos: [
                { nombre: 'Calidad de placas', obligatorio: false, detalle: 'Selección múltiple del maestro de películas radiográficas.' },
            ],
        },
        {
            titulo: 'Productos',
            icono: 'cubes',
            descripcion: 'Materiales / consumibles presupuestados para el trabajo.',
            campos: [
                { nombre: 'Producto',  obligatorio: true,  detalle: 'Maestro de productos. Al elegir, se cargan sus medidas disponibles.' },
                { nombre: 'Medida',    obligatorio: true,  detalle: 'Medida específica del producto.' },
                { nombre: 'Cant.',     obligatorio: false, detalle: 'Cantidad presupuestada.' },
                { nombre: 'Ref. (archivo)', obligatorio: false, detalle: 'Adjunto opcional del producto.' },
            ],
        },
        {
            titulo: 'Elementos de seguridad (EPP)',
            icono: 'shield',
            descripcion: 'EPP requeridos para ejecutar el trabajo.',
            campos: [
                { nombre: 'EPP', obligatorio: true, detalle: 'Maestro de EPP. Lo sumás uno por uno con +.' },
            ],
        },
        {
            titulo: 'Riesgos',
            icono: 'exclamation-triangle',
            descripcion: 'Riesgos detectados para el ensayo.',
            campos: [
                { nombre: 'Riesgo', obligatorio: true, detalle: 'Maestro de riesgos. Lo sumás uno por uno con +.' },
            ],
        },
        {
            titulo: 'Observaciones',
            icono: 'comment-o',
            descripcion: 'Texto libre con aclaraciones generales. Hasta 250 caracteres.',
            campos: [
                { nombre: 'Observaciones', obligatorio: false, detalle: 'No reemplaza datos estructurados del formulario. Usalo para notas.' },
            ],
        },
    ],

    botones: [
        { label: '+ Nueva OT',     icono: 'plus',         estilo: '',      descripcion: 'Abre el formulario vacío para crear una OT nueva.' },
        { label: '+',              icono: 'plus-circle',  estilo: '',      descripcion: 'Suma una fila a las subtablas (servicios, productos, EPP, riesgos).' },
        { label: 'Guardar',        icono: 'save',         estilo: '',      descripcion: 'Graba la OT. Si está en Editando podés volver a modificarla.' },
        { label: 'Volver',         icono: 'arrow-left',   estilo: '',      descripcion: 'Vuelve a la pantalla anterior. Si tocás algo y volvés sin guardar, los cambios se pierden.' },
    ],

    estados_intro: 'Una OT pasa por tres momentos. Lo que podés hacer en cada uno cambia:',

    estados: [
        { nombre: 'Editando', color: 'amarillo', icono: 'pencil',  descripcion: 'Recién creada. Modificás todo libremente.',                editable: true },
        { nombre: 'Activa',   color: 'verde',    icono: 'check',   descripcion: 'Firmada. Habilita informes, partes y certificados.',         editable: 'parcial' },
        { nombre: 'Cerrada',  color: 'gris',     icono: 'archive', descripcion: 'Trabajo terminado. Queda como consulta, ya no se edita.',    editable: false },
    ],

    transiciones: [
        { de: 'Editando', a: 'Activa',  accion: 'Firmar la OT', irreversible: true },
        { de: 'Activa',   a: 'Cerrada', accion: 'Cerrar la OT', irreversible: true },
    ],

    errores: [
        { mensaje: 'No me deja guardar',
          causa: 'Falta completar algún campo obligatorio (marcado con *).',
          solucion: 'Revisá los campos resaltados. Suele faltar cliente, contacto, responsable o servicios.' },
        { mensaje: 'El número de OT ya existe',
          causa: 'Hay otra OT con el mismo número.',
          solucion: 'Usá el correlativo que sugiere el sistema, o elegí otro distinto.' },
        { mensaje: 'No me aparece el contacto que necesito',
          causa: 'El contacto no está cargado en el maestro del cliente, o cambiaste el cliente.',
          solucion: 'Cargá el contacto desde "Gestionar clientes" o volvé a elegir el cliente correcto.' },
        { mensaje: 'No hay localidades para elegir',
          causa: 'No elegiste provincia, o la provincia no tiene localidades cargadas.',
          solucion: 'Primero seleccioná la provincia. Si igual no aparecen, pedile a sistemas que agregue la localidad.' },
        { mensaje: 'El buscador de Google no marca el mapa',
          causa: 'Escribiste la dirección pero no elegiste un resultado de la lista que despliega Google.',
          solucion: 'Tenés que hacer click en uno de los resultados sugeridos para que se cargue latitud, longitud y se reubique el mapa.' },
        { mensaje: 'No me deja editar la OT',
          causa: 'La OT ya fue cerrada.',
          solucion: 'Si necesitás corregir algo, pedile a sistemas que la reabra manualmente.' },
        { mensaje: 'No me aparecen los métodos al cargar informes',
          causa: 'No agregaste el servicio del método (por ejemplo "RI" para informes de radiografía).',
          solucion: 'Volvé a la OT y agregá el servicio correspondiente en el bloque Servicios.' },
    ],

    calculos: [
        { que: 'Número de OT',  como: 'El sistema sugiere el siguiente número libre. Lo podés cambiar, siempre que no se repita.' },
        { que: 'Contactos',     como: 'Cuando elegís cliente, la lista de contactos se actualiza sola.' },
        { que: 'Localidades',   como: 'Al elegir provincia, las localidades disponibles se filtran solas.' },
        { que: 'Ubicación en el mapa', como: 'Cuando elegís una dirección del buscador de Google, latitud, longitud y el marcador del mapa se cargan automáticamente.' },
        { que: 'Medidas del producto', como: 'Al elegir un producto, las medidas disponibles para ese producto se cargan solas.' },
    ],

    edicion: {
        texto:
            'Mientras la OT está en Editando, podés cambiar todo. Cuando la Firmás, queda en Activa: ' +
            'algunos datos quedan bloqueados pero podés seguir cargando asignaciones, servicios y demás. ' +
            'Cuando la Cerrás, queda como consulta y ya no se modifica.',
        callouts: [
            {
                tipo: 'irreversible',
                titulo: 'Firmar es irreversible',
                contenido:
                    'No hay un botón para "desfirmar". Antes de firmar, revisá: cliente, comitente, ' +
                    'responsable, servicios y los datos de cabecera. Si algo está mal, lo único que queda es pedirle a sistemas que lo arregle.',
            },
            {
                tipo: 'warning',
                titulo: 'Cuidado al editar servicios y productos',
                contenido:
                    'Al editar una OT, las subtablas (servicios, productos, EPP, riesgos) se reemplazan completas con lo que dejaste en pantalla. ' +
                    'Si quitás un servicio sin querer, los informes de ese método dejan de estar disponibles.',
            },
        ],
    },

    impacto: [
        { modulo: 'Informes',         efecto: 'Recién después de firmar la OT, podés crear informes. Los métodos disponibles dependen de los servicios cargados.', reversible: 'parcial' },
        { modulo: 'Partes diarios',   efecto: 'Cada parte se asocia a la OT. Si la OT está cerrada, ya no se pueden crear partes nuevos.',                            reversible: false },
        { modulo: 'Certificados',     efecto: 'Toman partes firmados de la OT. Pueden seguir generándose aún con la OT cerrada.',                                     reversible: true },
        { modulo: 'Asignaciones',     efecto: 'Operadores, soldadores, vehículos y procedimientos cuelgan de la OT. Se pueden modificar mientras no esté cerrada.', reversible: true },
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

    demo: 'ayuda-demo-form-ot',
};
