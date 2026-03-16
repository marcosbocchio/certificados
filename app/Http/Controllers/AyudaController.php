<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AyudaController extends Controller
{


public function __construct()
{

    $this->middleware(['role_or_permission:Sistemas|enod'],['only' =>
     ['crearOt','asignarOperadores','asignarSoldadoresUsuarios','asignarSoldadoresUsuarios',
     'generarInformes','generarInformesRi','generarInformesLp','generarInformesPm','generarInformesUs','asignarVehiculos']]);

}

  private function returnAyudaView($viewName, $titulo = "Ayuda", $descripcion = '')
  {
      $user = auth()->user();
      $header_titulo = $titulo;
      $header_descripcion = $descripcion;
      return view($viewName, compact('user', 'header_titulo', 'header_descripcion'));
  }

  private function returnAyudaIntroView($title, array $summary = [], array $sections = [], array $related = [], array $visuals = [], array $meta = [])
  {
      $user = auth()->user();
      $header_titulo = $title;
      $header_descripcion = '';

      return view('ayuda.intro_simple', compact(
          'user',
          'header_titulo',
          'header_descripcion',
          'title',
          'summary',
          'sections',
          'related',
          'visuals',
          'meta'
      ));
  }

  private function functionalSections(array $managedData, array $actions, array $usage, $result, array $checks = [], array $buttons = [])
  {
      $sections = [
          [
              'title' => 'Que datos se cargan o gestionan',
              'items' => $managedData,
          ],
          [
              'title' => 'Que acciones permite',
              'items' => $actions,
          ],
      ];

      if (!empty($buttons)) {
          $sections[] = [
              'title' => 'Botones y acciones disponibles',
              'items' => $buttons,
          ];
      }

      $sections[] = [
          'title' => 'Como se usa en la practica',
          'items' => $usage,
      ];

      if (!empty($checks)) {
          $sections[] = [
              'title' => 'Que revisar antes de guardar o cerrar',
              'items' => $checks,
          ];
      }

      $sections[] = [
          'title' => 'Resultado esperado',
          'paragraphs' => is_array($result) ? $result : [$result],
      ];

      return $sections;
  }

  public function openAyuda(){

    return $this->returnAyudaView('ayuda.ayuda_general', "", "");

  }

  public function cambiarClave(){

    return $this->returnAyudaView('ayuda.cambiar_clave');

  }

  public function BuscarFormularios(){

    return $this->returnAyudaView('ayuda.buscar_formularios');

  }

  public function VisualizarDocOperadores(){

    return $this->returnAyudaView('ayuda.visualizar_doc_operadores');

  }

  public function VisualizarGestionUsuario(){

    return $this->returnAyudaView('ayuda.gestion_usuario');

  }

  public function visualizarOt(){

    return $this->returnAyudaView('ayuda.visualizar_ot');

  }

  public function crearOt(){

    return $this->returnAyudaView('ayuda.crear_ot');

  }

  public function asignarOperadores(){

    return $this->returnAyudaView('ayuda.asignar_operadores');

  }

  public function asignarSoldadoresUsuarios(){

    return $this->returnAyudaView('ayuda.asignar_soldadores_usuarios');

  }

  public function generarInformes(){

    return $this->returnAyudaView('ayuda.generar_informes');

  }



  public function generarInformesRi(){

    return $this->returnAyudaView('ayuda.generar_informes_ri');

  }

  public function generarInformesUs(){

    return $this->returnAyudaView('ayuda.generar_informes_us');

  }

  public function generarInformesPm(){

    return $this->returnAyudaView('ayuda.generar_informes_pm');

  }

  public function generarInformesLp(){

    return $this->returnAyudaView('ayuda.generar_informes_lp');

  }
  public function asignarVehiculos(){

    return $this->returnAyudaView('ayuda.asignar_vehiculos');

  }

  public function visualizarVehiculos(){

    return $this->returnAyudaView('ayuda.visualizar_vehiculos');

  }

  public function AsignarProcedimientos(){

    return $this->returnAyudaView('ayuda.asignar_procedimientos');

  }

  public function visualizarProcedimientos(){

    return $this->returnAyudaView('ayuda.visualizar_procedimientos');

  }

  public function creacionRemito()
  {
      return $this->returnAyudaView('ayuda.creacion_remito');
  }

  public function gestionNormas()
  {
      return $this->returnAyudaIntroView(
          'Gestionar normas',
          [
              'Esta seccion administra las normas de ensayo, fabricacion y evaluacion que despues aparecen en servicios, OT e informes del sistema.',
              'Su uso es operativo: desde aqui se consultan registros existentes, se crean nuevas referencias y se corrigen codigos o descripciones antes de reutilizarlas en documentacion tecnica.',
          ],
          $this->functionalSections(
              [
                  'Listados separados de normas de ensayo, normas de fabricacion y normas de evaluacion.',
                  'Codigo y descripcion de cada norma para que quede identificada de forma clara.',
                  'Referencias tecnicas que despues se seleccionan en servicios, productos e informes.',
              ],
              [
                  'Consultar normas existentes desde el listado principal.',
                  'Crear nuevas normas cuando hace falta una referencia tecnica que todavia no existe.',
                  'Editar registros para corregir codigo, descripcion o criterio visible.',
                  'Eliminar normas que quedaron duplicadas o ya no deben usarse, segun permisos y relaciones existentes.',
                  'Buscar o paginar el listado cuando la cantidad de normas lo requiere.',
              ],
              [
                  'Se entra al listado del tipo de norma y se revisa si la referencia ya existe antes de darla de alta.',
                  'Si falta una norma, se usa Nuevo para cargar codigo y descripcion y dejarla disponible para seleccion posterior.',
                  'Si una referencia esta mal definida, se la edita desde el listado para unificar criterios en informes y maestros relacionados.',
              ],
              'La norma queda registrada y lista para reutilizarse en servicios, informes y otros documentos sin volver a escribirla manualmente.',
              [
                  'Que no exista otra norma equivalente con distinto codigo o descripcion.',
                  'Que el tipo de norma elegido sea el correcto para el uso posterior.',
              ],
              [
                  'Nuevo: crea una norma de ensayo, fabricacion o evaluacion segun la pantalla en la que se este trabajando.',
                  'Editar: permite corregir codigo o descripcion de una norma ya existente.',
                  'Eliminar: quita una norma del listado, previa confirmacion y siempre que no tenga relaciones bloqueantes.',
                  'Buscar: ayuda a localizar una norma puntual dentro del listado.',
              ]
          ),
          [
              ['href' => route('ayuda-gestion-servicios'), 'label' => 'Gestionar servicios'],
              ['href' => route('ayuda-generar-informes'), 'label' => 'Creacion de informes'],
              ['href' => route('ayuda-gestion-medidas'), 'label' => 'Gestionar medidas'],
          ],
          [
              'Captura del listado de normas por tipo.',
              'GIF de alta o edicion de una norma.',
          ],
          [
              'audience' => 'Operacion tecnica y administracion ENOD',
          ]
      );
  }

  public function gestionMedidas()
  {
      return $this->returnAyudaIntroView(
          'Gestionar medidas',
          [
              'Esta seccion administra las medidas que despues se seleccionan en productos y otros registros donde hace falta una referencia dimensional o tecnica repetible.',
              'La pantalla funciona como maestro base: permite consultar medidas cargadas, crear nuevas, corregirlas o depurarlas para que el resto del sistema trabaje con opciones consistentes.',
          ],
          $this->functionalSections(
              [
                  'Listado de medidas disponibles para productos u otras configuraciones.',
                  'Codigo, descripcion o referencia visible de cada medida.',
                  'Valores reutilizables para evitar carga libre repetida.',
              ],
              [
                  'Consultar medidas existentes desde la grilla del maestro.',
                  'Crear nuevas medidas cuando un producto o configuracion necesita una referencia que todavia no existe.',
                  'Editar medidas para corregir nombre o identificacion.',
                  'Eliminar registros duplicados o fuera de uso, si el sistema lo permite.',
              ],
              [
                  'Antes de crear una medida nueva se revisa el listado para no duplicar opciones equivalentes.',
                  'La medida se carga una sola vez y despues se reutiliza desde los selectores de otros modulos.',
                  'Cuando una medida cambia de criterio o nombre, se actualiza desde el mismo listado para mantener consistencia.',
              ],
              'La medida queda disponible como opcion reutilizable y evita diferencias de carga entre productos, formularios y maestros relacionados.',
              [
                  'Que la descripcion sea clara y no repita una medida ya existente.',
              ],
              [
                  'Nuevo: crea una medida para dejarla disponible en selectores y maestros relacionados.',
                  'Editar: modifica el nombre o identificacion de una medida existente.',
                  'Eliminar: quita una medida cuando ya no debe usarse o quedo duplicada.',
              ]
          ),
          [
              ['href' => route('ayuda-gestion-productos'), 'label' => 'Gestionar productos'],
              ['href' => route('ayuda-gestion-unidades-de-medida'), 'label' => 'Gestionar unidades de medida'],
              ['href' => route('ayuda-gestion-normas'), 'label' => 'Gestionar normas'],
          ],
          [
              'Captura del listado de medidas.',
          ],
          [
              'audience' => 'Operacion tecnica y configuracion de maestros',
          ]
      );
  }

  public function gestionarInternoFuente()
  {
      return $this->returnAyudaIntroView(
          'Gestionar internos de fuente',
          [
              'Esta seccion administra cada fuente individual del sistema, no solo el maestro general. Aqui se controla la unidad concreta que despues se consulta, se documenta o se traza.',
              'La pantalla permite revisar internos ya cargados, crear nuevos, editar datos operativos y eliminar registros cuando corresponde.',
          ],
          $this->functionalSections(
              [
                  'Identificacion unica de cada interno de fuente.',
                  'Vinculo con la fuente base y sus datos tecnicos.',
                  'Informacion util para trazabilidad, documentacion y consulta operativa.',
              ],
              [
                  'Consultar internos existentes en el listado.',
                  'Crear un nuevo interno cuando ingresa una fuente concreta al circuito.',
                  'Editar el interno para actualizar numero, estado o datos asociados.',
                  'Eliminar registros que no deben permanecer activos, segun permisos y relaciones existentes.',
                  'Buscar por identificacion o datos visibles del interno.',
              ],
              [
                  'Primero se verifica si la fuente base ya existe y luego se da de alta el interno individual.',
                  'Desde el listado se localiza cada unidad para corregir datos o revisar su estado antes de usarla en otro circuito.',
                  'La informacion del interno se mantiene actualizada para que QR, documentacion y reportes no queden desalineados.',
              ],
              'Cada fuente individual queda identificada y lista para integrarse con documentacion, trazabilidad y consultas posteriores.',
              [
                  'Que el interno este vinculado a la fuente correcta.',
                  'Que el identificador no se repita con otro registro activo.',
              ],
              [
                  'Nuevo: da de alta un interno de fuente nuevo.',
                  'Editar: actualiza numero, estado o datos operativos del interno.',
                  'Eliminar: quita el interno si ya no debe seguir activo y no tiene relaciones bloqueantes.',
                  'Buscar: localiza rapidamente una fuente individual dentro del listado.',
              ]
          ),
          [
              ['href' => route('ayuda-gestion-fuentes'), 'label' => 'Gestionar fuentes'],
              ['href' => route('ayuda-qr'), 'label' => 'QR y documentacion asociada'],
              ['href' => route('ayuda-reportes'), 'label' => 'Reportes'],
          ],
          [
              'Captura del listado de internos de fuente.',
              'GIF de alta o edicion del interno.',
          ],
          [
              'audience' => 'Operacion tecnica y trazabilidad',
          ]
      );
  }

  public function gestionCliente()
  {
      return $this->returnAyudaIntroView(
          'Gestionar clientes',
          [
              'Esta seccion administra los clientes con los que despues se trabaja en OT, usuarios cliente y documentacion del sistema.',
              'Desde el listado se consultan registros existentes, se crean clientes nuevos, se editan datos generales y contactos, y se eliminan registros cuando no tienen restricciones asociadas.',
          ],
          $this->functionalSections(
              [
                  'Codigo, nombre, razon social y datos administrativos del cliente.',
                  'Provincia, localidad, direccion, telefono, email y logo cuando aplica.',
                  'Contactos del cliente con nombre, cargo, telefono y correo.',
              ],
              [
                  'Buscar y filtrar clientes desde el listado principal.',
                  'Crear un cliente nuevo con sus datos generales y contactos.',
                  'Editar informacion existente para mantenerla actualizada.',
                  'Eliminar clientes cuando el perfil lo permite y no hay bloqueos por uso en otros circuitos.',
                  'Consultar el listado como base para futuras OT o usuarios cliente.',
              ],
              [
                  'Se revisa primero si el cliente ya existe para evitar duplicados.',
                  'Cuando falta, se usa Nuevo para completar datos generales y contactos de referencia.',
                  'Si cambia razon social, email o telefono, se corrige desde el mismo formulario para que OT y documentos usen informacion vigente.',
              ],
              'El cliente queda listo para seleccionarse en OT, documentacion y usuarios asociados sin volver a cargar datos en cada pantalla.',
              [
                  'Que los contactos principales esten completos y vigentes.',
                  'Que no exista otro cliente duplicado con nombre o razon social equivalente.',
              ],
              [
                  'Nuevo: crea un cliente con sus datos generales y contactos.',
                  'Editar: modifica razon social, direccion, telefono, email, logo o contactos del cliente.',
                  'Eliminar: quita un cliente del maestro si no tiene restricciones por uso en otros circuitos.',
                  'Buscar: filtra el listado por nombre, razon social u otros datos visibles.',
              ]
          ),
          [
              ['href' => route('ayuda-crear-ot'), 'label' => 'Como crear una OT'],
              ['href' => route('ayuda-gestion-comitente'), 'label' => 'Gestionar comitentes'],
              ['href' => route('ayuda-gestion-usuario'), 'label' => 'Gestionar usuarios'],
              ['href' => route('ayuda-visualizar-ot'), 'label' => 'Visualizacion general de la OT'],
          ],
          [
              'Captura del listado con buscador y acciones.',
              'GIF de alta o edicion de cliente.',
          ],
          [
              'audience' => 'Operacion comercial y administracion ENOD',
          ]
      );
  }

  public function gestionComitente()
  {
      return $this->returnAyudaIntroView(
          'Gestionar comitentes',
          [
              'Esta seccion administra los comitentes que despues se usan en OT, certificados y otros documentos donde hace falta distinguirlos del cliente.',
              'La pantalla permite consultar registros existentes, crear nuevos comitentes, editar datos visibles y eliminar aquellos que no deban seguir activos.',
          ],
          $this->functionalSections(
              [
                  'Nombre o identificacion visible del comitente.',
                  'Datos administrativos basicos que luego se muestran en cabeceras documentales.',
                  'Referencia diferenciada del cliente cuando ambas entidades no coinciden.',
              ],
              [
                  'Consultar comitentes existentes desde el listado.',
                  'Crear nuevos registros para usarlos en futuras OT o certificados.',
                  'Editar razon social, descripcion o datos visibles cuando cambian.',
                  'Eliminar comitentes si ya no corresponden y no tienen relaciones bloqueantes.',
              ],
              [
                  'Se revisa el listado para confirmar si el comitente ya existe antes de darlo de alta.',
                  'Si el circuito documental necesita diferenciar cliente y comitente, se lo registra para dejar esa seleccion disponible.',
                  'Cuando cambia la entidad visible en cabeceras o certificados, se actualiza desde este maestro.',
              ],
              'El comitente queda disponible como referencia estable en OT, certificados y documentos relacionados, sin mezclarlo con el cliente cuando ambos roles son distintos.',
              [
                  'Que el comitente no este duplicado bajo otra razon social o nombre equivalente.',
              ],
              [
                  'Nuevo: crea un comitente nuevo para futuras OT o certificados.',
                  'Editar: corrige razon social o datos visibles del comitente.',
                  'Eliminar: quita un comitente si no debe seguir disponible.',
                  'Buscar: ayuda a localizar rapidamente un registro existente.',
              ]
          ),
          [
              ['href' => route('ayuda-gestion-cliente'), 'label' => 'Gestionar clientes'],
              ['href' => route('ayuda-crear-ot'), 'label' => 'Como crear una OT'],
              ['href' => route('ayuda-crear-certificados'), 'label' => 'Creacion de certificados'],
          ],
          [
              'Captura del listado de comitentes.',
              'GIF de alta o edicion de comitente.',
          ],
          [
              'audience' => 'Operacion comercial y documentacion',
          ]
      );
  }

  public function gestionDocumentaciones()
  {
      return $this->returnAyudaIntroView(
          'Gestionar documentaciones',
          [
              'Esta seccion administra la documentacion del sistema y permite cargar archivos, clasificarlos, filtrarlos y mantener vigente la informacion asociada.',
              'Desde aqui se consulta el listado documental, se crean registros nuevos, se editan documentos existentes, se eliminan cuando corresponde y se descargan archivos para uso operativo.',
          ],
          $this->functionalSections(
              [
                  'Tipo de documento, titulo, descripcion y fecha de vencimiento.',
                  'Entidad asociada segun el documento: OT, usuario, equipo, fuente, vehiculo u otro circuito soportado.',
                  'Archivo digital y datos de visibilidad o clasificacion.',
              ],
              [
                  'Consultar el listado de documentos cargados.',
                  'Buscar por texto, filtrar por tipo y mostrar documentacion vencida.',
                  'Crear documentos nuevos con su archivo asociado.',
                  'Editar registros existentes para corregir datos, archivo o vencimiento.',
                  'Eliminar documentos cuando ya no corresponden.',
                  'Descargar uno o varios documentos desde el listado.',
              ],
              [
                  'Se usa el listado para localizar documentacion por tipo o por entidad asociada.',
                  'Cuando falta un archivo, se crea un registro nuevo y se adjunta el documento correspondiente.',
                  'Si cambia un vencimiento o una descripcion, se corrige desde el mismo modulo para que controles y consultas queden actualizados.',
              ],
              'La documentacion queda clasificada, accesible y alineada con equipos, vehiculos, usuarios u OT que dependen de ella.',
              [
                  'Que el tipo de documento y la entidad asociada sean los correctos.',
                  'Que el vencimiento este bien cargado cuando aplica control documental.',
              ],
              [
                  'Nuevo: crea un documento nuevo y permite adjuntar el archivo correspondiente.',
                  'Editar: corrige tipo, descripcion, vencimiento, entidad asociada o archivo del documento.',
                  'Eliminar: quita documentacion cuando ya no debe permanecer en el sistema.',
                  'Buscar y filtrar: localiza documentos por texto, tipo o vencimiento.',
                  'Descargar: permite bajar uno o varios documentos desde el listado.',
              ]
          ),
          [
              ['href' => route('ayuda-gestion-vehiculos'), 'label' => 'Gestionar vehiculos'],
              ['href' => route('ayuda-visualizar-vehiculos'), 'label' => 'Visualizar vehiculos y documentacion complementaria'],
              ['href' => route('ayuda-gestion-equipos'), 'label' => 'Gestionar equipos'],
          ],
          [
              'Captura del listado de documentaciones.',
          ],
          [
              'audience' => 'Operacion tecnica y control documental',
          ]
      );
  }

  public function gestionEquipos()
  {
      return $this->returnAyudaIntroView(
          'Gestionar equipos',
          [
              'Esta seccion administra el maestro general de equipos que despues alimenta internos, informes y documentacion tecnica.',
              'La pantalla permite consultar equipos existentes, darlos de alta, editar su definicion tecnica y eliminar registros cuando ya no deben formar parte del catalogo.',
          ],
          $this->functionalSections(
              [
                  'Codigo y descripcion del equipo.',
                  'Metodo de ensayo, tipo de equipamiento e instrumento de medicion.',
                  'Condiciones especiales del equipo, como marcacion para US cuando corresponde.',
              ],
              [
                  'Consultar el listado general de equipos.',
                  'Buscar equipos por codigo, descripcion o datos visibles.',
                  'Crear un equipo nuevo desde el formulario de alta.',
                  'Editar informacion tecnica de un equipo existente.',
                  'Eliminar equipos del maestro, segun permisos y uso posterior.',
              ],
              [
                  'Primero se revisa el listado para evitar duplicar equipos que ya existen.',
                  'Si hace falta una referencia nueva, se usa Nuevo y se completan los datos tecnicos que luego consumen otros modulos.',
                  'Cuando cambia un criterio tecnico, se actualiza el maestro para que informes e internos trabajen con la misma definicion.',
              ],
              'El equipo queda disponible como referencia base para internos, documentacion e informes sin necesidad de recrearlo en cada circuito.',
              [
                  'Que el metodo de ensayo y el tipo de equipamiento sean los correctos.',
              ],
              [
                  'Nuevo: crea un equipo nuevo dentro del maestro general.',
                  'Editar: modifica datos tecnicos del equipo existente.',
                  'Eliminar: quita un equipo del catalogo si no debe seguir disponible.',
                  'Buscar: ayuda a ubicar equipos por codigo o descripcion.',
              ]
          ),
          [
              ['href' => route('ayuda-gestion-interno-equipos'), 'label' => 'Gestionar internos de equipos'],
              ['href' => route('ayuda-qr'), 'label' => 'QR y documentacion asociada'],
              ['href' => route('ayuda-reportes'), 'label' => 'Reportes'],
          ],
          [
              'Captura del listado de equipos.',
              'GIF de alta o edicion del maestro.',
          ],
          [
              'audience' => 'Operacion tecnica y trazabilidad',
          ]
      );
  }

  public function gestionFuentes()
  {
      return $this->returnAyudaIntroView(
          'Gestionar fuentes',
          [
              'Esta seccion administra el maestro general de fuentes que despues se individualizan mediante internos y se vinculan con documentacion o trazabilidad.',
              'Funciona como catalogo base: desde el listado se consultan fuentes cargadas, se crean nuevas referencias, se editan datos tecnicos y se eliminan registros cuando corresponde.',
          ],
          $this->functionalSections(
              [
                  'Catalogo general de fuentes con sus datos identificatorios y tecnicos.',
                  'Informacion base que despues se reutiliza en internos de fuente.',
                  'Referencias necesarias para consultas, QR y documentacion asociada.',
              ],
              [
                  'Consultar el listado de fuentes ya registradas.',
                  'Crear nuevas fuentes cuando hace falta una referencia base para el circuito.',
                  'Editar datos tecnicos o identificatorios.',
                  'Eliminar fuentes del maestro si no deben seguir activas y no estan bloqueadas por relaciones.',
              ],
              [
                  'Se revisa el maestro para verificar si la fuente ya fue cargada antes de crear otra.',
                  'La referencia base se completa una sola vez y luego se usa para dar de alta internos individuales.',
                  'Cuando cambia la definicion tecnica de la fuente, se ajusta aqui para mantener trazabilidad consistente.',
              ],
              'La fuente queda disponible como base para internos, documentacion y consultas operativas posteriores.',
              [],
              [
                  'Nuevo: crea una fuente base nueva para el catalogo.',
                  'Editar: corrige datos tecnicos o identificatorios de la fuente.',
                  'Eliminar: quita una fuente del maestro cuando ya no corresponde seguir usandola.',
                  'Buscar: localiza rapidamente una fuente dentro del listado.',
              ]
          ),
          [
              ['href' => route('ayuda-gestion-interno-fuente'), 'label' => 'Gestionar internos de fuente'],
              ['href' => route('ayuda-qr'), 'label' => 'QR y documentacion asociada'],
              ['href' => route('ayuda-reportes'), 'label' => 'Reportes'],
          ],
          [
              'Captura del listado de fuentes.',
              'GIF de alta o edicion del maestro.',
          ],
          [
              'audience' => 'Operacion tecnica y trazabilidad',
          ]
      );
  }

  public function gestionInternoEquipos()
  {
      return $this->returnAyudaIntroView(
          'Gestionar internos de equipos',
          [
              'Esta seccion administra cada unidad concreta de equipo dentro del sistema, a partir del maestro general de equipos.',
              'Desde aqui se consultan internos existentes, se crean nuevas unidades, se editan sus datos operativos y se eliminan registros cuando corresponde.',
          ],
          $this->functionalSections(
              [
                  'Identificacion unica del interno de equipo.',
                  'Relacion con el equipo base del cual depende.',
                  'Datos visibles para documentacion, QR y trazabilidad.',
              ],
              [
                  'Consultar el listado de internos ya cargados.',
                  'Crear un interno nuevo cuando se incorpora una unidad operativa concreta.',
                  'Editar datos del interno para actualizar su identificacion o estado.',
                  'Eliminar registros cuando ya no correspondan y el sistema lo permita.',
                  'Buscar internos por numero o datos visibles.',
              ],
              [
                  'Primero se confirma que el equipo base exista en el maestro general.',
                  'Despues se da de alta el interno con su identificacion particular para diferenciar esa unidad del resto.',
                  'El listado se usa luego para corregir datos o localizar rapidamente el interno antes de consultar documentacion o QR.',
              ],
              'Cada interno queda individualizado y listo para integrarse con documentacion, consultas QR y trazabilidad.',
              [],
              [
                  'Nuevo: da de alta una unidad operativa concreta a partir del equipo base.',
                  'Editar: actualiza identificacion o datos del interno.',
                  'Eliminar: quita el interno cuando ya no debe permanecer activo.',
                  'Buscar: ayuda a encontrar rapidamente el interno en el listado.',
              ]
          ),
          [
              ['href' => route('ayuda-gestion-equipos'), 'label' => 'Gestionar equipos'],
              ['href' => route('ayuda-qr'), 'label' => 'QR y documentacion asociada'],
              ['href' => route('ayuda-gestion-documentaciones'), 'label' => 'Gestionar documentaciones'],
              ['href' => route('ayuda-reportes'), 'label' => 'Reportes'],
          ],
          [
              'Captura del listado de internos de equipos.',
              'GIF de alta o edicion del interno.',
          ],
          [
              'audience' => 'Operacion tecnica y trazabilidad',
          ]
      );
  }

  public function gestionMateriales()
  {
      return $this->returnAyudaIntroView(
          'Gestionar materiales',
          [
              'Esta seccion administra el maestro de materiales que despues aparece en informes, procedimientos y otras referencias tecnicas del sistema.',
              'La pantalla permite consultar materiales existentes, crear nuevos, editar descripciones y eliminar registros cuando ya no deben usarse.',
          ],
          $this->functionalSections(
              [
                  'Codigo y descripcion de cada material.',
                  'Referencias tecnicas reutilizables en distintos formularios.',
                  'Catalogo base para informes y procedimientos relacionados.',
              ],
              [
                  'Consultar el listado de materiales cargados.',
                  'Buscar materiales por codigo o descripcion.',
                  'Crear nuevos materiales cuando hace falta una referencia que no existe.',
                  'Editar registros para corregir nombre o codigo.',
                  'Eliminar materiales duplicados o fuera de uso, segun permisos.',
              ],
              [
                  'Se usa el listado para verificar si el material ya existe antes de cargarlo nuevamente.',
                  'Si falta, se crea desde el formulario simple del maestro y queda disponible para futuras selecciones.',
                  'Cuando aparece una diferencia de nomenclatura, se corrige en este modulo para unificar el criterio tecnico.',
              ],
              'El material queda listo para reutilizarse en informes y otras configuraciones sin variantes innecesarias.',
              [],
              [
                  'Nuevo: crea un material nuevo dentro del maestro.',
                  'Editar: modifica codigo o descripcion del material.',
                  'Eliminar: quita materiales duplicados o fuera de uso.',
                  'Buscar: localiza materiales por codigo o descripcion.',
              ]
          ),
          [
              ['href' => route('ayuda-generar-informes'), 'label' => 'Creacion de informes'],
              ['href' => route('ayuda-gestion-productos'), 'label' => 'Gestionar productos'],
              ['href' => route('ayuda-gestion-normas'), 'label' => 'Gestionar normas'],
          ],
          [
              'Captura del listado de materiales.',
          ],
          [
              'audience' => 'Operacion tecnica y configuracion de maestros',
          ]
      );
  }

  public function gestionProductos()
  {
      return $this->returnAyudaIntroView(
          'Gestionar productos',
          [
              'Esta seccion administra el catalogo general de productos que despues pueden intervenir en stock, OT, remitos y otros circuitos operativos.',
              'La pantalla no solo registra productos: tambien define si son stockeables, si se muestran en OT y como se comportan frente a placas u otros usos relacionados.',
          ],
          $this->functionalSections(
              [
                  'Codigo, descripcion, metros totales y unidad de medida del producto.',
                  'Definicion de si el producto es visible en OT, stockeable o relacionado a placas.',
                  'Grupo o criterio de clasificacion cuando el circuito lo usa.',
                  'Stock actual si el producto participa del modulo de stock.',
              ],
              [
                  'Consultar el listado de productos existentes.',
                  'Buscar por codigo o descripcion y aplicar filtros como stockeable o relacionado a placas.',
                  'Crear productos nuevos desde el formulario de alta.',
                  'Editar registros existentes para corregir propiedades o datos base.',
                  'Eliminar productos cuando no deben seguir activos y no hay restricciones por uso o stock.',
              ],
              [
                  'Se usa el listado para revisar si el producto ya existe y para entender como esta configurado dentro del circuito.',
                  'Cuando falta un producto, se crea indicando si debe impactar en stock y si tiene que ser visible en OT.',
                  'Si cambia su comportamiento operativo, se edita desde el maestro para que stock, remitos y OT lean la misma configuracion.',
              ],
              'El producto queda listo para usarse como referencia operativa y, si corresponde, para integrarse con stock, movimientos, OT y remitos.',
              [
                  'Que la unidad de medida sea la correcta.',
                  'Que el criterio de stockeable o visible OT refleje el uso real del producto.',
              ],
              [
                  'Nuevo: crea un producto y define si es visible en OT, stockeable o relacionado a placas.',
                  'Editar: modifica propiedades y datos base del producto.',
                  'Eliminar: quita un producto cuando no tiene restricciones por stock o relaciones vigentes.',
                  'Buscar: filtra el listado por codigo o descripcion.',
                  'Filtros: permiten ver solo productos stockeables o relacionados a placas.',
              ]
          ),
          [
              ['href' => route('ayuda-stock'), 'label' => 'Gestion de stock'],
              ['href' => route('ayuda-creacion-remito'), 'label' => 'Remitos'],
              ['href' => route('ayuda-gestion-unidades-de-medida'), 'label' => 'Gestionar unidades de medida'],
              ['href' => route('ayuda-crear-ot'), 'label' => 'Como crear una OT'],
          ],
          [
              'Captura del listado de productos.',
              'GIF de alta o edicion de producto.',
          ],
          [
              'audience' => 'Operacion interna, stock y administracion tecnica',
          ]
      );
  }

  public function gestionServicios()
  {
      return $this->returnAyudaIntroView(
          'Gestionar servicios',
          [
              'Esta seccion administra el catalogo de servicios que despues se usa en OT, informes y otros circuitos del sistema.',
              'Desde aqui se consultan servicios existentes, se crean nuevos, se editan sus datos y se eliminan registros cuando dejan de ser validos para la operacion.',
          ],
          $this->functionalSections(
              [
                  'Codigo, descripcion y abreviatura del servicio.',
                  'Unidad de medida con la que se cuantifica.',
                  'Metodo de ensayo asociado, que despues impacta en informes y circuitos tecnicos.',
              ],
              [
                  'Consultar el listado de servicios cargados.',
                  'Buscar por codigo, descripcion, unidad o metodo de ensayo.',
                  'Crear un servicio nuevo desde el formulario de alta.',
                  'Editar un servicio para ajustar codigo, descripcion, unidad o metodo.',
                  'Eliminar servicios cuando ya no deben usarse y no hay restricciones por relaciones vigentes.',
              ],
              [
                  'Se verifica primero si el servicio ya existe para no duplicar prestaciones equivalentes.',
                  'Cuando hace falta uno nuevo, se carga con su unidad y metodo para que despues pueda seleccionarse correctamente en la OT.',
                  'Si cambia el criterio tecnico o comercial del servicio, se actualiza aqui para que el resto del circuito consuma la misma definicion.',
              ],
              'El servicio queda listo para seleccionarse en OT y habilitar luego informes, partes y otros documentos vinculados.',
              [
                  'Que la unidad de medida y el metodo de ensayo correspondan al servicio real.',
              ],
              [
                  'Nuevo: crea un servicio nuevo con su unidad de medida y metodo de ensayo.',
                  'Editar: corrige codigo, descripcion, abreviatura, unidad o metodo.',
                  'Eliminar: quita un servicio cuando ya no debe usarse y no tiene bloqueos por relaciones.',
                  'Buscar: localiza servicios por codigo, descripcion o metodo.',
              ]
          ),
          [
              ['href' => route('ayuda-crear-ot'), 'label' => 'Como crear una OT'],
              ['href' => route('ayuda-generar-informes'), 'label' => 'Creacion de informes'],
              ['href' => route('ayuda-gestion-unidades-de-medida'), 'label' => 'Gestionar unidades de medida'],
              ['href' => route('ayuda-gestion-normas'), 'label' => 'Gestionar normas'],
          ],
          [
              'Captura del listado de servicios.',
              'GIF de alta o edicion de servicio.',
          ],
          [
              'audience' => 'Operacion comercial y tecnica',
          ]
      );
  }

  public function gestionSoldadores()
  {
      return $this->returnAyudaIntroView(
          'Gestionar soldadores',
          [
              'Esta seccion administra el maestro de soldadores que despues puede asignarse a OT e informes cuando el circuito lo necesita.',
              'Desde el listado se consultan soldadores existentes, se crean nuevos registros, se editan datos visibles y se eliminan referencias cuando corresponde.',
          ],
          $this->functionalSections(
              [
                  'Identificacion y datos visibles del soldador.',
                  'Listado base para asignaciones posteriores en OT o informes.',
                  'Referencia operativa reutilizable en trazabilidad tecnica.',
              ],
              [
                  'Consultar soldadores cargados en el maestro.',
                  'Buscar por nombre, codigo o datos visibles si la pantalla lo permite.',
                  'Crear nuevos soldadores.',
                  'Editar datos existentes para mantenerlos actualizados.',
                  'Eliminar registros cuando ya no deban estar disponibles.',
              ],
              [
                  'Se revisa primero si el soldador ya existe antes de cargarlo nuevamente.',
                  'Si falta en el maestro, se registra para que quede disponible en asignaciones y formularios dependientes.',
                  'Cuando cambian datos identificatorios, se corrige desde el maestro para no arrastrar diferencias en informes.',
              ],
              'El soldador queda listo para seleccionarse en OT y para sostener trazabilidad en los modulos que lo utilizan.',
              [],
              [
                  'Nuevo: crea un soldador nuevo en el maestro.',
                  'Editar: actualiza datos identificatorios del soldador.',
                  'Eliminar: quita una referencia que ya no debe usarse.',
                  'Buscar: ayuda a ubicar soldadores dentro del listado.',
              ]
          ),
          [
              ['href' => route('ayuda-asignar-soldadores-y-usuarios'), 'label' => 'Asignar soldadores y usuarios de cliente'],
              ['href' => route('ayuda-generar-informes'), 'label' => 'Creacion de informes'],
              ['href' => route('ayuda-visualizar-ot'), 'label' => 'Visualizacion general de la OT'],
          ],
          [
              'Captura del listado de soldadores.',
              'GIF de alta o edicion del maestro.',
          ],
          [
              'audience' => 'Operacion tecnica',
          ]
      );
  }

  public function gestionUnidadesDeMedida()
  {
      return $this->returnAyudaIntroView(
          'Gestionar unidades de medida',
          [
              'Esta seccion administra las unidades de medida reutilizables en productos, servicios y otros maestros del sistema.',
              'La pantalla permite consultar unidades existentes, crear nuevas, editar sus datos y eliminar registros cuando no corresponde seguir utilizandolos.',
          ],
          $this->functionalSections(
              [
                  'Codigo y descripcion de cada unidad de medida.',
                  'Catalogo base para productos, servicios y otros registros que manejan cantidades.',
                  'Referencias uniformes para evitar variantes de escritura.',
              ],
              [
                  'Consultar el listado de unidades cargadas.',
                  'Crear nuevas unidades desde el formulario del maestro.',
                  'Editar unidades existentes para corregir codigo o descripcion.',
                  'Eliminar registros duplicados o fuera de uso, segun permisos.',
              ],
              [
                  'Antes de crear una unidad nueva se revisa el listado para no duplicar abreviaturas o nombres.',
                  'La unidad se carga una sola vez y luego se reutiliza desde otros formularios.',
                  'Si cambia una descripcion o se necesita ordenar el catalogo, se actualiza desde esta pantalla.',
              ],
              'La unidad queda disponible como opcion estable para productos, servicios y otros modulos que trabajan con cantidades.',
              [],
              [
                  'Nuevo: crea una unidad de medida nueva.',
                  'Editar: corrige codigo o descripcion de la unidad.',
                  'Eliminar: quita unidades duplicadas o fuera de uso.',
              ]
          ),
          [
              ['href' => route('ayuda-gestion-productos'), 'label' => 'Gestionar productos'],
              ['href' => route('ayuda-gestion-servicios'), 'label' => 'Gestionar servicios'],
              ['href' => route('ayuda-gestion-medidas'), 'label' => 'Gestionar medidas'],
          ],
          [
              'Captura del listado de unidades de medida.',
          ],
          [
              'audience' => 'Configuracion de maestros y operacion tecnica',
          ]
      );
  }

  public function gestionarRoles()
  {
      return $this->returnAyudaIntroView(
          'Gestionar roles',
          [
              'Esta seccion administra los roles del sistema y define que puede ver o hacer cada tipo de usuario a traves del conjunto de permisos asignados.',
              'Desde el listado se consultan roles existentes, se crean nuevos, se editan permisos y configuraciones, y se eliminan roles cuando ya no deben seguir usandose.',
          ],
          $this->functionalSections(
              [
                  'Nombre del rol y guard correspondiente.',
                  'Conjunto de permisos que define accesos a modulos y acciones.',
                  'Configuracion base que despues se asigna a usuarios.',
              ],
              [
                  'Consultar el listado de roles definidos.',
                  'Crear roles nuevos con su nombre, guard y permisos asociados.',
                  'Editar roles para ajustar permisos o datos del perfil.',
                  'Eliminar roles cuando dejan de ser necesarios y no hay riesgos de uso incorrecto.',
                  'Revisar desde el listado que roles existen antes de crear uno nuevo.',
              ],
              [
                  'Se usa la pantalla para agrupar permisos bajo un perfil coherente, en vez de asignarlos usuario por usuario.',
                  'Cuando un puesto nuevo necesita otro alcance, se crea o ajusta un rol desde este modulo.',
                  'Si un usuario no accede a una accion esperada, este maestro sirve para revisar si el rol tiene los permisos correctos.',
              ],
              'El rol queda listo para asignarse a usuarios y sostener accesos coherentes dentro del sistema.',
              [
                  'Que el rol no replique otro perfil ya existente con los mismos permisos.',
                  'Que los permisos marcados respondan al alcance real del usuario final.',
              ],
              [
                  'Nuevo: crea un rol nuevo con su nombre, guard y permisos.',
                  'Editar: ajusta permisos o datos del rol existente.',
                  'Eliminar: quita un rol cuando ya no debe seguir en uso y la operacion lo permite.',
                  'Consultar listado: sirve para revisar perfiles antes de asignarlos a usuarios.',
              ]
          ),
          [
              ['href' => route('ayuda-gestion-permisos'), 'label' => 'Gestionar permisos'],
              ['href' => route('ayuda-gestion-usuario'), 'label' => 'Gestionar usuarios'],
              ['href' => route('ayuda-perfil'), 'label' => 'Perfil de usuario'],
          ],
          [
              'Captura del listado de roles.',
              'GIF de alta o ajuste de un rol.',
          ],
          [
              'audience' => 'Administracion y sistemas ENOD',
          ]
      );
  }

  public function visualizarInformes()
  {
      return $this->returnAyudaView('ayuda.visualizacion_infomres');
  }

  public function crearParteDiario()
  {
      return $this->returnAyudaView('ayuda.crear_parte_diario');
  }

  public function visualizarParteDiario()
  {
      return $this->returnAyudaView('ayuda.visualizar_parte_diario');
  }

  public function crearCertificados()
  {
      return $this->returnAyudaView('ayuda.crear_certificados');
  }

  public function visualizarCertificados()
  {
      return $this->returnAyudaView('ayuda.visualizar_certificados');
  }

  public function perfil()
  {
      return $this->returnAyudaIntroView(
          'Perfil de usuario',
          [
              'Esta seccion concentra las acciones personales del usuario dentro del sistema: revisar sus datos, mantener la cuenta actualizada y validar informacion de uso diario.',
              'No es solo una vista informativa. Desde aqui se consultan datos propios, se editan campos disponibles y se corrigen inconsistencias que impactan en acceso o identificacion.',
          ],
          $this->functionalSections(
              [
                  'Datos personales y de identificacion visibles para la cuenta.',
                  'Informacion de contacto y datos que otros circuitos usan como referencia.',
                  'Configuraciones basicas asociadas al usuario actual.',
              ],
              [
                  'Consultar la informacion personal cargada en la cuenta.',
                  'Editar datos disponibles desde el propio perfil.',
                  'Validar que la informacion visible y de contacto este actualizada.',
              ],
              [
                  'Se usa al ingresar por primera vez o cuando cambia algun dato personal relevante.',
                  'Tambien sirve para revisar si la cuenta esta alineada con el uso real antes de analizar un problema de acceso o identificacion.',
              ],
              'El usuario deja su cuenta actualizada y reduce inconsistencias en modulos que dependen de sus datos.',
              [],
              [
                  'Editar perfil: permite modificar datos disponibles de la cuenta.',
                  'Guardar: aplica los cambios cargados en el perfil.',
              ]
          ),
          [
              ['href' => route('ayuda-cambiar-clave'), 'label' => 'Como cambiar o restablecer la contrasena'],
              ['href' => route('ayuda-buscar-formularios'), 'label' => 'Buscar en los formularios de la aplicacion'],
              ['href' => route('ayuda-gestion-usuario'), 'label' => 'Gestionar usuarios'],
          ],
          [
              'Captura del acceso al perfil desde el menu principal.',
              'GIF corto de edicion de datos personales y guardado.',
          ]
      );
  }

  public function gestionProveedores()
  {
      return $this->returnAyudaIntroView(
          'Gestionar proveedores',
          [
              'Esta seccion administra los proveedores vinculados al circuito de productos, stock y movimientos internos.',
              'La pantalla permite consultar proveedores existentes, crear nuevos, editar datos de contacto o razon social y eliminar registros cuando corresponde.',
          ],
          $this->functionalSections(
              [
                  'Datos identificatorios y de contacto del proveedor.',
                  'Referencia reutilizable para compras, stock o movimientos asociados.',
                  'Base de seleccion en circuitos donde el origen del producto importa.',
              ],
              [
                  'Consultar el listado de proveedores cargados.',
                  'Crear proveedores nuevos.',
                  'Editar razon social, telefono, email u otros datos visibles.',
                  'Eliminar proveedores cuando ya no deben seguir activos y no hay relaciones bloqueantes.',
              ],
              [
                  'Se revisa el listado antes de crear un proveedor para evitar duplicados.',
                  'Si el abastecimiento o el movimiento necesita asociar origen, el proveedor debe quedar cargado previamente.',
                  'Cuando cambia un dato de contacto o razon social, se ajusta desde este modulo para no replicar errores en otras pantallas.',
              ],
              'El proveedor queda disponible como referencia operativa y administrativa para stock, movimientos y consultas posteriores.',
              [],
              [
                  'Nuevo: crea un proveedor nuevo para usarlo en stock o movimientos.',
                  'Editar: corrige razon social, telefono, email u otros datos visibles.',
                  'Eliminar: quita un proveedor que ya no debe estar activo.',
                  'Buscar: ayuda a localizar proveedores dentro del listado.',
              ]
          ),
          [
              ['href' => route('ayuda-stock'), 'label' => 'Gestion de stock'],
              ['href' => route('ayuda-gestion-productos'), 'label' => 'Gestionar productos'],
              ['href' => route('ayuda-creacion-remito'), 'label' => 'Remitos'],
          ],
          [
              'Captura del listado con filtros y acciones principales.',
              'GIF de alta y edicion de un proveedor.',
          ]
      );
  }

  public function gestionFrentes()
  {
      return $this->returnAyudaIntroView(
          'Gestionar frentes',
          [
              'Esta seccion administra los frentes que se usan como origen, destino o ubicacion operativa de recursos y movimientos.',
              'La pantalla permite consultar frentes cargados, crear nuevos, editar referencias visibles y eliminar registros cuando ya no deben usarse.',
          ],
          $this->functionalSections(
              [
                  'Nombre o identificacion del frente.',
                  'Referencia operativa para ubicar recursos, remitos o movimientos.',
                  'Dato organizador para trazabilidad interna.',
              ],
              [
                  'Consultar frentes existentes.',
                  'Crear frentes nuevos.',
                  'Editar referencias visibles del frente.',
                  'Eliminar registros cuando no deben seguir disponibles.',
              ],
              [
                  'Se usa este maestro para dejar definido el destino u origen antes de registrar movimientos.',
                  'Tambien sirve para ordenar consultas internas cuando hace falta saber donde quedo un recurso o desde donde salio.',
              ],
              'Cada frente queda disponible como referencia estable para evitar movimientos ambiguos y asignaciones sin ubicacion clara.',
              [],
              [
                  'Nuevo: crea un frente nuevo.',
                  'Editar: modifica la referencia visible del frente.',
                  'Eliminar: quita frentes que ya no deben usarse.',
              ]
          ),
          [
              ['href' => route('ayuda-creacion-remito'), 'label' => 'Remitos'],
              ['href' => route('ayuda-stock'), 'label' => 'Gestion de stock'],
              ['href' => route('ayuda-gestion-interno-equipos'), 'label' => 'Gestionar internos de equipos'],
          ],
          [
              'Captura del listado de frentes y formulario de alta.',
          ]
      );
  }

  public function gestionVehiculos()
  {
      return $this->returnAyudaIntroView(
          'Gestionar vehiculos',
          [
              'Esta seccion administra los vehiculos disponibles para la operacion y su informacion base antes de asignarlos a una OT.',
              'Desde aqui se consultan vehiculos existentes, se crean nuevos, se editan sus datos y se elimina un registro cuando ya no debe formar parte del circuito.',
          ],
          $this->functionalSections(
              [
                  'Identificacion del vehiculo y datos visibles del registro.',
                  'Informacion documental o de vigencia asociada.',
                  'Datos necesarios para asignacion y control posterior.',
              ],
              [
                  'Consultar el listado de vehiculos cargados.',
                  'Crear vehiculos nuevos.',
                  'Editar informacion existente o documentacion asociada.',
                  'Eliminar registros cuando ya no deben estar disponibles.',
              ],
              [
                  'Se usa este maestro antes de asignar un vehiculo a una OT.',
                  'Cuando cambia la documentacion o la identificacion del vehiculo, se corrige aqui para que la OT use datos vigentes.',
              ],
              'El vehiculo queda listo para asignacion y consulta posterior con una referencia consistente dentro del sistema.',
              [],
              [
                  'Nuevo: crea un vehiculo nuevo dentro del maestro.',
                  'Editar: actualiza identificacion, datos o documentacion asociada.',
                  'Eliminar: quita vehiculos que ya no deben seguir disponibles.',
                  'Buscar: ayuda a ubicar rapidamente el vehiculo dentro del listado.',
              ]
          ),
          [
              ['href' => route('ayuda-asignar-vehiculos'), 'label' => 'Asignar vehiculos y documentacion complementaria'],
              ['href' => route('ayuda-visualizar-vehiculos'), 'label' => 'Visualizar vehiculos y documentacion complementaria'],
              ['href' => route('ayuda-visualizar-ot'), 'label' => 'Visualizacion general de la OT'],
          ],
          [
              'GIF de alta y edicion de vehiculos.',
              'Captura de vigencias o documentacion asociada.',
          ]
      );
  }

  public function gestionPlantas()
  {
      return $this->returnAyudaIntroView(
          'Gestionar plantas',
          [
              'Esta seccion administra plantas o sedes que despues pueden asociarse a clientes, operaciones u otras referencias del sistema.',
              'La pantalla permite consultar plantas existentes, crear nuevas, editar datos visibles y eliminar registros cuando dejan de ser necesarios.',
          ],
          $this->functionalSections(
              [
                  'Nombre o identificacion de la planta.',
                  'Referencia de ubicacion para clientes u operaciones.',
                  'Dato util para filtros y seleccion en otros modulos.',
              ],
              [
                  'Consultar el listado de plantas.',
                  'Crear plantas nuevas.',
                  'Editar registros existentes.',
                  'Eliminar plantas cuando ya no corresponden.',
              ],
              [
                  'Se carga una planta cuando hace falta distinguir sedes o ubicaciones concretas en otros circuitos.',
                  'Tambien se usa para ordenar filtros o referencias visibles en pantallas relacionadas.',
              ],
              'La planta queda disponible como referencia estable para seleccion y filtrado en modulos relacionados.',
              [],
              [
                  'Nuevo: crea una planta nueva.',
                  'Editar: modifica datos visibles de la planta.',
                  'Eliminar: quita una planta que ya no debe usarse.',
              ]
          ),
          [
              ['href' => route('ayuda-gestion-cliente'), 'label' => 'Gestionar clientes'],
              ['href' => route('ayuda-gestion-comitente'), 'label' => 'Gestionar comitentes'],
              ['href' => route('ayuda-general'), 'label' => 'Ayuda general'],
          ],
          [
              'Captura del listado y formulario de planta.',
          ]
      );
  }

  public function gestionContratistas()
  {
      return $this->returnAyudaIntroView(
          'Gestionar contratistas',
          [
              'Esta seccion administra los contratistas o terceros que participan en tareas operativas del sistema.',
              'La pantalla permite consultar registros existentes, crear nuevos, editar datos visibles y eliminar contratistas cuando corresponde.',
          ],
          $this->functionalSections(
              [
                  'Datos identificatorios y de contacto del contratista.',
                  'Referencia reutilizable para asistencia y otras cargas operativas.',
                  'Base para trazabilidad de intervencion externa.',
              ],
              [
                  'Consultar contratistas existentes.',
                  'Crear nuevos registros.',
                  'Editar datos administrativos o de contacto.',
                  'Eliminar contratistas cuando ya no deben figurar en el maestro.',
              ],
              [
                  'Se usa este maestro antes de registrar asistencia o tareas vinculadas a terceros.',
                  'Cuando cambia la informacion visible de la empresa externa, se actualiza aqui para mantener las consultas consistentes.',
              ],
              'El contratista queda disponible como entidad reutilizable en los modulos donde interviene personal o servicio externo.',
              [],
              [
                  'Nuevo: crea un contratista nuevo.',
                  'Editar: corrige datos administrativos o de contacto.',
                  'Eliminar: quita contratistas que ya no deben seguir activos.',
                  'Buscar: ayuda a localizar registros dentro del listado.',
              ]
          ),
          [
              ['href' => route('ayuda-asistencia'), 'label' => 'Control de asistencia'],
              ['href' => route('ayuda-epp'), 'label' => 'Asignacion de EPP'],
              ['href' => route('ayuda-visualizar-ot'), 'label' => 'Visualizacion general de la OT'],
          ],
          [
              'Captura del maestro y GIF de alta/edicion.',
          ]
      );
  }

  public function gestionPermisos()
  {
      return $this->returnAyudaIntroView(
          'Gestionar permisos',
          [
              'Esta seccion administra los permisos puntuales del sistema, es decir, las acciones y pantallas a las que un rol o usuario puede acceder.',
              'La pantalla se usa para consultar permisos existentes y entender la base con la que despues se configuran roles y accesos.',
          ],
          $this->functionalSections(
              [
                  'Listado de permisos disponibles en el sistema.',
                  'Acciones puntuales que despues se agrupan en roles.',
                  'Base de seguridad funcional para modulos y operaciones.',
              ],
              [
                  'Consultar permisos existentes.',
                  'Revisar que permisos hay disponibles antes de configurar o ajustar roles.',
                  'Usar el modulo como referencia para entender accesos finos del sistema.',
              ],
              [
                  'Se consulta junto con roles cuando hace falta definir o auditar accesos.',
                  'Tambien sirve para entender por que una accion existe o no dentro del alcance de un perfil.',
              ],
              'Los permisos quedan claros como base del esquema de acceso y pueden usarse para ordenar configuraciones de roles.',
              [],
              [
                  'Consultar listado: permite revisar permisos existentes antes de configurar roles.',
                  'Buscar: ayuda a ubicar rapidamente un permiso puntual si la pantalla lo permite.',
              ]
          ),
          [
              ['href' => route('ayuda-gestionar-roles'), 'label' => 'Gestionar roles'],
              ['href' => route('ayuda-gestion-usuario'), 'label' => 'Gestionar usuarios'],
          ],
          [
              'Captura del listado de permisos.',
              'GIF breve de asignacion o revision junto con roles.',
          ]
      );
  }

  public function gestionStock()
  {
      return $this->returnAyudaIntroView(
          'Gestion de stock',
          [
              'Esta seccion administra disponibilidad, movimientos y ajustes de productos que participan del circuito operativo.',
              'No es solo una consulta de cantidades: desde stock se revisan existencias, se registran movimientos, se corrigen valores y se exportan salidas cuando el modulo lo permite.',
          ],
          $this->functionalSections(
              [
                  'Productos stockeables y su cantidad disponible.',
                  'Movimientos de ingreso, egreso o ajuste.',
                  'Referencias de origen o destino como proveedores, frentes o remitos cuando aplican.',
                  'Historial de movimientos por producto.',
              ],
              [
                  'Consultar stock total y movimientos existentes.',
                  'Crear movimientos o ajustes manuales segun el circuito habilitado.',
                  'Editar o corregir datos del movimiento cuando la pantalla lo permite.',
                  'Filtrar por producto, fecha o criterio disponible.',
                  'Exportar PDF o consultar detalle historico en vistas relacionadas.',
              ],
              [
                  'Se parte del listado general para revisar existencias antes de mover o asignar productos.',
                  'Cuando hay un ingreso, egreso o correccion, se registra el movimiento para dejar trazabilidad.',
                  'El historial se usa despues para entender de donde vino una diferencia o reconstruir el recorrido del producto.',
              ],
              'El sistema deja trazabilidad de cantidades y movimientos para que stock, remitos y otros modulos trabajen con informacion confiable.',
              [
                  'Que el producto sea el correcto y tenga configuracion stockeable.',
                  'Que el tipo de movimiento refleje ingreso, egreso o ajuste real.',
              ],
              [
                  'Nuevo movimiento o ajuste: registra ingresos, egresos o correcciones de stock.',
                  'Editar: corrige un movimiento cuando el circuito lo permite.',
                  'Eliminar: quita movimientos o registros si el perfil y la pantalla lo habilitan.',
                  'Buscar y filtrar: localiza movimientos por producto, fecha u otros criterios.',
                  'Exportar PDF: genera la salida documental del registro o historial cuando la vista lo ofrece.',
              ]
          ),
          [
              ['href' => route('ayuda-gestion-productos'), 'label' => 'Gestionar productos'],
              ['href' => route('ayuda-gestion-proveedores'), 'label' => 'Gestionar proveedores'],
              ['href' => route('ayuda-creacion-remito'), 'label' => 'Remitos'],
              ['href' => route('ayuda-epp'), 'label' => 'Asignacion de EPP'],
          ],
          [
              'GIF de consulta, ajuste y movimiento de stock.',
              'Captura del historial o stock total.',
          ]
      );
  }

  public function asistencia()
  {
      return $this->returnAyudaIntroView(
          'Control de asistencia',
          [
              'Esta seccion administra la asistencia vinculada a personas, contratistas, horas o servicios segun el circuito operativo disponible.',
              'La pantalla permite registrar asistencia, consultar registros existentes, editarlos, copiarlos, resumir informacion y emitir salidas documentales cuando corresponde.',
          ],
          $this->functionalSections(
              [
                  'Registros de asistencia por persona, contratista, servicio o cantidad de horas.',
                  'Datos necesarios para resumenes, pagos y controles posteriores.',
                  'Historial o listados de asistencia cargada.',
              ],
              [
                  'Consultar registros existentes.',
                  'Crear asistencia nueva.',
                  'Editar o copiar asistencia cuando el circuito lo permite.',
                  'Revisar resumenes o pagos asociados.',
                  'Emitir PDF u otras salidas disponibles.',
              ],
              [
                  'Se carga asistencia en el momento operativo o en cortes periodicos segun el uso del modulo.',
                  'Si un registro quedo mal o debe repetirse una base similar, se usa edicion o copia para ahorrar carga manual.',
                  'Despues se consulta el resumen para control interno y salida administrativa.',
              ],
              'La asistencia queda registrada con suficiente detalle para control interno, resumenes y seguimiento administrativo.',
              [],
              [
                  'Nuevo: crea un registro de asistencia.',
                  'Editar: corrige una asistencia ya cargada.',
                  'Copiar: reutiliza una base similar cuando la pantalla lo permite.',
                  'Buscar y filtrar: localiza registros por fecha, persona o servicio.',
                  'PDF o resumen: genera salidas documentales y de control cuando corresponden.',
              ]
          ),
          [
              ['href' => route('ayuda-gestion-contratistas'), 'label' => 'Gestionar contratistas'],
              ['href' => route('ayuda-epp'), 'label' => 'Asignacion de EPP'],
              ['href' => route('ayuda-reportes'), 'label' => 'Reportes'],
          ],
          [
              'GIF de alta, edicion y copia de asistencia.',
              'Captura de resumenes, pagos y PDF.',
          ]
      );
  }

  public function epp()
  {
      return $this->returnAyudaIntroView(
          'Asignacion de EPP',
          [
              'Esta seccion administra la asignacion de elementos de proteccion personal y deja trazabilidad por operador, remito o carga manual.',
              'El modulo permite consultar entregas existentes, cargar nuevas asignaciones y reconstruir que se entrego, a quien y bajo que referencia operativa.',
          ],
          $this->functionalSections(
              [
                  'Asignaciones de elementos de proteccion por operador o referencia operativa.',
                  'Productos o elementos entregados y su cantidad.',
                  'Vinculo con remitos cuando la entrega nace desde ese circuito.',
              ],
              [
                  'Consultar asignaciones existentes.',
                  'Crear entregas nuevas desde remito, operador o carga manual segun el flujo disponible.',
                  'Revisar historial o resumen de entregas.',
              ],
              [
                  'Se define primero el origen de la asignacion y luego se cargan los elementos entregados.',
                  'El modulo se usa para dejar evidencia operativa de la entrega y para poder consultarla despues sin registros externos.',
              ],
              'Cada entrega queda registrada y luego puede consultarse en reportes, resumenes o controles internos.',
              [],
              [
                  'Nueva asignacion: registra una entrega de EPP por operador, remito o carga manual.',
                  'Consultar historial: revisa entregas ya realizadas.',
                  'Buscar: ayuda a localizar entregas por operador o referencia disponible.',
              ]
          ),
          [
              ['href' => route('ayuda-creacion-remito'), 'label' => 'Remitos'],
              ['href' => route('ayuda-gestion-usuario'), 'label' => 'Gestionar usuarios'],
              ['href' => route('ayuda-stock'), 'label' => 'Gestion de stock'],
          ],
          [
              'GIF de asignacion por remito y por operador.',
              'Captura del resumen o historial de EPP.',
          ]
      );
  }

  public function dosimetriaOperador()
  {
      return $this->returnAyudaIntroView(
          'Dosimetria de operador',
          [
              'Esta seccion administra la informacion dosimetrica asociada a cada operador.',
              'La pantalla permite consultar historial, cargar o actualizar datos y sostener seguimiento individual dentro del circuito de dosimetria.',
          ],
          $this->functionalSections(
              [
                  'Registro dosimetrico por operador.',
                  'Valores, estados o referencias asociadas al seguimiento individual.',
                  'Base para historial y resumenes posteriores.',
              ],
              [
                  'Consultar registros por operador.',
                  'Cargar o actualizar informacion dosimetrica.',
                  'Revisar el historial individual antes de consolidar reportes.',
              ],
              [
                  'Se usa cuando hace falta cargar o corregir informacion de un operador puntual.',
                  'Tambien sirve para revisar antecedentes sin pasar por el resumen general.',
              ],
              'El operador queda trazado con un historial consultable dentro del modulo de dosimetria.',
              [],
              [
                  'Nuevo o cargar: registra informacion dosimetrica del operador cuando la pantalla lo permite.',
                  'Editar: actualiza datos ya cargados.',
                  'Buscar y filtrar: localiza rapidamente un operador o periodo.',
              ]
          ),
          [
              ['href' => route('ayuda-dosimetria-resumen'), 'label' => 'Resumen de dosimetria'],
              ['href' => route('ayuda-historial-operadores'), 'label' => 'Historial de operadores'],
              ['href' => route('ayuda-reportes'), 'label' => 'Reportes'],
          ],
          [
              'GIF de carga o actualizacion por operador.',
              'Captura del listado y filtros principales.',
          ]
      );
  }

  public function dosimetriaRx()
  {
      return $this->returnAyudaIntroView(
          'Dosimetria RX',
          [
              'Esta seccion cubre la parte del seguimiento dosimetrico vinculada al circuito RX.',
              'El modulo se usa para consultar datos, registrar resultados y cruzarlos con estados o resumenes del mismo circuito.',
          ],
          $this->functionalSections(
              [
                  'Resultados o datos RX asociados al circuito dosimetrico.',
                  'Referencias por periodo, estado o criterio disponible.',
                  'Informacion reutilizable en resumenes e historicos.',
              ],
              [
                  'Consultar informacion RX cargada.',
                  'Registrar o actualizar datos del periodo.',
                  'Cruzar informacion con estados y resumenes relacionados.',
              ],
              [
                  'Se usa durante la carga periodica o cuando hace falta revisar una situacion puntual del circuito RX.',
                  'El listado y los filtros sirven para validar seguimiento, demoras o inconsistencias antes de reportar.',
              ],
              'La informacion RX queda integrada al resto del circuito dosimetrico y disponible para consulta.',
              [],
              [
                  'Nuevo o cargar: registra informacion RX del periodo si la pantalla lo permite.',
                  'Editar: corrige datos ya cargados.',
                  'Buscar y filtrar: localiza resultados por criterio disponible.',
              ]
          ),
          [
              ['href' => route('ayuda-dosimetria-estados'), 'label' => 'Estados de film'],
              ['href' => route('ayuda-dosimetria-resumen'), 'label' => 'Resumen de dosimetria'],
              ['href' => route('ayuda-historial-operadores'), 'label' => 'Historial de operadores'],
          ],
          [
              'GIF de carga o consulta RX.',
              'Captura de filtros y resultados.',
          ]
      );
  }

  public function dosimetriaEstados()
  {
      return $this->returnAyudaIntroView(
          'Estados de film',
          [
              'Esta seccion administra los estados que se usan para clasificar situaciones dentro del circuito de dosimetria.',
              'Funciona como maestro de apoyo para que los registros y resumenes trabajen con estados consistentes.',
          ],
          $this->functionalSections(
              [
                  'Listado de estados disponibles para clasificar registros.',
                  'Referencias comunes para resumenes y consultas.',
                  'Base de apoyo para modulos de dosimetria.',
              ],
              [
                  'Consultar estados existentes.',
                  'Usar el maestro como referencia para interpretar listados y resumenes.',
              ],
              [
                  'Se revisa este modulo cuando hace falta entender que significa un estado o mantener criterio comun en el circuito.',
              ],
              'Los estados quedan normalizados y reutilizables dentro del circuito dosimetrico.',
              [],
              [
                  'Consultar listado: permite revisar estados disponibles dentro del circuito.',
              ]
          ),
          [
              ['href' => route('ayuda-dosimetria-rx'), 'label' => 'Dosimetria RX'],
              ['href' => route('ayuda-dosimetria-resumen'), 'label' => 'Resumen de dosimetria'],
          ],
          [
              'Captura del maestro de estados.',
          ]
      );
  }

  public function dosimetriaResumen()
  {
      return $this->returnAyudaIntroView(
          'Resumen de dosimetria',
          [
              'Esta seccion consolida la informacion ya cargada para leer el estado general del modulo de dosimetria sin entrar registro por registro.',
              'Es una pantalla de consulta y seguimiento: su valor esta en filtros, contexto y lectura operativa del resumen.',
          ],
          $this->functionalSections(
              [
                  'Situacion consolidada del modulo por operador, periodo o criterio disponible.',
                  'Datos resumidos para control interno.',
                  'Base para profundizar luego en historicos puntuales.',
              ],
              [
                  'Consultar el estado general del circuito.',
                  'Filtrar y revisar resumenes segun el criterio disponible.',
                  'Usar la pantalla como punto de partida antes de entrar a un historial individual.',
              ],
              [
                  'Se usa para cierres periodicos, controles internos y consultas que no requieren abrir cada registro individual.',
              ],
              'El usuario obtiene una lectura consolidada del estado dosimetrico y puede profundizar despues en historicos o registros puntuales.',
              [],
              [
                  'Buscar y filtrar: permite consolidar la lectura del resumen por operador, periodo o criterio disponible.',
                  'Ver detalle: sirve como paso previo para entrar a historiales o registros puntuales.',
              ]
          ),
          [
              ['href' => route('ayuda-dosimetria-operador'), 'label' => 'Dosimetria de operador'],
              ['href' => route('ayuda-dosimetria-rx'), 'label' => 'Dosimetria RX'],
              ['href' => route('ayuda-reportes'), 'label' => 'Reportes'],
          ],
          [
              'GIF de uso de filtros y lectura del resumen.',
          ]
      );
  }

  public function historialOperadores()
  {
      return $this->returnAyudaIntroView(
          'Historial de operadores',
          [
              'Esta seccion permite reconstruir informacion historica vinculada a cada operador dentro del modulo de dosimetria.',
              'Se usa cuando el resumen general no alcanza y hace falta rastrear antecedentes, periodos o evolucion individual.',
          ],
          $this->functionalSections(
              [
                  'Historial por operador.',
                  'Consultas por periodo o criterio disponible.',
                  'Base para rastrear antecedentes y compararlos con el resumen general.',
              ],
              [
                  'Buscar por operador.',
                  'Consultar antecedentes por periodo.',
                  'Cruzar la lectura con resumenes o datos complementarios.',
              ],
              [
                  'Se usa al investigar antecedentes o validar informacion previa a una decision operativa.',
              ],
              'El usuario puede reconstruir el recorrido historico del operador sin depender de registros manuales externos.',
              [],
              [
                  'Buscar: localiza el operador dentro del historial.',
                  'Filtrar por periodo: acota la consulta al tramo que se necesita revisar.',
              ]
          ),
          [
              ['href' => route('ayuda-dosimetria-operador'), 'label' => 'Dosimetria de operador'],
              ['href' => route('ayuda-dosimetria-resumen'), 'label' => 'Resumen de dosimetria'],
          ],
          [
              'GIF de busqueda por operador y consulta por periodo.',
          ]
      );
  }

  public function reportes()
  {
      return $this->returnAyudaIntroView(
          'Reportes',
          [
              'Esta seccion agrupa reportes y consultas consolidadas para control tecnico, seguimiento operativo y lectura administrativa.',
              'No reemplaza los modulos operativos: sirve para revisar informacion resumida, filtrarla y exportarla sin recorrer cada pantalla de origen.',
          ],
          $this->functionalSections(
              [
                  'Reportes de certificados, partes, placas, trazabilidad y otras salidas consolidadas.',
                  'Filtros por periodo, cliente, OT u otros criterios disponibles segun el reporte.',
                  'Resultados listos para consulta o exportacion.',
              ],
              [
                  'Consultar salidas consolidadas.',
                  'Aplicar filtros para acotar resultados.',
                  'Exportar o compartir informacion resumida cuando el reporte lo permite.',
              ],
              [
                  'Se entra al reporte adecuado segun la pregunta operativa o administrativa que se quiere responder.',
                  'Despues se filtra por el criterio disponible para obtener una salida acotada sin recorrer modulos de origen uno por uno.',
              ],
              'El usuario obtiene una salida consolidada con filtros que le evita recorrer modulos operativos uno por uno.',
              [],
              [
                  'Buscar y filtrar: permite acotar resultados segun cliente, OT, fecha u otros criterios del reporte.',
                  'Exportar: genera la salida resumida en el formato disponible para cada reporte.',
              ]
          ),
          [
              ['href' => route('ayuda-visualizar-informes'), 'label' => 'Visualizacion de informes'],
              ['href' => route('ayuda-visualizar-parte-diario'), 'label' => 'Visualizacion de partes diarios'],
              ['href' => route('ayuda-visualizar-certificados'), 'label' => 'Visualizacion de certificados'],
              ['href' => route('ayuda-dosimetria-resumen'), 'label' => 'Resumen de dosimetria'],
          ],
          [
              'GIF de filtros y exportacion en los reportes mas usados.',
              'Capturas de ejemplos de salida por tipo de reporte.',
          ]
      );
  }

  public function qr()
  {
      return $this->returnAyudaIntroView(
          'QR y documentacion asociada',
          [
              'Esta seccion concentra las consultas por QR para acceder rapido a informacion y documentacion asociada a equipos o vehiculos.',
              'La funcionalidad apunta a abrir fichas o documentos desde una referencia fisica sin pasar por busquedas manuales largas.',
          ],
          $this->functionalSections(
              [
                  'QR de internos de equipos y vehiculos.',
                  'Documentacion vinculada o historica que se abre desde la referencia fisica.',
                  'Datos utiles para trazabilidad rapida.',
              ],
              [
                  'Escanear o consultar un QR disponible.',
                  'Abrir la ficha o documentacion asociada.',
                  'Usar la pantalla como acceso rapido a informacion tecnica o documental.',
              ],
              [
                  'Se usa en terreno o en controles rapidos donde conviene resolver una consulta desde la referencia fisica del equipo o vehiculo.',
              ],
              'La consulta devuelve informacion util y acorta el tiempo de acceso a documentos o referencias asociadas.',
              [],
              [
                  'Consultar QR: abre la ficha asociada a la referencia fisica escaneada o seleccionada.',
                  'Abrir documentacion: da acceso rapido a archivos o antecedentes vinculados.',
              ]
          ),
          [
              ['href' => route('ayuda-gestion-interno-equipos'), 'label' => 'Gestionar internos de equipos'],
              ['href' => route('ayuda-gestion-vehiculos'), 'label' => 'Gestionar vehiculos'],
              ['href' => route('ayuda-visualizar-vehiculos'), 'label' => 'Visualizar vehiculos y documentacion complementaria'],
          ],
          [
              'GIF de consulta QR sobre equipo o vehiculo.',
              'Captura del documento o ficha que se abre desde el QR.',
          ]
      );
  }

  public function multimediaGestion()
  {
      return $this->returnAyudaIntroView(
          'Gestion de multimedia',
          [
              'La gestion de multimedia concentra la administracion del contenido que luego se publica para consulta de usuarios.',
              'Incluye la organizacion por categorias o subcategorias y la carga de piezas disponibles para visualizacion.',
          ],
          $this->functionalSections(
              [
                  'Categorias, subcategorias y contenido multimedia publicado.',
                  'Estructura de navegacion que despues ve el usuario final.',
                  'Piezas disponibles para visualizacion posterior.',
              ],
              [
                  'Consultar contenido y estructura publicada.',
                  'Crear o reorganizar categorias y subcategorias.',
                  'Dar de alta, retirar o reordenar contenido multimedia.',
              ],
              [
                  'Se usa cuando hace falta cargar material nuevo o reorganizar la forma en que se presenta.',
              ],
              'El contenido queda clasificado y listo para su posterior consulta desde la vista de visualizacion.',
              [],
              [
                  'Nuevo: crea categorias, subcategorias o contenido nuevo.',
                  'Editar o reordenar: ajusta estructura y posicion del contenido publicado.',
                  'Eliminar: retira material que ya no debe quedar visible.',
              ]
          ),
          [
              ['href' => route('ayuda-multimedia-visualizacion'), 'label' => 'Visualizacion de multimedia'],
              ['href' => route('ayuda-modelos-3d'), 'label' => 'Modelos 3D'],
          ],
          [
              'GIF de alta y organizacion de contenido multimedia.',
              'Captura de categorias y subcategorias.',
          ]
      );
  }

  public function multimediaVisualizacion()
  {
      return $this->returnAyudaIntroView(
          'Visualizacion de multimedia',
          [
              'Esta vista permite recorrer el contenido multimedia ya publicado y consumido por el usuario final.',
              'A diferencia de la gestion, aqui el foco esta en navegar, filtrar y abrir contenido disponible.',
          ],
          $this->functionalSections(
              [
                  'Contenido multimedia ya publicado.',
                  'Categorias y subcategorias para navegar el material.',
                  'Piezas disponibles para apertura y consulta.',
              ],
              [
                  'Consultar el listado de contenido disponible.',
                  'Navegar por categoria o subcategoria.',
                  'Abrir y recorrer el material publicado.',
              ],
              [
                  'Se usa cuando un usuario necesita encontrar material ya cargado sin entrar al modulo de administracion.',
              ],
              'El usuario llega al contenido correcto sin depender del modulo de administracion.',
              [],
              [
                  'Buscar o navegar: recorre contenido por categoria o subcategoria.',
                  'Abrir: muestra el material multimedia publicado.',
              ]
          ),
          [
              ['href' => route('ayuda-multimedia-gestion'), 'label' => 'Gestion de multimedia'],
              ['href' => route('ayuda-modelos-3d'), 'label' => 'Modelos 3D'],
          ],
          [
              'GIF de navegacion por categorias y apertura del detalle.',
          ]
      );
  }

  public function notificaciones()
  {
      return $this->returnAyudaIntroView(
          'Notificaciones y alarmas',
          [
              'Esta seccion agrupa los avisos del sistema, las alarmas configuradas y los receptores que participan del circuito de notificacion.',
              'Su objetivo es que el usuario entienda que eventos requieren seguimiento y como se distribuyen esas alertas.',
          ],
          $this->functionalSections(
              [
                  'Notificaciones recibidas, alarmas activas y destinatarios relacionados.',
                  'Eventos del sistema que requieren lectura o seguimiento.',
                  'Base de consulta para entender el circuito de avisos.',
              ],
              [
                  'Consultar avisos pendientes.',
                  'Revisar alarmas o configuraciones relacionadas.',
                  'Entender quien recibe una alerta y por que motivo.',
              ],
              [
                  'Se usa cuando aparece una notificacion, cuando hace falta investigar una alerta o cuando se valida la distribucion de avisos.',
              ],
              'El usuario comprende que eventos debe seguir y que configuraciones sostienen ese circuito de avisos.',
              [],
              [
                  'Ver notificacion: abre el aviso o contexto relacionado.',
                  'Consultar alarmas: revisa el origen y estado de una alerta.',
              ]
          ),
          [
              ['href' => route('ayuda-perfil'), 'label' => 'Perfil de usuario'],
              ['href' => route('ayuda-gestion-usuario'), 'label' => 'Gestionar usuarios'],
          ],
          [
              'Captura del listado de notificaciones y alarmas.',
              'GIF de lectura o seguimiento de una alerta.',
          ]
      );
  }

  public function modelos3d()
  {
      return $this->returnAyudaIntroView(
          'Modelos 3D',
          [
              'El modulo de modelos 3D permite gestionar o consultar representaciones visuales dentro del sistema.',
              'Su documentacion tiene sentido separada porque mezcla carga de contenido con visualizacion interactiva.',
          ],
          $this->functionalSections(
              [
                  'Listado de modelos disponibles.',
                  'Acceso al visualizador 3D.',
                  'Material o referencia asociada al modelo cuando aplica.',
              ],
              [
                  'Consultar modelos disponibles.',
                  'Abrir el visualizador 3D.',
                  'Usar el modulo como apoyo visual o tecnico segun el contenido publicado.',
              ],
              [
                  'Se usa para localizar una representacion visual y abrirla sin depender de rutas internas del sistema.',
              ],
              'El usuario puede localizar el modelo correcto y abrir su visualizacion sin depender de rutas internas no documentadas.',
              [],
              [
                  'Consultar listado: permite revisar los modelos disponibles.',
                  'Abrir visualizador: muestra el modelo 3D seleccionado.',
              ]
          ),
          [
              ['href' => route('ayuda-multimedia-gestion'), 'label' => 'Gestion de multimedia'],
              ['href' => route('ayuda-multimedia-visualizacion'), 'label' => 'Visualizacion de multimedia'],
          ],
          [
              'Captura del listado de modelos.',
              'GIF del acceso al visualizador 3D.',
          ]
      );
  }

}





