## Manual de uso: Combinaciones de servicios en Certificados

### Objetivo
Describir cómo gestionar combinaciones de servicios en la UI (`resources/js/components/certificados/certificados.vue`) y cómo se calculan en el PDF (`app/Http/Controllers/PdfCertificadoController.php`).

---

### 1) UI: certificados.vue

#### 1.1 Selección y carga
- Al marcar partes, se cargan sus servicios en `TablaPartesServicios` con, entre otros, estos campos por ítem: `fecha`, `fecha_formateada`, `obra`, `abreviatura`, `combinado_sn`, `nro_combinacion`, `prev_nro_combinacion`, `manual_uncombined_sn`, `combinacion`, `visible`.

#### 1.2 Combinación automática (cargarCombinados)
- Agrupa por día: misma `fecha_formateada` (se ignora la `obra`).
- Se combinan abreviaturas cuando:
  - `combinado_sn === true` y
  - hay al menos 2 abreviaturas distintas ese día y obra.
- Etiqueta de combinación: abreviaturas ordenadas alfabéticamente y luego invertidas, unidas por `" + "` (ej.: `RID + LPD`).
- Numeración automática: durante el recálculo, se asigna un contador incremental por día (solo a los ítems no descombinados manualmente). Los ítems no combinados muestran `combinacion = abreviatura`.
- Seguridad: no se toca `prev_nro_combinacion` al recomputar.

#### 1.3 Acciones manuales por ítem
- Botón X (descombinar):
  - Solo visible si `nro_combinacion > 0` y `manual_uncombined_sn == false`.
  - Regla de parejas entre obras:
    - Descombina la fila clickeada.
    - Además descombina, dentro del mismo grupo (misma `fecha_formateada` y `nro_combinacion`), una fila de OTRA `obra` y abreviatura DIFERENTE (pareja cruzada).
    - Si el grupo restante queda con menos de 2 abreviaturas, se descombina todo el grupo.
  - Setea: `manual_uncombined_sn = true`, `nro_combinacion = ''`, `combinacion = ''` en filas afectadas y luego completa no combinados con la abreviatura.

- Botón flecha (recombinar):
  - Si existe `prev_nro_combinacion > 0`, restaura ese número y recalcula la etiqueta del grupo restaurado (misma fecha, sin importar la obra).
  - Si NO existe número previo (por ejemplo, tras guardar y volver a editar):
    - Busca abreviaturas combinables ese mismo día (incluyendo la abreviatura del ítem). Si hay al menos 2, crea una nueva combinación.
    - Asignación del número: toma el máximo `nro_combinacion` global en toda la tabla y usa `max + 1`.
    - Aplica `nro_combinacion = newNro`, `prev_nro_combinacion = newNro`, `manual_uncombined_sn = false` y etiqueta calculada a las filas del día que integran la combinación.
    - No combina con servicios de otra fecha.

- Botón “-” (ocultar fila):
  - Si la fila pertenece a un grupo combinado activo, primero descombina ese grupo específico (ver X) y luego oculta la fila (`visible = false`, `cant_final = ''`).
  - No fuerza un recálculo global que renumere otros grupos.

#### 1.4 Reglas de etiquetas y no combinados
- Si `nro_combinacion == ''`, el ítem queda “no combinado” y `combinacion` se setea como su propia `abreviatura`.
- Las etiquetas se construyen con abreviaturas únicas del grupo, ordenadas A→Z y luego invertidas, unidas por `" + "`.

---

### 2) PDF: PdfCertificadoController

Archivo: `app/Http/Controllers/PdfCertificadoController.php`

#### 2.1 Fuente de datos
- `getServiciosCertificados` devuelve los servicios con `obra`, `fecha_formateada`, `abreviatura`, `nro_combinacion`, `combinacion`, y cantidad (nombrada como `cant_final`/`cantidad`/`cant_total` según el contexto).

#### 2.2 Cálculo de servicios por obra: buildServiciosObrasFromServiciosParte
- Determina grupos combinados cuando `nro_combinacion > 0`.
- Para cada grupo combinado (misma `obra`, `fecha_formateada`, y `nro_combinacion`):
  - Suma cantidades por `abreviatura`.
  - Unidades combinadas = mínimo de esas cantidades por abreviatura.
  - Suma el mínimo a la fila de la etiqueta de combinación (ej.: `RID + LPD`).
  - Los excedentes (`cantidad - mínimo`) se suman como servicios individuales por abreviatura.
- Para ítems NO combinados: se suman como individuales usando la `abreviatura`.
- Extracción robusta de cantidad: usa `cant_final`, si no `cantidad`, si no `cant_total`.

Ejemplo:
- Parte A: `LPD = 1` (combinable)
- Parte B: `RID = 20` (combinable)
- Grupo combinado (mismo día y obra):
  - Combinado: `(RID + LPD) = min(1, 20) = 1`
  - Sobran `19` de `RID` → se suman a la fila individual `RID`.

#### 2.3 Tablas por obra
- `generarTablasPorObras` muestra, por cada obra, las filas de servicios (con etiquetas de combinaciones y abreviaturas individuales) y los totales de productos por unidad de medida.
- Para certificados “agrupados” (`/pdf/certificado/{id}/final/agrupado`), se agrupan además partes/servicios/productos por fecha para la vista, sin alterar la lógica de totales por obra.

---

### 3) Buenas prácticas y notas
- La combinación se limita a ítems del mismo día (`fecha_formateada`), independientemente de la `obra`.
- `combinado_sn` debe ser `true` en los servicios para que sean combinables.
- La numeración automática durante un recálculo completo es por fecha; las recombinaciones manuales sin número previo usan numeración global creciente (`max + 1`).
- La X no se muestra si no hay número de combinación (> 0), evitando acciones inválidas.
- El borrado de fila primero descombina según la regla de parejas y luego oculta la fila; no renumera grupos ajenos.

---

### 4) Rutas útiles
- Certificado agrupado (PDF): `/pdf/certificado/{id}/final/agrupado`


