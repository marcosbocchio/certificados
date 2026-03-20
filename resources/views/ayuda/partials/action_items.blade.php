@foreach($items as $item)
    @php
        $actionLabel = is_array($item) ? ($item['label'] ?? '') : trim(explode(':', $item, 2)[0]);
        $actionDescription = is_array($item)
            ? ($item['description'] ?? '')
            : trim(explode(':', $item, 2)[1] ?? '');
        $actionKey = mb_strtolower($actionLabel);
        $buttonClass = 'btn btn-default btn-sm ayuda_btn_demo';
        $buttonText = $actionLabel;
        $buttonIcon = '';
        $buttonMode = 'text';

        if (is_array($item) && !empty($item['class'])) {
            $buttonClass = $item['class'];
        } elseif (str_contains($actionKey, 'guardar') || str_contains($actionKey, 'nuevo') || str_contains($actionKey, 'buscar') || str_contains($actionKey, 'filtrar') || str_contains($actionKey, 'actualizar')) {
            $buttonClass = 'btn btn-enod btn-sm ayuda_btn_demo';
        } elseif (str_contains($actionKey, 'editar')) {
            $buttonClass = 'btn btn-warning btn-sm ayuda_btn_demo';
        } elseif (str_contains($actionKey, 'eliminar')) {
            $buttonClass = 'btn btn-enod-danger btn-sm ayuda_btn_demo';
        } elseif (str_contains($actionKey, 'exportar') || str_contains($actionKey, 'descargar') || str_contains($actionKey, 'abrir') || str_contains($actionKey, 'consultar') || str_contains($actionKey, 'ver ') || str_contains($actionKey, 'firm')) {
            $buttonClass = 'btn btn-default btn-sm ayuda_btn_demo';
        }

        if (is_array($item) && array_key_exists('text', $item)) {
            $buttonText = $item['text'];
        }

        if (is_array($item) && !empty($item['icon'])) {
            $buttonIcon = $item['icon'];
            $buttonMode = $item['mode'] ?? 'icon';
        } elseif (str_contains($actionKey, 'editar')) {
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
            $buttonIcon = 'fa fa-plus-circle';
            $buttonText = 'Nuevo';
        } elseif (str_contains($actionKey, 'guardar')) {
            $buttonIcon = 'fa fa-save';
            $buttonText = 'Guardar';
        } elseif (str_contains($actionKey, 'actualizar')) {
            $buttonIcon = 'fa fa-refresh';
            $buttonText = 'Actualizar';
        } elseif (str_contains($actionKey, 'descargar')) {
            $buttonIcon = 'fa fa-download';
            $buttonText = '';
            $buttonMode = 'icon';
        } elseif (str_contains($actionKey, 'clonar')) {
            $buttonIcon = 'fa fa-clone';
            $buttonText = '';
            $buttonMode = 'icon';
        } elseif (str_contains($actionKey, 'firmar') || str_contains($actionKey, 'firma')) {
            $buttonIcon = 'glyphicon glyphicon-pencil';
            $buttonText = '';
            $buttonMode = 'icon';
        } elseif (str_contains($actionKey, 'usuarios')) {
            $buttonIcon = 'fa fa-users';
            $buttonText = '';
            $buttonMode = 'icon';
        } elseif (str_contains($actionKey, 'historial')) {
            $buttonIcon = 'fa fa-table';
            $buttonText = '';
            $buttonMode = 'icon';
        } elseif (str_contains($actionKey, 'revisiones')) {
            $buttonIcon = 'fa fa-history';
            $buttonText = '';
            $buttonMode = 'icon';
        } elseif (str_contains($actionKey, 'escaneados')) {
            $buttonIcon = 'fa fa-paperclip';
            $buttonText = '';
            $buttonMode = 'icon';
        } elseif (str_contains($actionKey, 'ver detalles')) {
            $buttonIcon = 'fa fa-list-alt';
            $buttonText = '';
            $buttonMode = 'icon';
        } elseif (str_contains($actionKey, 'abrir visualizador')) {
            $buttonIcon = 'fa fa-cube';
            $buttonText = '';
            $buttonMode = 'icon';
        } elseif (str_contains($actionKey, 'anular')) {
            $buttonIcon = 'fa fa-ban';
            $buttonText = '';
            $buttonMode = 'icon';
        } elseif (str_contains($actionKey, 'desanular')) {
            $buttonIcon = 'fa fa-check';
            $buttonText = '';
            $buttonMode = 'icon';
        } elseif (str_contains($actionKey, 'abrir') || str_contains($actionKey, 'consultar') || str_contains($actionKey, 'ver ')) {
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
            <span class="ayuda_action_description">{{ $actionDescription }}</span>
        @endif
    </li>
@endforeach
