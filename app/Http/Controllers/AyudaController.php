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
              'Este grupo organiza normas de ensayo, fabricacion y evaluacion que despues se reutilizan en formularios tecnicos y documentos del sistema.',
              'Su importancia no esta solo en el alta del maestro: mantener estas referencias consistentes evita encabezados ambiguos y criterios desalineados en informes.',
          ],
          [
              [
                  'title' => 'Que organiza',
                  'items' => [
                      'Normas de ensayo para metodos y servicios.',
                      'Normas de fabricacion ligadas a productos, componentes o referencias constructivas.',
                      'Normas de evaluacion usadas como criterio tecnico de aceptacion o rechazo.',
                  ],
              ],
              [
                  'title' => 'Cuando se usa',
                  'items' => [
                      'Antes de cargar o ajustar configuraciones tecnicas del sistema.',
                      'Al preparar maestros que despues alimentan informes.',
                      'Cuando se necesita corregir codigos, descripciones o referencias normativas.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'Las normas quedan disponibles como referencia estable para que informes y otros modulos trabajen con criterios tecnicos consistentes.',
                  ],
              ],
          ],
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
              'El maestro de medidas define valores o referencias que despues se seleccionan en productos, servicios o formularios tecnicos donde hace falta una parametrizacion previa.',
              'Su funcion es evitar carga manual repetida y mantener un criterio uniforme cuando distintas pantallas trabajan con las mismas dimensiones o referencias.',
          ],
          [
              [
                  'title' => 'Que resuelve',
                  'items' => [
                      'Normaliza opciones de medida usadas en otros maestros.',
                      'Reduce errores de carga libre en formularios dependientes.',
                      'Facilita filtros y seleccion repetida de valores compatibles.',
                  ],
              ],
              [
                  'title' => 'Cuando se usa',
                  'items' => [
                      'Antes de crear productos o configuraciones que dependen de una medida.',
                      'Cuando se detectan valores duplicados o inconsistentes.',
                      'Al ajustar catalogos tecnicos que comparten una misma estructura de medida.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'Las medidas quedan disponibles como maestro reutilizable para mantener orden y consistencia en el resto del sistema.',
                  ],
              ],
          ],
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
              'Los internos de fuente individualizan cada fuente disponible dentro del circuito operativo y la vinculan con su seguimiento documental o tecnico.',
              'No reemplazan al maestro general de fuentes: sirven para controlar cada unidad concreta que despues puede asignarse, consultarse o trazarse.',
          ],
          [
              [
                  'title' => 'Que organiza',
                  'items' => [
                      'Identificacion unica de cada fuente.',
                      'Relacion con la fuente base y sus datos tecnicos.',
                      'Base para trazabilidad, documentacion y ubicacion operativa.',
                  ],
              ],
              [
                  'title' => 'Cuando se usa',
                  'items' => [
                      'Al incorporar una nueva unidad al circuito.',
                      'Cuando cambia su estado, ubicacion o informacion asociada.',
                      'Antes de necesitarla en consultas QR, trazabilidad o control tecnico.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'Cada fuente queda individualizada y lista para integrarse con documentacion, consultas y circuitos operativos relacionados.',
                  ],
              ],
          ],
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
              'El maestro de clientes concentra la informacion comercial y operativa de las entidades para las que se trabaja dentro del sistema.',
              'Su carga impacta despues en OT, usuarios cliente, documentacion y referencias visibles en otros circuitos del negocio.',
          ],
          [
              [
                  'title' => 'Que organiza',
                  'items' => [
                      'Datos identificatorios y administrativos del cliente.',
                      'Informacion de contacto reutilizable en otros modulos.',
                      'Base de seleccion para OT, certificados y documentacion.',
                  ],
              ],
              [
                  'title' => 'Cuando se usa',
                  'items' => [
                      'Antes de crear una nueva OT para un cliente no registrado.',
                      'Cuando cambian contactos, razon social o datos de referencia.',
                      'Al revisar que informacion comercial usa el resto del circuito documental.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'El cliente queda disponible como entidad confiable para usarse en OT y documentos sin repetir carga manual en cada pantalla.',
                  ],
              ],
          ],
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
              'El maestro de comitentes define entidades que despues pueden aparecer asociadas a OT, certificados u otra documentacion del circuito.',
              'Su funcion principal es separar correctamente la referencia de comitente del cliente cuando el negocio necesita distinguir ambos roles.',
          ],
          [
              [
                  'title' => 'Que resuelve',
                  'items' => [
                      'Alta y mantenimiento de comitentes.',
                      'Referencia reutilizable en documentos y formularios.',
                      'Diferenciacion clara entre cliente y comitente cuando no son la misma entidad.',
                  ],
              ],
              [
                  'title' => 'Cuando se usa',
                  'items' => [
                      'Antes de crear OT o documentos que requieren comitente.',
                      'Cuando cambia la razon social o la identificacion visible.',
                      'Al revisar datos de cabecera usados en certificados y otros documentos.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'El comitente queda disponible como maestro estable para vincularlo con otros registros sin duplicar informacion.',
                  ],
              ],
          ],
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
              'Este maestro ordena tipos o referencias documentales que despues se usan para asociar vencimientos, soportes o requisitos dentro del sistema.',
              'Su valor aparece cuando otros modulos necesitan clasificar correctamente la documentacion vinculada a vehiculos, equipos u otras entidades.',
          ],
          [
              [
                  'title' => 'Que organiza',
                  'items' => [
                      'Tipos de documentacion reutilizables.',
                      'Base para vigencias, controles o clasificaciones posteriores.',
                      'Referencia comun para distintos circuitos operativos.',
                  ],
              ],
              [
                  'title' => 'Dependencias',
                  'items' => [
                      'Vehiculos y documentacion complementaria.',
                      'Internos de equipos o recursos con soporte documental.',
                      'Consultas y controles que dependen de documentacion vigente.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'La documentacion queda clasificada bajo un criterio comun y reutilizable para que los modulos relacionados trabajen con la misma referencia.',
                  ],
              ],
          ],
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
              'El maestro de equipos define las referencias base sobre las que despues se crean internos, trazabilidad y documentacion asociada.',
              'No representa una unidad operativa individual. Su funcion es ordenar el catalogo general de equipos disponibles para el negocio.',
          ],
          [
              [
                  'title' => 'Que organiza',
                  'items' => [
                      'Catalogo general de equipos.',
                      'Datos base para internos y seguimiento tecnico.',
                      'Referencia comun para modulos de trazabilidad y documentacion.',
                  ],
              ],
              [
                  'title' => 'Cuando se usa',
                  'items' => [
                      'Antes de dar de alta un interno de equipo.',
                      'Cuando cambia la definicion o clasificacion del equipo base.',
                      'Al revisar consistencia del catalogo tecnico general.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'El equipo queda disponible como maestro base para posteriores altas operativas y consultas de trazabilidad.',
                  ],
              ],
          ],
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
              'El maestro de fuentes concentra las referencias base de fuentes que despues pueden individualizarse mediante internos y asociarse a circuitos de control tecnico.',
              'Su uso es similar al de equipos: prepara la estructura general sobre la que despues se monta la operatoria concreta.',
          ],
          [
              [
                  'title' => 'Que organiza',
                  'items' => [
                      'Catalogo general de fuentes.',
                      'Informacion tecnica base para seguimiento posterior.',
                      'Referencia comun para internos, consultas y trazabilidad.',
                  ],
              ],
              [
                  'title' => 'Cuando se usa',
                  'items' => [
                      'Antes de crear internos de fuente.',
                      'Cuando cambia una referencia tecnica del maestro.',
                      'Al revisar consistencia de las fuentes disponibles en el sistema.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'La fuente queda cargada como maestro base y lista para vincularse con internos, documentacion y circuitos de consulta.',
                  ],
              ],
          ],
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
              'Los internos de equipos representan unidades concretas del maestro de equipos y permiten seguir su ubicacion, documentacion y trazabilidad.',
              'Son la pieza operativa real que se consulta despues en QR, reportes, documentacion o movimientos entre frentes.',
          ],
          [
              [
                  'title' => 'Que organiza',
                  'items' => [
                      'Identificacion unica de cada equipo operativo.',
                      'Relacion con el equipo base y su documentacion.',
                      'Ubicacion o referencia para trazabilidad posterior.',
                  ],
              ],
              [
                  'title' => 'Dependencias',
                  'items' => [
                      'Maestro de equipos correctamente cargado.',
                      'Documentacion asociada cuando el circuito lo requiere.',
                      'Consultas QR, reportes o trazabilidad interna.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'Cada equipo queda individualizado y listo para usarse en consultas, movimientos o seguimiento tecnico del sistema.',
                  ],
              ],
          ],
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
              'El maestro de materiales organiza insumos o referencias tecnicas que despues pueden intervenir en formularios, informes o configuraciones internas.',
              'Su objetivo es dejar un catalogo consistente para evitar carga libre y mantener trazabilidad tecnica en los modulos que lo consumen.',
          ],
          [
              [
                  'title' => 'Que organiza',
                  'items' => [
                      'Catalogo de materiales reutilizable.',
                      'Base de seleccion para formularios tecnicos.',
                      'Referencia comun para documentos o configuraciones asociadas.',
                  ],
              ],
              [
                  'title' => 'Cuando se usa',
                  'items' => [
                      'Antes de completar formularios que requieren materiales definidos.',
                      'Cuando se incorporan nuevos materiales al circuito.',
                      'Al corregir nombres, codigos o clasificaciones del catalogo.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'Los materiales quedan disponibles como maestro estable para que otros modulos seleccionen referencias tecnicas ya normalizadas.',
                  ],
              ],
          ],
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
              'El maestro de productos define insumos, consumibles o articulos que despues se usan en OT, stock, remitos y otros circuitos internos.',
              'No todos los productos cumplen el mismo rol: algunos impactan en inventario, otros se usan como referencia tecnica o como elemento visible en una OT.',
          ],
          [
              [
                  'title' => 'Que organiza',
                  'items' => [
                      'Catalogo general de productos.',
                      'Productos inventariables o vinculados a stock.',
                      'Referencias seleccionables en OT y remitos cuando el circuito lo necesita.',
                  ],
              ],
              [
                  'title' => 'Que necesita antes',
                  'items' => [
                      'Unidades de medida definidas.',
                      'Criterio claro sobre si el producto impacta en stock o en otros circuitos.',
                      'Consistencia con servicios, materiales o remitos cuando se relacionan entre si.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'El producto queda listo para usarse como referencia operativa y, si corresponde, para integrarse con stock y movimientos.',
                  ],
              ],
          ],
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
              'El maestro de servicios define las prestaciones que despues se cargan en OT y habilitan metodos o circuitos documentales relacionados.',
              'Es un maestro critico porque conecta la parte comercial con la operativa: un servicio mal definido repercute despues en informes y configuraciones de trabajo.',
          ],
          [
              [
                  'title' => 'Que organiza',
                  'items' => [
                      'Catalogo de servicios disponibles.',
                      'Relacion entre servicio, unidad de medida y metodo de ensayo.',
                      'Base de seleccion para OT y configuraciones tecnicas posteriores.',
                  ],
              ],
              [
                  'title' => 'Que necesita antes',
                  'items' => [
                      'Unidades de medida consistentes.',
                      'Metodos o referencias tecnicas asociadas correctamente.',
                      'Criterio claro sobre como el servicio impacta en la OT.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'El servicio queda disponible para cargarse en una OT y habilitar luego el circuito documental correspondiente.',
                  ],
              ],
          ],
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
              'Este maestro concentra soldadores que despues pueden asociarse a OT y participar en circuitos donde hace falta trazabilidad por persona o identificacion tecnica.',
              'Su correcta carga permite seleccionarlos en las pantallas operativas sin depender de registros manuales externos.',
          ],
          [
              [
                  'title' => 'Que organiza',
                  'items' => [
                      'Listado de soldadores disponibles.',
                      'Datos de identificacion reutilizables en la operacion.',
                      'Base para asignaciones y relacion con informes o consultas posteriores.',
                  ],
              ],
              [
                  'title' => 'Cuando se usa',
                  'items' => [
                      'Antes de asignar soldadores a una OT.',
                      'Cuando cambian datos de identificacion o vigencia.',
                      'Al revisar trazabilidad operativa vinculada a personas tecnicas.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'El soldador queda disponible como maestro confiable para asignaciones y circuitos documentales que dependan de su referencia.',
                  ],
              ],
          ],
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
              'El maestro de unidades de medida define las unidades que despues reutilizan productos, servicios y otros formularios del sistema.',
              'Su importancia es transversal: si este maestro queda desordenado, despues se replica la inconsistencia en varios modulos al mismo tiempo.',
          ],
          [
              [
                  'title' => 'Que organiza',
                  'items' => [
                      'Unidades reutilizables para productos y servicios.',
                      'Base comun para catalogos y formularios.',
                      'Referencia consistente para cantidades, medidas o consumos.',
                  ],
              ],
              [
                  'title' => 'Cuando se usa',
                  'items' => [
                      'Antes de crear productos o servicios nuevos.',
                      'Cuando hace falta corregir unidades duplicadas o mal nombradas.',
                      'Al ordenar maestros que comparten criterios de medicion.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'Las unidades quedan disponibles como base comun y consistente para los modulos que las necesitan.',
                  ],
              ],
          ],
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
              'Los roles agrupan permisos y definen perfiles de acceso para distintos tipos de usuario dentro del sistema.',
              'No se trata solo de una clasificacion administrativa: un rol bien definido ordena que pantallas y acciones puede usar cada persona.',
          ],
          [
              [
                  'title' => 'Que resuelve',
                  'items' => [
                      'Agrupa permisos por perfil de trabajo.',
                      'Facilita asignar acceso a nuevos usuarios sin configurar accion por accion.',
                      'Sirve como base para ordenar seguridad funcional y responsabilidades.',
                  ],
              ],
              [
                  'title' => 'Cuando se usa',
                  'items' => [
                      'Al crear o ajustar perfiles de acceso.',
                      'Cuando un grupo de usuarios necesita un nuevo alcance funcional.',
                      'Al auditar diferencias entre lo que un usuario deberia ver y lo que efectivamente ve.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'Cada rol queda definido como perfil reutilizable para ordenar accesos sin mantener permisos dispersos de forma manual.',
                  ],
              ],
          ],
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
              'El perfil concentra las acciones personales del usuario dentro de la plataforma: revision de datos, configuracion basica y acceso a opciones que impactan en el uso diario.',
              'No es un modulo operativo aislado. Sirve para mantener la cuenta consistente y evitar problemas de acceso, identificacion o notificaciones.',
          ],
          [
              [
                  'title' => 'Que resuelve',
                  'paragraphs' => [
                      'Desde esta pantalla el usuario revisa la informacion con la que trabaja en el sistema y confirma que sus datos de identificacion y contacto esten vigentes.',
                  ],
                  'items' => [
                      'Revision de datos personales y de acceso.',
                      'Actualizacion de informacion visible para otros modulos.',
                      'Control de configuraciones ligadas a la cuenta.',
                  ],
              ],
              [
                  'title' => 'Cuando conviene usarlo',
                  'items' => [
                      'Al ingresar por primera vez o despues de un cambio de rol.',
                      'Cuando se detecta informacion desactualizada.',
                      'Antes de revisar problemas de acceso o de notificaciones.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'El usuario deja su cuenta alineada con el uso real del sistema y reduce inconsistencias en circuitos que dependen de sus datos o permisos.',
                  ],
              ],
          ],
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
              'El maestro de proveedores ordena las entidades externas con las que se trabajan productos, entregas o abastecimiento interno.',
              'Su valor no esta solo en el alta. Tambien impacta en stock, movimientos y futuras consultas administrativas.',
          ],
          [
              [
                  'title' => 'Que informacion organiza',
                  'items' => [
                      'Datos identificatorios del proveedor.',
                      'Informacion de contacto y referencia.',
                      'Base de seleccion para circuitos de stock o compras.',
                  ],
              ],
              [
                  'title' => 'Cuando se usa',
                  'items' => [
                      'Antes de registrar productos o movimientos asociados a un proveedor nuevo.',
                      'Cuando se necesita corregir datos de contacto o razon social.',
                      'Al revisar historicos o reportes por origen de insumos.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'El sistema deja disponible un listado confiable para vincular proveedores con otros modulos sin tener que repetir datos manualmente.',
                  ],
              ],
          ],
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
              'Los frentes ordenan el destino u origen operativo de recursos, remitos y otros movimientos internos.',
              'Funcionan como un dato organizador para saber donde se encuentra cada elemento y como se distribuye la operacion.',
          ],
          [
              [
                  'title' => 'Para que sirve este maestro',
                  'items' => [
                      'Identificar sectores, bases o destinos operativos.',
                      'Facilitar la seleccion en remitos y movimientos.',
                      'Separar recursos por contexto de trabajo.',
                  ],
              ],
              [
                  'title' => 'Impacto en otros modulos',
                  'items' => [
                      'Remitos y movimientos de materiales.',
                      'Ubicacion de internos de equipos.',
                      'Consultas internas sobre trazabilidad.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'Cada frente queda disponible como referencia estable para evitar movimientos ambiguos o asignaciones sin ubicacion clara.',
                  ],
              ],
          ],
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
              'Este maestro concentra los vehiculos disponibles para la operacion y la informacion necesaria para poder asignarlos y consultarlos despues desde las OT.',
              'No reemplaza la vista operativa dentro de la orden de trabajo: prepara los datos base para que ese circuito sea trazable.',
          ],
          [
              [
                  'title' => 'Que datos conviene mantener al dia',
                  'items' => [
                      'Identificacion del vehiculo.',
                      'Informacion documental o de vigencia asociada.',
                      'Datos necesarios para asignaciones y controles posteriores.',
                  ],
              ],
              [
                  'title' => 'Cuando se usa',
                  'items' => [
                      'Al incorporar un vehiculo nuevo al circuito operativo.',
                      'Cuando se modifican datos o documentacion.',
                      'Antes de asignarlo a una OT.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'El vehiculo queda disponible para asignacion y consulta con una referencia consistente dentro del sistema.',
                  ],
              ],
          ],
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
              'Las plantas permiten ubicar operaciones, clientes u otras referencias de negocio en una estructura mas ordenada.',
              'Es un maestro de apoyo que cobra valor cuando otros modulos necesitan identificar la planta asociada a una operacion o entidad.',
          ],
          [
              [
                  'title' => 'Cuando conviene cargar una planta',
                  'items' => [
                      'Al dar de alta clientes o entidades que trabajan con sedes diferenciadas.',
                      'Cuando la operacion necesita distinguir ubicaciones concretas.',
                      'Antes de usarla como filtro o referencia en otros modulos.',
                  ],
              ],
              [
                  'title' => 'Dependencias',
                  'items' => [
                      'Clientes o comitentes asociados.',
                      'Consultas y formularios que exigen una ubicacion mas precisa.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'La planta queda disponible como referencia estable para seleccion y filtrado en pantallas relacionadas.',
                  ],
              ],
          ],
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
              'El maestro de contratistas concentra terceros o equipos externos que participan en tareas operativas del sistema.',
              'Su correcta carga facilita asistencia, asignaciones y consultas posteriores por responsable externo.',
          ],
          [
              [
                  'title' => 'Que resuelve',
                  'items' => [
                      'Alta y mantenimiento de contratistas.',
                      'Base de seleccion para asistencia y otras cargas operativas.',
                      'Trazabilidad de participacion externa en trabajos.',
                  ],
              ],
              [
                  'title' => 'Cuando se usa',
                  'items' => [
                      'Antes de registrar asistencia vinculada a un contratista.',
                      'Cuando cambia la informacion administrativa o de contacto.',
                      'Al consolidar consultas por empresa o cuadrilla externa.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'El contratista queda disponible como entidad reutilizable en los modulos donde interviene personal o servicio externo.',
                  ],
              ],
          ],
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
              'Los permisos definen acciones puntuales a las que un usuario o rol puede acceder dentro del sistema.',
              'Su administracion debe leerse junto con roles, porque ambos modulos forman la base del esquema de acceso.',
          ],
          [
              [
                  'title' => 'Que informacion controla',
                  'items' => [
                      'Accesos a pantallas o acciones puntuales.',
                      'Restricciones finas que complementan los roles.',
                      'Base para revisar seguridad funcional del sistema.',
                  ],
              ],
              [
                  'title' => 'Cuando intervenir en este modulo',
                  'items' => [
                      'Al crear un nuevo esquema de acceso.',
                      'Cuando un rol necesita ajustar permisos especificos.',
                      'Al auditar accesos o revisar usuarios con demasiadas facultades.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'Los accesos quedan delimitados de forma consistente y alineada con los roles existentes.',
                  ],
              ],
          ],
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
              'Stock concentra la disponibilidad, los movimientos y los ajustes sobre productos que se usan en la operacion.',
              'No es solo una consulta de cantidades: tambien registra ingresos, egresos, correcciones e impacto de remitos o asignaciones.',
          ],
          [
              [
                  'title' => 'Que tareas incluye',
                  'items' => [
                      'Consulta general y stock total.',
                      'Ajustes manuales y correcciones.',
                      'Revision de movimientos historicos.',
                      'Impresion o consulta de salidas relacionadas.',
                  ],
              ],
              [
                  'title' => 'Que necesita antes',
                  'items' => [
                      'Productos correctamente dados de alta.',
                      'Proveedores o frentes si el circuito los usa como referencia.',
                      'Criterio claro sobre ingreso, egreso y destino del movimiento.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'El sistema deja trazabilidad de cantidades y movimientos para que otros modulos trabajen con informacion confiable.',
                  ],
              ],
          ],
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
              'El modulo de asistencia registra presencia, horas o servicios asociados a personal, cuadrillas u otros participantes de la operacion.',
              'Tambien sirve para consolidar resumenes, pagos y documentos de respaldo segun el circuito interno definido.',
          ],
          [
              [
                  'title' => 'Cuando se usa',
                  'items' => [
                      'Durante la carga diaria o periodica de asistencia.',
                      'Al corregir una asistencia ya registrada.',
                      'Cuando se necesita consolidar pagos o emitir un PDF.',
                  ],
              ],
              [
                  'title' => 'Flujo general',
                  'items' => [
                      'Alta de registro por servicio u horas.',
                      'Edicion, copia o ajustes segun necesidad.',
                      'Consulta de resumenes y salida documental.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'La asistencia queda registrada con la granularidad necesaria para control interno y seguimiento administrativo.',
                  ],
              ],
          ],
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
              'El circuito de EPP registra la entrega de elementos de proteccion personal y deja trazabilidad por operador, remito o carga manual.',
              'Su valor esta en saber que se entrego, cuando y bajo que referencia operativa se hizo la asignacion.',
          ],
          [
              [
                  'title' => 'Formas de asignacion',
                  'items' => [
                      'Desde un remito existente.',
                      'Directamente a un operador.',
                      'Por carga manual cuando el circuito lo requiere.',
                  ],
              ],
              [
                  'title' => 'Dependencias',
                  'items' => [
                      'Usuarios u operadores existentes.',
                      'Productos o elementos correctamente definidos.',
                      'Remitos cuando la entrega nace desde ese modulo.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'Cada entrega queda registrada y luego puede consultarse en reportes o resumenes internos.',
                  ],
              ],
          ],
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
              'Este modulo concentra la carga y el seguimiento de informacion dosimetrica asociada a operadores.',
              'La utilidad principal es mantener un historial consultable y controlado para cada persona involucrada.',
          ],
          [
              [
                  'title' => 'Que informacion organiza',
                  'items' => [
                      'Registro por operador.',
                      'Seguimiento de valores o estados asociados.',
                      'Base para resumenes y consultas historicas.',
                  ],
              ],
              [
                  'title' => 'Cuando se usa',
                  'items' => [
                      'Al cargar o actualizar informacion dosimetrica.',
                      'Al revisar el estado de un operador.',
                      'Antes de emitir resumenes o controles internos.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'El operador queda trazado con un historial consultable dentro del modulo de dosimetria.',
                  ],
              ],
          ],
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
              'Dosimetria RX cubre la parte del seguimiento dosimetrico vinculada al circuito RX dentro del sistema.',
              'Debe leerse como un submodulo especializado, relacionado con estados, resumenes y consultas historicas.',
          ],
          [
              [
                  'title' => 'Que tareas incluye',
                  'items' => [
                      'Registro de datos o resultados RX.',
                      'Consulta historica por periodo o referencia.',
                      'Cruce con resumenes y estados asociados.',
                  ],
              ],
              [
                  'title' => 'Cuando conviene revisarlo',
                  'items' => [
                      'Durante la carga periodica del modulo.',
                      'Cuando se valida un seguimiento o retraso.',
                      'Al preparar reportes internos.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'La informacion RX queda integrada al resto del circuito dosimetrico y disponible para consulta.',
                  ],
              ],
          ],
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
              'Estados de film funciona como apoyo para clasificar y seguir situaciones dentro del circuito de dosimetria.',
              'Al tratarse de un tema operativo especifico, conviene mantenerlo separado del resto para que el criterio de uso quede claro.',
          ],
          [
              [
                  'title' => 'Para que sirve',
                  'items' => [
                      'Definir estados posibles dentro del seguimiento.',
                      'Evitar clasificaciones manuales o inconsistentes.',
                      'Mejorar lectura de listados y resumenes.',
                  ],
              ],
              [
                  'title' => 'Dependencias',
                  'items' => [
                      'Carga o consulta en los modulos de dosimetria.',
                      'Reportes o resumenes que interpretan estos estados.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'Los estados quedan normalizados y reutilizables dentro del circuito dosimetrico.',
                  ],
              ],
          ],
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
              'El resumen de dosimetria concentra la informacion ya cargada para leer el estado general del modulo sin entrar registro por registro.',
              'Es una pantalla de consulta y seguimiento, no de carga inicial. Por eso su valor esta en los filtros, el contexto y la interpretacion.',
          ],
          [
              [
                  'title' => 'Que permite revisar',
                  'items' => [
                      'Situacion consolidada del modulo.',
                      'Datos por operador, periodo o criterio disponible.',
                      'Base para decisiones o controles internos.',
                  ],
              ],
              [
                  'title' => 'Cuando conviene usarlo',
                  'items' => [
                      'Al revisar cierres periodicos.',
                      'Cuando se detectan demoras o desfasajes.',
                      'Antes de emitir reportes o responder consultas internas.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'El usuario obtiene una lectura consolidada del estado dosimetrico y puede profundizar despues en historicos o registros puntuales.',
                  ],
              ],
          ],
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
              'El historial de operadores permite reconstruir informacion pasada vinculada a cada operador dentro del modulo de dosimetria.',
              'Es la vista indicada cuando no alcanza con el resumen general y se necesita rastrear evolucion o antecedentes.',
          ],
          [
              [
                  'title' => 'Que consultas habilita',
                  'items' => [
                      'Busqueda por operador.',
                      'Revision por periodos.',
                      'Cruce con resumenes o datos complementarios.',
                  ],
              ],
              [
                  'title' => 'Cuando se usa',
                  'items' => [
                      'Al investigar antecedentes.',
                      'Cuando se necesita responder una consulta puntual.',
                      'Al validar informacion previa antes de una decision operativa.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'El usuario puede reconstruir el recorrido historico del operador sin depender de registros manuales externos.',
                  ],
              ],
          ],
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
              'El modulo de reportes agrupa consultas consolidadas que sirven para control tecnico, seguimiento operativo y lectura administrativa.',
              'No todos los reportes responden a la misma necesidad, por eso conviene usar esta pagina como puerta de entrada al conjunto.',
          ],
          [
              [
                  'title' => 'Que tipos de reportes incluye',
                  'items' => [
                      'Reportes de certificados y partes.',
                      'Consultas de placas, informes sin parte o trazabilidad documental.',
                      'Reportes tecnicos o estadisticos segun el modulo.',
                  ],
              ],
              [
                  'title' => 'Cuando conviene usarlos',
                  'items' => [
                      'Al consolidar informacion para control interno.',
                      'Cuando se necesita responder una consulta de gestion.',
                      'Antes de exportar o compartir informacion resumida.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'El usuario obtiene una salida consolidada con filtros que le evita recorrer modulos operativos uno por uno.',
                  ],
              ],
          ],
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
              'Los modulos QR sirven para acceder rapido a informacion y documentacion asociada a internos de equipos o vehiculos.',
              'Su principal valor es evitar busquedas manuales largas cuando se necesita consultar algo desde el terreno o desde una referencia fisica.',
          ],
          [
              [
                  'title' => 'Que consultas cubre',
                  'items' => [
                      'QR de internos de equipos.',
                      'QR de vehiculos.',
                      'Acceso a documentacion vinculada o historica.',
                  ],
              ],
              [
                  'title' => 'Cuando se usa',
                  'items' => [
                      'Al escanear un codigo desde una unidad o equipo.',
                      'Cuando se necesita validar documentacion rapidamente.',
                      'Al revisar trazabilidad sin entrar al circuito completo del maestro.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'La consulta devuelve informacion util y acorta el tiempo de acceso a documentos o referencias asociadas.',
                  ],
              ],
          ],
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
          [
              [
                  'title' => 'Que tareas abarca',
                  'items' => [
                      'Gestion de categorias.',
                      'Gestion de subcategorias.',
                      'Alta, baja o reordenamiento del contenido publicado.',
                  ],
              ],
              [
                  'title' => 'Cuando intervenir en este modulo',
                  'items' => [
                      'Al crear una nueva estructura de contenido.',
                      'Cuando se suben piezas nuevas o se retiran existentes.',
                      'Al ordenar la navegacion que ve el usuario final.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'El contenido queda clasificado y listo para su posterior consulta desde la vista de visualizacion.',
                  ],
              ],
          ],
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
          [
              [
                  'title' => 'Que permite hacer',
                  'items' => [
                      'Acceder al listado de contenido disponible.',
                      'Navegar por categoria o subcategoria.',
                      'Abrir el material publicado y recorrerlo.',
                  ],
              ],
              [
                  'title' => 'Cuando se usa',
                  'items' => [
                      'Al consultar material de apoyo o comunicacion.',
                      'Cuando un usuario necesita encontrar una pieza especifica.',
                      'Al validar que el contenido publicado quedo visible correctamente.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'El usuario llega al contenido correcto sin depender del modulo de administracion.',
                  ],
              ],
          ],
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
          [
              [
                  'title' => 'Que cubre el modulo',
                  'items' => [
                      'Consulta de notificaciones recibidas.',
                      'Revision de alarmas activas o configurables.',
                      'Relacion con receptores o destinatarios.',
                  ],
              ],
              [
                  'title' => 'Cuando se usa',
                  'items' => [
                      'Al revisar avisos pendientes.',
                      'Cuando se investiga el origen de una alerta.',
                      'Al validar quien recibe una notificacion determinada.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'El usuario comprende que eventos debe seguir y que configuraciones sostienen ese circuito de avisos.',
                  ],
              ],
          ],
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
          [
              [
                  'title' => 'Que flujo cubre',
                  'items' => [
                      'Listado de modelos disponibles.',
                      'Acceso al visualizador 3D.',
                      'Consulta de material asociado segun el uso del modulo.',
                  ],
              ],
              [
                  'title' => 'Cuando conviene usarlo',
                  'items' => [
                      'Al revisar representaciones visuales publicadas.',
                      'Cuando se necesita validar el acceso al visualizador.',
                      'Como apoyo para contenido tecnico o multimedia.',
                  ],
              ],
              [
                  'title' => 'Resultado esperado',
                  'paragraphs' => [
                      'El usuario puede localizar el modelo correcto y abrir su visualizacion sin depender de rutas internas no documentadas.',
                  ],
              ],
          ],
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





