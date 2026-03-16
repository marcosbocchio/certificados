# Auditoria Inicial De Ayuda ENOD

## Resumen
Se relevo la estructura actual de ayuda para ordenar la primera ola de carga con criterio de cobertura rapida. La base ya permite publicar una ayuda funcional sin esperar manuales completos para todos los modulos.

## Estado General
- `AyudaController` combina dos formatos: vistas detalladas historicas y ayudas introductorias basadas en `intro_simple`.
- `resources/views/ayuda/ayuda_general.blade.php` ya funciona como indice principal por familias funcionales.
- Existen `41` vistas Blade de ayuda en `resources/views/ayuda`.
- Existen `22` ayudas introductorias servidas desde `returnAyudaIntroView(...)`.
- Existen aproximadamente `50` assets en `public/img/ayuda` reutilizables para OT, informes, usuarios, navegacion y acciones puntuales.

## Clasificacion De Articulos

### Detallada vigente
- `cambiar_clave`
- `buscar_formularios`
- `visualizar_ot`
- `crear_ot`
- `asignar_operadores`
- `asignar_soldadores_usuarios`
- `asignar_procedimientos`
- `asignar_vehiculos`
- `visualizar_doc_operadores`
- `visualizar_procedimientos`
- `visualizar_vehiculos`
- `generar_informes`
- `generar_informes_ri`
- `generar_informes_pm`
- `generar_informes_lp`
- `generar_informes_us`
- `crear_parte_diario`
- `crear_certificados`
- `visualizar_parte_diario`
- `visualizar_certificados`
- `visualizacion_infomres`
- `creacion_remito`

### Introductoria vigente
- `perfil`
- `gestion_proveedores`
- `gestion_frentes`
- `gestion_vehiculos`
- `gestion_plantas`
- `gestion_contratistas`
- `gestion_permisos`
- `gestion_stock`
- `asistencia`
- `epp`
- `dosimetria_operador`
- `dosimetria_rx`
- `dosimetria_estados`
- `dosimetria_resumen`
- `historial_operadores`
- `reportes`
- `qr`
- `multimedia_gestion`
- `multimedia_visualizacion`
- `notificaciones`
- `modelos_3d`

### Existente pero debil o a revisar
- `ayuda_general`: buen indice, pero requiere seguir reflejando el estado real de cobertura.
- `crear_remito.blade.php`: vista existente no enlazada desde el controller actual; revisar si es legado o reserva.
- Vistas con nombres historicos mal escritos (`gesiton_normas`, `gesitonar_roles`, `visualizacion_infomres`, `gestiona_medidas`) funcionan, pero conviene tratarlas como deuda tecnica y no como modelo futuro.

### Faltante o no cubierto con intro propia
- `gestion_cliente`
- `gestion_comitente`
- `gestion_documentaciones`
- `gestion_equipos`
- `gestion_fuentes`
- `gestion_internoequipos`
- `gestion_materiales`
- `gestion_productos`
- `gestion_servicios`
- `gestion_soldadores`
- `gestion_unidadesdemedida`
- `gesiton_normas`
- `gestiona_medidas`
- `gesitonar_roles`
- `gestionar_internofuente`

## Criterio De Priorizacion
- Ola 1: mantener y estandarizar intros ya listas para publicar.
- Ola 2: revisar manuales largos de OT, informes y remitos.
- Ola 3: convertir maestros pendientes a intro funcional y decidir luego cuales merecen tutorial detallado.

## Riesgos Detectados
- Parte del contenido historico puede no reflejar del todo la UI actual.
- El inventario de assets visuales no cubre todos los modulos introducidos en las ayudas nuevas.
- La mezcla de nombres historicos y nuevos en vistas/controller complica el mantenimiento si no se documenta.
