@php
    // Agrupar pasadas de esta junta por número (1–12)
    $pasadasPorNumero = collect($pasadas_juntas)
        ->where('junta_id', $junta_posiciones->junta_id ?? $junta_posiciones->id)
        ->keyBy('numero');
@endphp

<tr>
    {{-- Columna: KM --}}
    <td class="bordered-td" style="font-size:10px; width:30px;text-align: center" rowspan="4">
        {{ $informe->km == -1 ? 'PDJ' : $informe->km }}
    </td>

    {{-- Columna: Junta --}}
    <td class="bordered-td" style="font-size:10px;width:51px;text-align: center" rowspan="4">
        {!! $junta_posiciones->junta ?? '&nbsp;' !!}
    </td>

    {{-- Columna: Tipo soldadura --}}
    <td class="bordered-td" style="font-size:10px;width:30px;text-align: center" rowspan="4">
        {!! $ot_tipo_soldadura->TipoSoldadura->codigo ?? '&nbsp;' !!}
    </td>

    {{-- Encabezados pasadas 1–6 --}}
    @foreach ([1,2,3,4,5,6] as $num)
        <td class="bordered-td" style="font-size:11px;text-align:center;"
            colspan="{{ $num === 1 ? 3 : 2 }}">{{ $num }}° Pasada</td>
    @endforeach

    {{-- Columna: Código / Densidad / Defectos --}}
    <td class="bordered-td" style="font-size:9px;width:45px;text-align:center;" rowspan="4">
        {!! $junta_posiciones->codigo ?? '&nbsp;' !!}
    </td>
    <td class="bordered-td" style="font-size:9px;width:21.5px;text-align:center;" rowspan="4">
        {!! $junta_posiciones->densidad ?? '&nbsp;' !!}
    </td>

    {{-- Columna: Tipo de defecto --}}
    <td class="bordered-td" style="font-size:9px;width:85px;text-align:center;" rowspan="4">
        @php $primero = true; @endphp
        @foreach ($defectos_posiciones as $def)
            @if ($def->posicion_id == $junta_posiciones->posicion_id)
                @if (!$primero) / @endif
                {{ $def->codigo }}
                @php $primero = false; @endphp
            @endif
        @endforeach
        @if ($primero)
            &nbsp;
        @endif
    </td>

    {{-- Columna: Posición / Sector --}}
    <td class="bordered-td" style="font-size:9px;width:170px;text-align:center;" rowspan="4">
        @php $primero = true; @endphp
        @foreach ($defectos_posiciones as $def)
            @if ($def->posicion_id == $junta_posiciones->posicion_id)
                @if (!$primero) / @endif
                @php
                    if ($def->pasada === 'RAIZ') {
                        $sector = 'R';
                    } elseif ($def->pasada === 'RELLENO') {
                        $sector = 'Y';
                    } elseif ($def->pasada === 'SOBREMONTA') {
                        $sector = 'S';
                    } else {
                        $sector = '';
                    }
                    $valor = $def->codigo . '(' . $def->posicion . ')' . $sector;
                @endphp
                {{ $valor }}
                @php $primero = false; @endphp
            @endif
        @endforeach
        @if ($primero)
            &nbsp;
        @endif
    </td>

    {{-- Resultado --}}
    <td class="bordered-td" style="font-size:9px;width:32.7px;text-align:center;" rowspan="4">
        @if ($informe_ri->resultado_pdf_sn && $junta_posiciones->aceptable_sn)
            X
        @else
            &nbsp;
        @endif
    </td>
    <td class="bordered-td" style="font-size:9px;text-align:center;" rowspan="4">
        @if ($informe_ri->resultado_pdf_sn && !$junta_posiciones->aceptable_sn)
            X
        @else
            &nbsp;
        @endif
    </td>
</tr>

{{-- ====== PASADAS 1 A 6 ====== --}}
<tr>
    @for ($i = 1; $i <= 6; $i++)
        @php $p = $pasadasPorNumero[$i] ?? null; @endphp
        @if ($i === 1)
            <td class="bordered-td" style="font-size:9px;width:39px;text-align:center;">{!! $p->soldadorp ?? '&nbsp;' !!}</td>
            <td class="bordered-td" style="font-size:9px;width:37px;text-align:center;">{!! $p->soldadorl ?? '&nbsp;' !!}</td>
            <td class="bordered-td" style="font-size:9px;width:37px;text-align:center;">{!! $p->soldadorz ?? '&nbsp;' !!}</td>
        @else
            <td class="bordered-td" style="font-size:9px;width:36.8px;text-align:center;">{!! $p->soldadorp ?? '&nbsp;' !!}</td>
            <td class="bordered-td" style="font-size:9px;width:36.8px;text-align:center;">{!! $p->soldadorz ?? '&nbsp;' !!}</td>
        @endif
    @endfor
</tr>

{{-- ====== ENCABEZADOS PASADAS 7 A 12 ====== --}}
<tr>
    @foreach ([7,8,9,10,11,12] as $num)
        <td class="bordered-td" style="font-size:11px;text-align:center;"
            colspan="{{ $num === 7 ? 3 : 2 }}">{{ $num }}° Pasada</td>
    @endforeach
</tr>

{{-- ====== PASADAS 7 A 12 ====== --}}
<tr>
    @for ($i = 7; $i <= 12; $i++)
        @php $p = $pasadasPorNumero[$i] ?? null; @endphp
        @if ($i === 7)
            <td class="bordered-td" style="font-size:9px;width:39px;text-align:center;">{!! $p->soldadorp ?? '&nbsp;' !!}</td>
            <td class="bordered-td" style="font-size:9px;width:37px;text-align:center;">{!! $p->soldadorl ?? '&nbsp;' !!}</td>
            <td class="bordered-td" style="font-size:9px;width:37px;text-align:center;">{!! $p->soldadorz ?? '&nbsp;' !!}</td>
        @else
            <td class="bordered-td" style="font-size:9px;width:36.7px;text-align:center;">{!! $p->soldadorp ?? '&nbsp;' !!}</td>
            <td class="bordered-td" style="font-size:9px;width:36.7px;text-align:center;">{!! $p->soldadorz ?? '&nbsp;' !!}</td>
        @endif
    @endfor
</tr>
