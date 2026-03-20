@php
    $functionalSummaryTitle = $functionalSummaryTitle ?? 'Resumen funcional';
    $functionalSummarySections = $functionalSummarySections ?? [];
    $functionalSummaryRelated = $functionalSummaryRelated ?? [];
@endphp

@if(count($functionalSummarySections) || count($functionalSummaryRelated))
    <section class="ayuda_section">
        <div class="ayuda_panel">
            <h2>{{ $functionalSummaryTitle }}</h2>

            @foreach($functionalSummarySections as $section)
                <div class="ayuda_summary_block">
                    @if(!empty($section['title']))
                        <h3>{{ $section['title'] }}</h3>
                    @endif

                    @if(!empty($section['paragraphs']))
                        @foreach($section['paragraphs'] as $paragraph)
                            <p>{{ $paragraph }}</p>
                        @endforeach
                    @endif

                    @if(!empty($section['items']))
                        @if($section['title'] === 'Botones y acciones disponibles')
                            <p>Los ejemplos de abajo representan como se ven las acciones reales en la pantalla o en la tabla correspondiente.</p>
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
                </div>
            @endforeach

            @if(count($functionalSummaryRelated))
                <div class="ayuda_summary_block">
                    <h3>Articulos relacionados</h3>
                    <ul class="ayuda_links">
                        @foreach($functionalSummaryRelated as $link)
                            <li><a href="{{ $link['href'] }}">{{ $link['label'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </section>
@endif
