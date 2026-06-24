@php
$pasadasPorNumero = collect($pasadas_juntas)
    ->where('junta_id', $junta_posicion->id)
    ->keyBy('numero');
@endphp

<tr>
    {{-- Pk --}}
    <td class="bordered-td" style="font-size:10px;width:30px;text-align:center;" rowspan="4">
        {{ $informe->km !== null ? $informe->km : '' }}
    </td>
    {{-- Elem --}}
    <td class="bordered-td" style="font-size:10px;width:51px;text-align:center;" rowspan="4">
        {!! $junta_posicion->junta ?? '&nbsp;' !!}
    </td>
    {{-- Tipo --}}
    <td class="bordered-td" style="font-size:10px;width:30px;text-align:center;" rowspan="4">
        {!! $ot_tipo_soldadura->TipoSoldadura->codigo ?? '&nbsp;' !!}
    </td>

    {{-- Header pasadas 1-6 --}}
    @foreach ([1,2,3,4,5,6] as $num)
        <td class="bordered-td" style="font-size:11px;text-align:center;" colspan="{{ $num === 1 ? 3 : 2 }}">{{ $num }}° Pasada</td>
    @endforeach

    {{-- Posicion placa --}}
    <td class="bordered-td" style="font-size:9px;width:45px;text-align:center;" rowspan="4">
        {!! $junta_posicion->codigo ?? '&nbsp;' !!}
    </td>
    {{-- Mng --}}
    <td class="bordered-td" style="font-size:9px;width:30px;text-align:center;" rowspan="4">
        {{ $junta_posicion->mng !== null ? intval($junta_posicion->mng) : '' }}
    </td>
    {{-- SNRn --}}
    <td class="bordered-td" style="font-size:9px;width:30px;text-align:center;" rowspan="4">
        {{ $junta_posicion->snrn !== null ? intval($junta_posicion->snrn) : '' }}
    </td>
    {{-- Tipo defecto --}}
    <td class="bordered-td" style="font-size:9px;width:85px;text-align:center;" rowspan="4">
        @php $primero = true; @endphp
        @foreach ($defectos_posiciones as $def)
            @if ($def->posicion_id == $junta_posicion->posicion_id)
                @if (!$primero) / @endif
                {{ $def->codigo }}
                @php $primero = false; @endphp
            @endif
        @endforeach
        @if ($primero) &nbsp; @endif
    </td>
    {{-- Posicion defecto --}}
    <td class="bordered-td" style="font-size:9px;width:130px;text-align:center;" rowspan="4">
        @php $primero = true; @endphp
        @foreach ($defectos_posiciones as $def)
            @if ($def->posicion_id == $junta_posicion->posicion_id && $def->posicion !== null && $def->posicion !== '')
                @if (!$primero) / @endif
                @php
                    if (!empty($def->pasada)) {
                        if ($def->pasada === 'RAIZ') $sector = 'R';
                        elseif ($def->pasada === 'RELLENO') $sector = 'Y';
                        elseif ($def->pasada === 'SOBREMONTA') $sector = 'S';
                        else $sector = '';
                        $valor = $def->codigo . '(' . $def->posicion . ')' . $sector;
                    } else {
                        $valor = $def->codigo . '(' . $def->posicion . ')';
                    }
                @endphp
                {{ $valor }}
                @php $primero = false; @endphp
            @endif
        @endforeach
        @if ($primero) &nbsp; @endif
    </td>
    {{-- AP --}}
    <td class="bordered-td" style="font-size:9px;width:20px;text-align:center;" rowspan="4">
        @if ($junta_posicion->aceptable_sn) X @else &nbsp; @endif
    </td>
    {{-- RZ --}}
    <td class="bordered-td" style="font-size:9px;text-align:center;" rowspan="4">
        @if (!$junta_posicion->aceptable_sn) X @else &nbsp; @endif
    </td>
</tr>

{{-- Datos pasadas 1-6 --}}
<tr>
    @for ($i = 1; $i <= 6; $i++)
        @php $p = $pasadasPorNumero->get($i); @endphp
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

{{-- Header pasadas 7-12 --}}
<tr>
    @foreach ([7,8,9,10,11,12] as $num)
        <td class="bordered-td" style="font-size:11px;text-align:center;" colspan="{{ $num === 7 ? 3 : 2 }}">{{ $num }}° Pasada</td>
    @endforeach
</tr>

{{-- Datos pasadas 7-12 --}}
<tr>
    @for ($i = 7; $i <= 12; $i++)
        @php $p = $pasadasPorNumero->get($i); @endphp
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
