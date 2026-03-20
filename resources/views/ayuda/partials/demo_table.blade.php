@php
    $demoTable = $demoTable ?? [];
    $demoColumns = $demoTable['columns'] ?? [];
    $demoRows = $demoTable['rows'] ?? [];
    $demoCaption = $demoTable['caption'] ?? null;
@endphp

@if(count($demoColumns) && count($demoRows))
    <div class="ayuda_demo_table_wrap">
        @if($demoCaption)
            <p class="ayuda_demo_table_caption">{{ $demoCaption }}</p>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped ayuda_demo_table">
                <thead>
                    <tr>
                        @foreach($demoColumns as $column)
                            <th>{{ $column }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($demoRows as $row)
                        <tr>
                            @foreach($row as $cell)
                                <td>
                                    @if(is_array($cell) && ($cell['type'] ?? null) === 'actions')
                                        <ul class="ayuda_action_list ayuda_action_list--inline">
                                            @include('ayuda.partials.action_items', ['items' => $cell['items'] ?? []])
                                        </ul>
                                    @elseif(is_array($cell) && ($cell['type'] ?? null) === 'badge')
                                        <span class="ayuda_demo_badge {{ $cell['class'] ?? '' }}">{{ $cell['text'] ?? '' }}</span>
                                    @else
                                        {{ is_array($cell) ? ($cell['text'] ?? '') : $cell }}
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
