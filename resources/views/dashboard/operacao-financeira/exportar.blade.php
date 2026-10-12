@extends('layouts.layout-relatorio')

@section('content')
<table class="table">
    @if (!($empresa_logada->empresa->exibicao_relatorio == 'sintetico'))
    <thead>
        <tr>
            <th style="border: 1px solid #010101;padding: 2px;">#</th>
            <th style="border: 1px solid #010101;padding: 2px;">Referência</th>
            <th style="border: 1px solid #010101;padding: 2px;">{{ __('messages.estados') }}</th>
            <th style="border: 1px solid #010101;padding: 2px;">Dispesa/Receita</th>
            <th style="border: 1px solid #010101;padding: 2px;">Fornecedor/Cliente</th>
            <th style="border: 1px solid #010101;padding: 2px;text-align: right"> {{ __('messages.data') }} </th>
            <th style="border: 1px solid #010101;padding: 2px;">Pagamento/Recebimento</th>
            <th style="border: 1px solid #010101;padding: 2px;text-align: right">Motante</th>
        </tr>
    </thead>
    @endif

    <tbody>
        @php
        $totalReceita = 0;
        $totalDespesa = 0;
        $totalSaldo = 0;
        @endphp
        @foreach ($operacoes as $key => $item)

        @if (!($empresa_logada->empresa->exibicao_relatorio == 'sintetico'))
        <tr>
            <td style="padding: 3px">{{ $key + 1 }}</td>
            <td style="padding: 3px">{{ $item->nome ?? '' }}</td>
            <td style="padding: 3px">{{ $item->status ?? '' }}</td>
            <td style="padding: 3px">{{ $item->type == 'D' ? $item->dispesa->nome ?? '' : $item->receita->nome ?? '' }}</td>

            <td style="padding: 3px">
                {{ $item->type == 'D' ? ($item->fornecedor_id ? $item->fornecedor->nome ?? '' : $item->user->name ?? '') : ($item->cliente_id ? $item->cliente->nome : $item->user->name) }}
            </td>
            <td style="text-align: right">{{ $item->date_at }}</td>

            @if ($item->formas == 'C')
            <td style="padding: 3px">{{ $item->subconta->nome ?? '' }}</td>
            @else
            @if ($item->formas == 'B')
            <td style="padding: 3px">{{ $item->subconta->nome ?? '' }}</td>
            @else
            <td style="padding: 3px">Outras</td>
            @endif
            @endif

            @if ($item->type == 'D')
            <td style="padding: 3px;color: red;text-align: right">
                -{{ number_format($item->motante, 2, ',', '.') }}</td>
            @else
            <td style="padding: 3px;color: green;text-align: right">
                +{{ number_format($item->motante, 2, ',', '.') }}</td>
            @endif

        </tr>
        @endif

        @if ($item->type == 'D')
        @php
        $totalDespesa += $item->motante;
        @endphp
        @else
        @php
        $totalReceita += $item->motante;
        @endphp
        @endif

        @endforeach
        <tr>
            <td colspan="7" style="border: 1px solid #010101;padding: 2px;text-align: right;color: white;text-align: right;background-color: rgba(15, 121, 15, 0.5)">
                <strong>TOTAL RECEITAS</strong></td>
            <td colspan="1" style="border: 1px solid #010101;padding: 2px;text-align: right;color: white;text-align: right;background-color: rgba(15, 121, 15, 0.5)">
                <strong>{{ number_format($totalReceita, 2, ',', '.') }}</strong></td>
        </tr>
        <tr>
            <td colspan="7" style="border: 1px solid #010101;padding: 2px;text-align: right;color: white;text-align: right;background-color: rgba(214, 49, 19, 0.5)">
                <strong>TOTAL DESPESAS</strong></td>
            <td colspan="1" style="border: 1px solid #010101;padding: 2px;text-align: right;color: white;text-align: right;background-color: rgba(214, 49, 19, 0.5)">
                <strong>{{ number_format($totalDespesa, 2, ',', '.') }}</strong></td>
        </tr>
        @php $totalSaldo = $totalReceita - $totalDespesa ; @endphp
        <tr>
            <td colspan="7" style="border: 1px solid #010101;padding: 2px;text-align: right;color: white;text-align: right;background-color: #2c2c2c">
                <strong>SALDO FINAL</strong></td>
            <td colspan="1" style="border: 1px solid #010101;padding: 2px;text-align: right;color: white;text-align: right;background-color: #2c2c2c">
                <strong>{{ number_format($totalSaldo, 2, ',', '.') }}</strong></td>
        </tr>
    </tbody>

    <tfoot>
    </tfoot>
</table>

@endsection
