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
                        <ul class="ayuda_action_list">
                            @foreach($section['items'] as $item)
                                @php
                                    $parts = explode(':', $item, 2);
                                    $actionLabel = trim($parts[0]);
                                    $actionDescription = isset($parts[1]) ? trim($parts[1]) : '';
                                    $actionKey = strtolower($actionLabel);
                                    $buttonClass = 'btn btn-default btn-sm ayuda_btn_demo';
                                    $buttonText = $actionLabel;
                                    $buttonIcon = '';
                                    $buttonMode = 'text';

                                    if (str_contains($actionKey, 'guardar') || str_contains($actionKey, 'nuevo') || str_contains($actionKey, 'buscar') || str_contains($actionKey, 'filtrar')) {
                                        $buttonClass = 'btn btn-enod btn-sm ayuda_btn_demo';
                                    } elseif (str_contains($actionKey, 'editar')) {
                                        $buttonClass = 'btn btn-warning btn-sm ayuda_btn_demo';
                                    } elseif (str_contains($actionKey, 'eliminar')) {
                                        $buttonClass = 'btn btn-enod-danger btn-sm ayuda_btn_demo';
                                    } elseif (str_contains($actionKey, 'exportar') || str_contains($actionKey, 'descargar') || str_contains($actionKey, 'abrir') || str_contains($actionKey, 'consultar') || str_contains($actionKey, 'ver ')) {
                                        $buttonClass = 'btn btn-default btn-sm ayuda_btn_demo';
                                    }

                                    if (str_contains($actionKey, 'editar')) {
                                        $buttonIcon = 'fa fa-edit';
                                        $buttonText = '';
                                        $buttonMode = 'icon';
                                    } elseif (str_contains($actionKey, 'eliminar')) {
                                        $buttonIcon = 'fa fa-trash';
                                        $buttonText = '';
                                        $buttonMode = 'icon';
                                    } elseif (str_contains($actionKey, 'exportar pdf') || str_contains($actionKey, 'pdf')) {
                                        $buttonIcon = 'fa fa-file-pdf-o';
                                        $buttonText = '';
                                        $buttonMode = 'icon';
                                    } elseif (str_contains($actionKey, 'buscar')) {
                                        $buttonIcon = 'fa fa-search';
                                        $buttonText = 'Buscar';
                                    } elseif (str_contains($actionKey, 'filtrar')) {
                                        $buttonIcon = 'fa fa-filter';
                                        $buttonText = 'Filtrar';
                                    } elseif (str_contains($actionKey, 'nuevo')) {
                                        $buttonIcon = 'fa fa-plus';
                                        $buttonText = 'Nuevo';
                                    } elseif (str_contains($actionKey, 'guardar')) {
                                        $buttonIcon = 'fa fa-save';
                                        $buttonText = 'Guardar';
                                    } elseif (str_contains($actionKey, 'descargar')) {
                                        $buttonIcon = 'fa fa-download';
                                        $buttonText = '';
                                        $buttonMode = 'icon';
                                    } elseif (str_contains($actionKey, 'clonar')) {
                                        $buttonIcon = 'fa fa-copy';
                                        $buttonText = '';
                                        $buttonMode = 'icon';
                                    } elseif (str_contains($actionKey, 'firmar')) {
                                        $buttonIcon = 'glyphicon glyphicon-pencil';
                                        $buttonText = '';
                                        $buttonMode = 'icon';
                                    } elseif (str_contains($actionKey, 'consultar listado')) {
                                        $buttonIcon = 'fa fa-table';
                                        $buttonText = '';
                                        $buttonMode = 'icon';
                                    } elseif (str_contains($actionKey, 'abrir visualizador')) {
                                        $buttonIcon = 'fa fa-cube';
                                        $buttonText = '';
                                        $buttonMode = 'icon';
                                    } elseif (str_contains($actionKey, 'ver notificacion') || str_contains($actionKey, 'consultar qr') || str_contains($actionKey, 'abrir documentacion')) {
                                        $buttonIcon = 'fa fa-external-link';
                                        $buttonText = '';
                                        $buttonMode = 'icon';
                                    }
                                @endphp
                                <li class="ayuda_action_item">
                                    <button type="button" class="{{ $buttonClass }} {{ $buttonMode === 'icon' ? 'ayuda_btn_demo--icon' : '' }}" tabindex="-1" aria-hidden="true">
                                        @if($buttonIcon)
                                            <span class="{{ $buttonIcon }}" aria-hidden="true"></span>
                                        @endif
                                        @if($buttonText)
                                            <span>{{ $buttonText }}</span>
                                        @endif
                                    </button>
                                    @if($actionDescription)
                                        <span>{{ $actionDescription }}</span>
                                    @endif
                                </li>
                            @endforeach
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
