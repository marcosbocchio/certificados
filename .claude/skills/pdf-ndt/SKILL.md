---
name: pdf-ndt
description: Guía para trabajar con los PDFs de informes NDT (RI, RD, PM, LP, US, TT, CV, RG, PMI, DZ) generados con DomPDF. Usar cuando se editen templates en `resources/views/reportes/informes/` o sus partials, se cambie el layout del header/footer, o se ajusten márgenes de página.
---

# pdf-ndt

## Stack
- **DomPDF** server-side vía `barryvdh/laravel-dompdf` (`PDF::loadView('...')`)
- Templates Blade en `resources/views/reportes/informes/` (uno por método: `pm-v2`, `lp-v2`, `ri-planta-v2`, `ri-perfiles-v2`, `rd-planta-v2`, `rd-perfiles-v2`, `us-v2`, `tt-v2`, `cv`, `dz`, `rg`, `pmi`)
- Partials compartidos en `resources/views/reportes/partial/`:
  - `header-principal-portrait` / `-landscape` (logo + título + nro informe + fecha)
  - `header-cliente-comitente-portrait` (cliente + comitente + logos)
  - `header-proyecto-portrait` (proyecto + obra + OT N°)
  - `linea-amarilla`, `linea-gris` (separadores)
- Partials de cuerpo en `resources/views/reportes/informes/partial/`:
  - `header-detalle-{metodo}-portrait` (datos técnicos del ensayo)
  - `observaciones`, `firmas`, `referencias`
- CSS común en `public/css/reportes/pdf.css`
- Paleta ENOD: `#4F8CFF` primary · `#1C2340` dark · `#64748B` muted · `#F0F5FF` light-bg · `#CBD5E1` border · `#EBF2FF` thead

## Modelo de posicionamiento (CRÍTICO)

DomPDF interpreta `position:fixed; top: -Xpx` en `<header>` como **offset desde el inicio del body (`@page margin-top`), NO desde el top de página**:

```
header_top_real  = @page.margin_top + header.top      (header.top es negativo)
header_bottom    = header_top_real + headerHeight
body_starts_at   = @page.margin_top
```

**Para evitar overlap del header con el body:**

```
|header.top|  ≥  headerHeight + buffer
```

Equivalentemente: `header.top + headerHeight < 0`.

### Configuración v2 actual

```css
@page { margin: 180px 40px 230px 40px !important; }
header { position: fixed; top: -180px; }
footer { position: fixed; bottom: 0px; }
```

Con header v2 de ~150px de alto: header se renderiza de y=0 a y=150, body arranca en y=180, deja ~30px de aire. Footer análogo desde abajo.

### Trampa común

Aumentar `@page margin-top` SIN tocar `header.top` no resuelve overlap — el header baja con el margen porque su posición real es `margin_top + top`. Hay que **mover los dos juntos**, o hacer `top` más negativo.

## Logos

- `public/img/logo-enod.png` — versión negra (1681×936, ratio ~1.8:1), la actual.
- `public/img/logo-enod-web.jpg` — versión antigua color.
- `public/img/logo-enod-t.png` — variante.

### Estilo en celdas estrechas (125px portrait / 130px landscape)

```html
<img src="{{ public_path('img/logo-enod.png') }}"
     style="width:100%;max-height:50px;height:auto;display:block;">
```

- `width:100%` → llena el ancho del td.
- `max-height:50px` → **imprescindible**, evita que el logo se infle verticalmente y rompa el cálculo del header.
- Sin cap, un logo 1.8:1 en celda de 125px renderiza ~70px de alto vs los 45px previos → +25px de header → overlap con body.

## Footer

```css
footer { position: fixed; bottom: 0px; }
@page { margin-bottom: 230px; }
```

Contiene observaciones + línea amarilla + firmas. Mismo modelo de cálculo aplica al revés. Si crece el contenido del footer, hay que aumentar `margin-bottom` proporcionalmente.

## Convenciones

- Hay templates v1 (sin sufijo) y v2 en paralelo. Los v2 usan partials modulares y el diseño nuevo con líneas amarillas/grises. Algunos templates nuevos no llevan sufijo (`pmi`, `cv`, `dz`, `rg`).
- `template-informe-v2.blade.php` es la base genérica.
- `referencias-v2.blade.php` se usa para la página final con imágenes/referencias.
- Cada template carga `pdf.css` global + estilos inline para `@page` y `header/footer/main`.
- Los controllers en `app/Http/Controllers/PdfInformes{Metodo}Controller.php` llaman `PDF::loadView('reportes.informes.{template}', compact(...))`.

## Templates v2 con el patrón estándar

Estos 19 templates comparten el patrón `@page margin: 180px 40px 230px 40px` + `header top: -180px`:

**Portrait (a4 portrait):**
```
us-v2, tt-v2, template-informe-v2, pm-v2,
ri-planta-v2, ri-perfiles-v2, rg, referencias-v2,
lp-v2, informeRIESUCO, dz, rd-planta-v2,
cv, pmi, rd-perfiles-v2
```

**Landscape (a4 landscape, gasoducto con múltiples pasadas):**
```
ri-gasoducto-6-v2, ri-gasoducto-12-v2,
rd-gasoducto-6-v2, rd-gasoducto-12-v2
```

Las versiones landscape incluyen los partials `header-{principal,cliente-comitente,proyecto}-landscape` (las portrait incluyen las `-portrait`). Ambos juegos tienen altura similar (~150px) así que comparten el mismo patrón de `@page` y `header.top`.

La orientación se define en el controller con `->setPaper('a4', 'portrait'|'landscape')`, no en el template. Verificar siempre en el controller cuál es la orientación antes de tocar el template.

Para edits masivos del @page o del header, recorrer la lista completa.

## Cache

- Blade compila views a `storage/framework/views/*.php`. Mtime de la fuente normalmente fuerza recompilación, pero si algo no se refleja en el PDF generado:
  ```powershell
  Remove-Item storage\framework\views\*.php -Force
  ```
- En este entorno (Windows + Laragon) `php` no está en PATH del shell, así que `php artisan view:clear` falla. Borrar archivos directo.
- DomPDF cachea fuentes en `storage/fonts/` — no tocar salvo cambio de fuente.

## Edits masivos (PowerShell)

`Set-Content -Encoding utf8NoBOM` **NO existe** en la PowerShell 5.1 de este sistema. Usar `[System.IO.File]::WriteAllText` para evitar BOM y preservar encoding:

```powershell
$files = @('pm-v2','lp-v2','ri-planta-v2','...')
foreach ($f in $files) {
    $p = (Resolve-Path "resources\views\reportes\informes\$f.blade.php").Path
    $c = [System.IO.File]::ReadAllText($p)
    $c = $c -replace 'top: -140px','top: -180px'
    [System.IO.File]::WriteAllText($p, $c)
}
```

## Checklist al tocar PDFs NDT

1. **¿Cambió la altura del header?** (logo, partials agregados/sacados)
   → Recalcular `header.top` (más negativo) y/o `@page margin-top`.
2. **¿Cambió la altura del footer?**
   → Recalcular `@page margin-bottom`.
3. **¿Es portrait o landscape?**
   → Hay dos juegos de partials (`-portrait` vs `-landscape`).
4. **¿El cambio aplica a todos los métodos?**
   → Recorrer los 15 templates v2 con edits masivos.
5. **¿Tocaste un `<img>`?**
   → Siempre poner `max-height` o `max-width` cap, no dejar dimensión libre.
6. **Después del cambio:**
   → Borrar `storage/framework/views/*.php` y regenerar el PDF para verificar.

## Diagnóstico rápido de overlap

Si header se solapa con body en el PDF generado:

| Síntoma | Causa probable | Fix |
|---|---|---|
| Última fila del header pisa primera fila del body | `|header.top| < headerHeight` | Bajar `header.top` (más negativo) |
| Body arranca muy lejos del header | `|header.top| >> headerHeight` | Subir `header.top` o reducir `@page margin-top` |
| Cambio en CSS no se ve en PDF | View cache no se invalidó | Borrar `storage/framework/views/*.php` |
| Aparece overlap después de cambiar un `<img>` | Imagen sin cap creció vertical | Agregar `max-height` |
