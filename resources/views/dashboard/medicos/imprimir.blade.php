@extends('layouts.layout-relatorio')

@section('content')

<table class="table">
    <thead>
        <tr>
            <th colspan="2" style="text-transform: uppercase"> {{ $titulo }}</th>
        </tr>
        <tr>
            <th colspan="2" style="text-transform: uppercase">NOME: {{ $pagamento->medico->my_user->name ?? 'N/A' }}</th>
        </tr>
        <tr>
            <th style="text-transform: uppercase">REFERÊNCIA: {{ $pagamento->numero }}</th>
            <th style="text-transform: uppercase;text-align: right">DATA: {{ $pagamento->created_at?->format('d/m/Y \à\s H:i:s') }}</th>
        </tr>
    </thead>
</table>

<table class="table">
    <thead>
        <tr>
            <th style="text-align: left">Médico</th>
            <th style="text-align: left">Forma Pagamento</th>
            <th style="text-align: left">Referência</th>
            <th style="text-align: left">Observação</th>
            <th style="text-align: left">Operador</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: left">{{ $pagamento->medico->nome ?? 'N/A' }}</td>
            <td style="text-align: left">{{ $pagamento->forma_pagamento->titulo ?? 'N/A' }}</td>
            <td style="text-align: left">{{ $pagamento->referencia ?? 'N/A' }}</td>
            <td style="text-align: left">{{ $pagamento->observacao ?? 'N/A' }}</td>
            <td style="text-align: left">{{ $pagamento->user->name ?? 'N/A' }}</td>
        </tr>
    </tbody>
</table>

<table class="table">
    <thead>
        <tr>
            <th colspan="5">Comissões</th>
        </tr>
        <tr>
            <th style="text-align: left">Nº</th>
            <th style="text-align: left">Serviço</th>
            <th style="text-align: left">Categoria</th>
            <th style="text-align: left">Paciente</th>
            <th style="text-align: left">Volar</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pagamento->items as $item)
        <tr>
            <td style="text-align: left">{{ $item->comissao->nome ?? 'N/A' }}</td>
            <td style="text-align: left">{{ $item->comissao->servico->nome ?? 'N/A' }}</td>
            <td style="text-align: left">{{ $item->comissao->servico->categoria->categoria ?? 'N/A' }}</td>
            <td style="text-align: left">{{ $item->comissao->cliente->nome ?? 'N/A' }}</td>
            <td style="text-align: right">{{ number_format($item->valor ?? 0, 2, ',', '.')  }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<table class="table">
    <thead>
        <tr>
            <th style="text-align: right">{{ __('messages.total') }}</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: right">{{ number_format($pagamento->total ?? 0, 2, ',', '.') }}</td>
        </tr>
    </tbody>
</table>
@endsection
