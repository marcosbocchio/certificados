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

    <section class="ayuda_section">
        <div class="ayuda_panel">
            @if($articleAudience || count($prerequisites) || count($visuals))
                <h2>Antes de seguir</h2>
            @endif

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

            @if(count($visuals))
                <p><strong>Multimedia pendiente.</strong></p>
            @endif
        </div>
    </section>

    @foreach($sections as $section)
        <section class="ayuda_section">
            <div class="ayuda_panel">
                @if(!empty($section['manual_title']))
                    <h2>{{ $section['manual_title'] }}</h2>
                @endif

                @if(!empty($section['paragraphs']))
                    @foreach($section['paragraphs'] as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                @endif

                @if(!empty($section['items']))
                    <ul>
                        @foreach($section['items'] as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </section>
    @endforeach

    @if(count($visuals))
        <section class="ayuda_section">
            <div class="ayuda_panel">
                <h2>Multimedia pendiente</h2>
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
