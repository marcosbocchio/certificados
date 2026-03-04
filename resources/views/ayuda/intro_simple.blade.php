@extends('layouts.enod.master')

@section('contenido')

<div class="ayuda_enod ayuda_enod_intro">
    @php
        $summary = $summary ?? ($paragraphs ?? []);
        $sections = $sections ?? [];
        $related = $related ?? [];
        $visuals = $visuals ?? [];

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
        <div class="ayuda_meta">
            <span class="ayuda_badge">Ayuda en desarrollo</span>
            @if(count($visuals))
                <span class="ayuda_badge ayuda_badge_soft">Multimedia pendiente</span>
            @endif
        </div>
    </div>

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
                <h2>Soporte visual recomendado</h2>
                <p>
                    Esta pagina ya queda util para orientacion funcional. Para cerrarla como ayuda operativa conviene
                    sumar capturas o GIFs en estos puntos:
                </p>
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

    <div class="ayuda_notice">
        Esta guia introductoria ya queda publicada dentro de la ayuda general. El detalle paso a paso se puede ampliar
        despues sin perder la estructura de navegacion ni los vinculos con otros modulos.
    </div>
</div>

@endsection
