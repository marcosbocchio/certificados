@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod ayuda_enod_intro">
    @php
        $summary = $summary ?? ($paragraphs ?? []);
        $sections = $sections ?? [];
        $related = $related ?? [];
        $visuals = $visuals ?? [];
        $meta = $meta ?? [];
        $prerequisites = $meta['prerequisites'] ?? [];
        $articleAudience = $meta['audience'] ?? null;
        $showVisuals = $meta['show_visuals'] ?? false;

        if ($sections && isset($sections[0]) && !is_array($sections[0])) {
            $sections = [
                [
                    'title' => 'Temas incluidos',
                    'items' => $sections,
                ],
            ];
        }
    @endphp

    <div class="ayuda_hero">
        <h1>{{ $title }}</h1>

        @foreach($summary as $paragraph)
            <p>{{ $paragraph }}</p>
        @endforeach
    </div>

    @if($articleAudience || count($prerequisites))
        <section class="ayuda_section">
            <div class="ayuda_panel">
                <h2>Antes de seguir</h2>

                @if($articleAudience)
                    <p><strong>Perfil de uso:</strong> {{ $articleAudience }}.</p>
                @endif

                @if(count($prerequisites))
                    <h3>Prerequisitos</h3>
                    <ul>
                        @foreach($prerequisites as $prerequisite)
                            <li>{{ $prerequisite }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </section>
    @endif

    @for($i = 0; $i < count($sections); $i++)
        @php
            $section = $sections[$i];
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
                @if(!empty($section['title']))
                    <h2>{{ $section['title'] }}</h2>
                @elseif(!empty($section['manual_title']))
                    <h2>{{ $section['manual_title'] }}</h2>
                @endif

                @if(!empty($section['paragraphs']))
                    @foreach($section['paragraphs'] as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                @endif

                @if(!empty($section['items']))
                    @if(!empty($section['title']) && $section['title'] === 'Botones y acciones disponibles')
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
        </section>
    @endfor

    @if($showVisuals && count($visuals))
        <section class="ayuda_section">
            <div class="ayuda_panel">
                <h2>Apoyo visual</h2>
                <ul>
                    @foreach($visuals as $visual)
                        <li>{{ $visual }}</li>
                    @endforeach
                </ul>
            </div>
        </section>
    @endif

    @if(count($related))
        <section class="ayuda_section">
            <div class="ayuda_panel">
                <h2>Articulos relacionados</h2>
                <ul class="ayuda_links">
                    @foreach($related as $link)
                        <li><a href="{{ $link['href'] }}">{{ $link['label'] }}</a></li>
                    @endforeach
                </ul>
            </div>
        </section>
    @endif

</div>

@endsection
