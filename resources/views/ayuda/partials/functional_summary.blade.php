@php
    $functionalSummaryTitle = $functionalSummaryTitle ?? 'Resumen funcional';
    $functionalSummarySections = $functionalSummarySections ?? [];
    $functionalSummaryRelated = $functionalSummaryRelated ?? [];
@endphp

@if(count($functionalSummarySections) || count($functionalSummaryRelated))
    <section class="ayuda_section ayuda_section--summary-title">
        <h2 class="ayuda_section_title">{{ $functionalSummaryTitle }}</h2>
    </section>

    @for($i = 0; $i < count($functionalSummarySections); $i++)
        @php
            $section = $functionalSummarySections[$i];
            $sectionTypeClass = '';

            if (!empty($section['title'])) {
                if ($section['title'] === 'Ruta de uso') {
                    $sectionTypeClass = 'ayuda_panel--route';
                } elseif ($section['title'] === 'Campos obligatorios') {
                    $sectionTypeClass = 'ayuda_panel--required';
                } elseif ($section['title'] === 'Acciones bloqueadas por estado o permiso') {
                    $sectionTypeClass = 'ayuda_panel--blocked';
                }
            }
        @endphp
        <section class="ayuda_section">
            <div class="ayuda_panel {{ $sectionTypeClass }}">
                <div class="ayuda_summary_block">
                    @if(!empty($section['title']))
                        <h2 class="ayuda_panel_title">{{ $section['title'] }}</h2>
                    @endif

                    @if(!empty($section['paragraphs']))
                        @foreach($section['paragraphs'] as $paragraph)
                            <p>{{ $paragraph }}</p>
                        @endforeach
                    @endif

                    @if(!empty($section['items']))
                        @if($section['title'] === 'Botones y acciones disponibles')
                            <p class="ayuda_intro_hint">Los ejemplos de abajo representan como se ven las acciones reales en la pantalla o en la tabla correspondiente.</p>
                            <ul class="ayuda_action_list">
                                @include('ayuda.partials.action_items', ['items' => $section['items']])
                            </ul>
                        @else
                            <ul>
                                @foreach($section['items'] as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        @endif
                    @endif

                    @if(!empty($section['demo_table']))
                        @include('ayuda.partials.demo_table', ['demoTable' => $section['demo_table']])
                    @endif
                </div>
            </div>
        </section>
    @endfor

    @if(count($functionalSummaryRelated))
        <section class="ayuda_section">
            <div class="ayuda_panel">
                <div class="ayuda_summary_block">
                    <h2 class="ayuda_panel_title">Articulos relacionados</h2>
                    <ul class="ayuda_links">
                        @foreach($functionalSummaryRelated as $link)
                            <li><a href="{{ $link['href'] }}">{{ $link['label'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </section>
    @endif
@endif
