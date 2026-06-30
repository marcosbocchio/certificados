/* Datos del manual: Orden de Trabajo (OT).
 * Verificado contra:
 *   - app/Http/Controllers/OtsController.php
 *   - app/Http/Requests/OtsRequest.php
 *   - app/Ots.php
 *   - database/migrations/2019_06_13_190325_create_ots_table.php
 */

export default {
    hero: {
        titulo: 'Orden de Trabajo (OT)',
        descripcion:
            'La OT es el registro raíz del circuito documental. Define cliente, comitente, responsable, ' +
            'servicios contratados, productos, EPP y riesgos. Todo lo que pasa después (informes, partes, ' +
            'certificados, remitos) cuelga de una OT correctamente cargada.',
        subtexto:
            'Una OT mal definida en cabecera obliga a corregir documentos posteriores. ' +
            'Conviene completar todos los datos sensibles antes de firmar.',
    },

    dependencias: [
        { entidad: 'Cliente',     descripcion: 'Debe estar dado de alta con razón social, CUIT y al menos un contacto.', ruta: '/ayuda_gestion_cliente',    critico: true },
        { entidad: 'Comitente',   descripcion: 'Si aplica al trabajo, debe existir en el maestro de contratistas.',      ruta: '/ayuda_gestion_comitente', critico: false },
        { entidad: 'Responsable', descripcion: 'Usuario interno de Enod habilitado y posteriormente asignado como operador de la OT.', ruta: '/ayuda_gestion_usuario', critico: true },
        { entidad: 'Servicios',   descripcion: 'Habilita después qué métodos NDT (RI / PM / LP / US…) podrán informarse.', ruta: '/ayuda_gestion_servicios', critico: true },
        { entidad: 'Productos',   descripcion: 'Solo si se presupuestaron consumibles por trabajo (placas, líquidos, etc).', ruta: '/ayuda_gestion_productos', critico: false },
    ],

    campos_intro:
        'El formulario tiene 19 campos en cabecera más sub-secciones para servicios, productos, EPP y riesgos. ' +
        'Los marcados con (*) son obligatorios — sin ellos el sistema no permite guardar.',

    campos: [
        { nombre: 'OT N°',           tipo: 'numeric',  obligatorio: true,  origen: 'Auto / manual',          validacion: 'digits_between:1,8 · unique:ots,numero', notas: 'No puede repetirse en el sistema.' },
        { nombre: 'FST N°',          tipo: 'numeric',  obligatorio: true,  origen: 'Numero de presupuesto',  validacion: 'digits_between:1,8',                     notas: 'Identifica el presupuesto comercial origen.' },
        { nombre: 'Proyecto',        tipo: 'text',     obligatorio: true,  origen: 'Libre',                  validacion: 'required · Max:60',                      notas: 'Nombre del proyecto / obra principal.' },
        { nombre: 'Obra / OC',       tipo: 'text',     obligatorio: 'condicional', condicion: 'OT de obra única', origen: 'Libre',  validacion: 'Min:1 · Max:15 · nullable', notas: 'Si la OT es multiobra, puede quedar vacío.' },
        { nombre: 'Fecha',           tipo: 'date',     obligatorio: true,  origen: 'Hoy por defecto',        validacion: 'required',                               notas: 'Fecha de creación del registro.' },
        { nombre: 'Fecha estimada',  tipo: 'date',     obligatorio: true,  origen: 'Libre',                  validacion: 'required',                               notas: 'Cuándo se planea ejecutar el trabajo.' },
        { nombre: 'Hora',            tipo: 'time',     obligatorio: true,  origen: 'HH:MM',                  validacion: 'required',                               notas: 'Hora estimada de inicio.' },
        { nombre: 'Cliente',         tipo: 'select',   obligatorio: true,  origen: 'Maestro clientes',       validacion: 'required',                               notas: 'Al elegirlo, se filtran los contactos disponibles.' },
        { nombre: 'Contacto 1',      tipo: 'select',   obligatorio: true,  origen: 'Contactos del cliente',  validacion: 'required',                               notas: 'Debe pertenecer al cliente elegido.' },
        { nombre: 'Contacto 2 / 3',  tipo: 'select',   obligatorio: false, origen: 'Contactos del cliente',  validacion: 'nullable',                               notas: 'Contactos secundarios opcionales.' },
        { nombre: 'Comitente',       tipo: 'select',   obligatorio: false, origen: 'Maestro contratistas',   validacion: 'nullable',                               notas: 'Empresa que terceriza el trabajo (si aplica).' },
        { nombre: 'Responsable OT',  tipo: 'select',   obligatorio: true,  origen: 'Usuarios internos',      validacion: 'required',                               notas: 'Debe ser asignado luego como operador de la OT.' },
        { nombre: 'Provincia',       tipo: 'select',   obligatorio: true,  origen: 'Maestro provincias',     validacion: 'required',                               notas: 'Al elegirla, se filtran las localidades.' },
        { nombre: 'Localidad',       tipo: 'select',   obligatorio: true,  origen: 'Localidades por provincia', validacion: 'required',                            notas: 'Localidad del ensayo.' },
        { nombre: 'Lugar de ensayo', tipo: 'text',     obligatorio: true,  origen: 'Libre',                  validacion: 'required · Max:200',                     notas: 'Sector / dirección del trabajo.' },
        { nombre: 'Latitud',         tipo: 'decimal',  obligatorio: true,  origen: 'Google Maps',            validacion: 'required',                               notas: 'Reubica el mapa si se carga manualmente.' },
        { nombre: 'Longitud',        tipo: 'decimal',  obligatorio: true,  origen: 'Google Maps',            validacion: 'required',                               notas: 'Idem latitud.' },
        { nombre: 'Mostrar logo cliente',     tipo: 'checkbox', obligatorio: false, origen: '0/1', validacion: '', notas: 'Si está activo, se imprime el logo en los PDFs.' },
        { nombre: 'Mostrar logo contratista', tipo: 'checkbox', obligatorio: false, origen: '0/1', validacion: '', notas: 'Idem para el logo del comitente.' },
        { nombre: 'Observaciones',   tipo: 'textarea', obligatorio: false, origen: 'Libre',                  validacion: 'nullable · Max:255',                     notas: 'Aclaraciones generales, no reemplaza datos estructurados.' },
    ],

    estados_intro:
        'La OT pasa por tres estados. Cada transición es disparada por una acción explícita del usuario con permiso.',

    estados: [
        { nombre: 'EDITANDO', color: 'amarillo', icono: 'pencil',     descripcion: 'OT recién creada, todos los datos modificables.',                editable: true,     permiso: 'O_alta' },
        { nombre: 'ACTIVA',   color: 'verde',    icono: 'check',      descripcion: 'Firmada por el responsable. Habilita informes, partes y certificados.', editable: 'parcial', permiso: 'O_alta' },
        { nombre: 'CERRADA',  color: 'gris',     icono: 'archive',    descripcion: 'Trabajo terminado. Queda como antecedente, solo lectura.',     editable: false,    permiso: 'O_alta' },
    ],

    transiciones: [
        { de: 'EDITANDO', a: 'ACTIVA',  accion: 'Firmar OT',  permiso: 'O_alta', irreversible: true },
        { de: 'ACTIVA',   a: 'CERRADA', accion: 'Cerrar OT',  permiso: 'O_alta', irreversible: true },
    ],

    errores: [
        { mensaje: 'El número de OT ya existe',
          causa: 'Otro registro ya usa ese número (validación unique:ots,numero).',
          solucion: 'Elegí un número de OT distinto. El sistema sugiere el siguiente correlativo libre.' },
        { mensaje: 'El campo proyecto es obligatorio',
          causa: 'No se completó el nombre del proyecto antes de guardar.',
          solucion: 'Cargá un proyecto (máx. 60 caracteres) antes de continuar.' },
        { mensaje: 'El contacto seleccionado no pertenece a este cliente',
          causa: 'Cambiaste el cliente después de elegir el contacto.',
          solucion: 'Elegí un contacto que sí esté cargado para el cliente actual, o agregálo en el maestro de clientes.' },
        { mensaje: 'No hay localidades disponibles',
          causa: 'No elegiste provincia, o la provincia no tiene localidades cargadas.',
          solucion: 'Seleccioná primero la provincia. Si falta una localidad, cargála desde el maestro.' },
        { mensaje: 'No puedo editar esta OT',
          causa: 'La OT está en estado CERRADA. La firma es irreversible.',
          solucion: 'Si necesitás corregir datos, abrí una nueva OT o consultá con sistemas para revertir manualmente.' },
        { mensaje: 'No aparecen servicios al cargar informes',
          causa: 'No agregaste servicios a la OT, o el método del informe no tiene su servicio cargado.',
          solucion: 'Volvé a la OT y agregá el servicio del método (ej. servicio RI para informes de radiografía).' },
    ],

    calculos: [
        { que: 'Número de OT', como: 'Validado como único en la tabla ots. El sistema sugiere correlativo pero permite manual.' },
        { que: 'Filtro de contactos', como: 'Cuando elegís cliente, el select de contactos se filtra por cliente_id automáticamente.' },
        { que: 'Filtro de localidades', como: 'Al elegir provincia, las localidades se cargan por provincia_id.' },
        { que: 'Mapa', como: 'Si se cargan latitud y longitud manualmente, el mapa se reubica con esa información.' },
    ],

    edicion: {
        texto:
            'Mientras la OT está en estado EDITANDO se puede modificar todo. Tras firmar (estado ACTIVA), ' +
            'la cabecera queda parcialmente bloqueada: el número de OT y FST quedan readonly, pero los ' +
            'servicios, productos, EPP y asignaciones siguen siendo editables. Una vez cerrada, todo queda en solo lectura.',
        callouts: [
            {
                tipo: 'irreversible',
                titulo: 'Firmar OT es irreversible',
                contenido:
                    'No existe función de desfirmar. Si necesitás revertir, consultá con el área de sistemas. ' +
                    'Antes de firmar, verificá cliente, comitente, responsable, servicios y observaciones.',
            },
            {
                tipo: 'warning',
                titulo: 'Edición de sub-entidades',
                contenido:
                    'Al editar la OT, las sub-entidades (servicios, productos, EPP, riesgos) se reescriben completamente. ' +
                    'No hay sincronización delta — todo lo previo se borra y se vuelve a crear.',
            },
        ],
    },

    impacto: [
        { modulo: 'Informes',     efecto: 'Al firmar OT, el módulo de informes muestra los métodos según los servicios cargados.', reversible: false },
        { modulo: 'Partes diarios', efecto: 'Cada parte referencia ot_id. Si OT está cerrada, no se crean nuevos partes.',         reversible: false },
        { modulo: 'Certificados', efecto: 'Filtran por ot_id. Pueden seguir generándose aún con OT cerrada.',                       reversible: true  },
        { modulo: 'Asignaciones', efecto: 'Operadores, soldadores, vehículos y procedimientos se cuelgan de la OT.',                reversible: true  },
        { modulo: 'PDF de OT',    efecto: 'DomPDF genera el reporte usando logo_cliente_sn y logo_contratista_sn para mostrar/ocultar logos.', reversible: true },
    ],

    relacionados: [
        { titulo: 'Visualización general de una OT', ruta: '/visualizar_ot' },
        { titulo: 'Asignar operadores',               ruta: '/asignar_operadores' },
        { titulo: 'Asignar soldadores y usuarios cliente', ruta: '/asignar_soldadores_y_usuarios' },
        { titulo: 'Creación de informes',             ruta: '/generar_informes' },
        { titulo: 'Gestionar clientes',               ruta: '/ayuda_gestion_cliente' },
        { titulo: 'Gestionar servicios',              ruta: '/ayuda_gestion_servicios' },
    ],

    demo: 'ayuda-demo-form-ot',

    fuente_codigo: {
        controller: 'app/Http/Controllers/OtsController.php',
        model:      'app/Ots.php',
        request:    'app/Http/Requests/OtsRequest.php',
    },
};
