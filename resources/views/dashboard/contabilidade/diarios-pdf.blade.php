@extends('layouts.layout-relatorio')
@section('content')
<table class="table">
    <thead>
        <tr>
            <th colspan="9" style="text-transform: uppercase"> {{ $titulo }} <span style="float: right">Data: {{ date('Y-m-d') }}</span></th>
        </tr>
    </thead>
</table>

<table class="table">

    @if (!($empresa_logada->empresa->exibicao_relatorio == 'sintetico'))
    <thead>
        <tr>
            <th style="border: 1px solid #010101;padding: 2px;text-align: right">#</th>
            <th style="border: 1px solid #010101;padding: 2px;text-align: right">Nº de Registo</th>
            <th style="border: 1px solid #010101;padding: 2px;text-align: right"> {{ __('messages.descricao') }} </th>
            <th style="border: 1px solid #010101;padding: 2px;text-align: right"> {{ __('messages.data') }} </th>
            <th style="border: 1px solid #010101;padding: 2px;text-align: right">Forma Pagamento</th>
            <th style="border: 1px solid #010101;padding: 2px;text-align: right"> {{ __('messages.clientes') }} </th>
            <th style="border: 1px solid #010101;padding: 2px;text-align: right">Operador</th>
            <th style="border: 1px solid #010101;padding: 2px;text-align: right">Caixa</th>
            <th style="border: 1px solid #010101;padding: 2px;text-align: right">{{ __('messages.total') }}</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($resultadoUnificado as $contador => $item)
        <tr>
            <td style="padding: 3px;text-align: left">{{ $contador + 1 }}</td>
            <td style="padding: 3px;text-align: left">{{ $item->id ?? "" }}</td>
            <td style="padding: 3px;text-align: left">{{ $item->factura_next ?? ""  }}</td>
            <td style="padding: 3px;text-align: left">{{ date('Y-m-d', strtotime($item->created_at)) }} ÁS {{ date('H:i:s', strtotime($item->created_at)) }}</td>
            <td style="padding: 3px;text-align: left">{{ $item->forma_pagamento($item->pagamento) }}</td>
            <td style="padding: 3px;text-align: left">{{ $item->cliente->nome ?? ""  }}</td>
            <td style="padding: 3px;text-align: left">{{ $item->user->name ?? '' }}</td>
            <td style="padding: 3px;text-align: left">{{ $item->caixa->nome ?? '' }}</td>
            <td style="padding: 3px;text-align: right">{{ number_format($item->valor_total ?? 0, 2, ',', '.') }}
            </td>
        </tr>
        @endforeach
    </tbody>
    @endif

    <tfoot>
        <tr>
            <th colspan="5" style="border: 1px solid #010101;padding: 2px;text-transform: uppercase;text-align: left">ENTRADA </th>
            <th colspan="4" style="border: 1px solid #010101;padding: 2px;text-align: right"> {{ number_format($total_vendido_valor ?? 0, 2, ',', '.') }} </th>
        </tr>
        <tr>
            <th colspan="5" style="border: 1px solid #010101;padding: 2px;text-transform: uppercase;text-align: left">TOTAL
                FACTURAÇÃO NUMERÁRIO</th>
            <th colspan="4" style="border: 1px solid #010101;padding: 2px;text-align: right">
                {{ number_format($total_arrecadado_cash ?? 0, 2, ',', '.') }} </th>
        </tr>
        <tr>
            <th colspan="5" style="border: 1px solid #010101;padding: 2px;text-transform: uppercase;text-align: left">TOTAL
                FACTURAÇÃO TPA</th>
            <th colspan="4" style="border: 1px solid #010101;padding: 2px;text-align: right">
                {{ number_format($total_arrecadado_multicaixa ?? 0, 2, ',', '.') }} </th>
        </tr>
        <tr>
            <th colspan="5" style="border: 1px solid #010101;padding: 2px;text-transform: uppercase;text-align: left">TOTAL
                FACTURAÇÃO DUPLO</th>
            <th colspan="4" style="border: 1px solid #010101;padding: 2px;text-align: right">
                {{ number_format($total_duplo ?? 0, 2, ',', '.') }} </th>
        </tr>
        <tr>
            <th colspan="5" style="border: 1px solid #010101;padding: 2px;text-transform: uppercase;text-align: left">SALDO</th>
            <th colspan="4" style="border: 1px solid #010101;padding: 2px;text-align: right">
                {{ number_format($total_vendido_valor ?? 0, 2, ',', '.') }} </th>
        </tr>
    </tfoot>
</table>

<table class="table">
    <thead>
        <tr>
            <th colspan="9" style="text-transform: uppercase;border-bottom: 1px solid #000;padding: 10px 20px;">
                Impressor por:
            </th>
        </tr>
        <tr>
            <th style="text-transform: uppercase;padding: 10px 0;padding: 10px 20px;"> {{ Auth::user()->name }} </th>
        </tr>
    </thead>
</table>
@endsection
