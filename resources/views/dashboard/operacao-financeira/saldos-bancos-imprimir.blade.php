@extends('layouts.layout-relatorio')

@section('content')
<table class="table">
    <thead>
        <tr>
            <th style="border: 1px solid #010101;padding: 2px;">Conta</th>
            <th style="border: 1px solid #010101;padding: 2px;"> {{ __('messages.designacao') }} </th>
            <th style="border: 1px solid #010101;padding: 2px;text-align: right">Credito</th>
            <th style="border: 1px solid #010101;padding: 2px;text-align: right">Debito</th>
            <th style="border: 1px solid #010101;padding: 2px;text-align: right">Saldo</th>
        </tr>
    </thead>
    @php
    $quantidades = 0;
    $quantidades_e = 0;
    $quantidades_s = 0;

    $saldos = 0;
    $saldos_e = 0;
    $saldos_s = 0;
    @endphp

    <tbody>

        @php
        $cred = 0;
        $debi = 0;
        @endphp

        @foreach ($saldos_bancos as $item)
        @php
        $cred += $item->despesa;
        $debi += $item->receita;
        @endphp
        <tr>
            <td>{{ $item->subconta->numero }}</td>
            <td>{{ $item->subconta->nome }}</td>
            <td style="text-align: right">- {{ number_format($item->despesa, 2, ',', '.') }}</td>
            <td style="text-align: right">+ {{ number_format($item->receita, 2, ',', '.') }}</td>
            <td style="text-align: right">{{ number_format($item->receita - $item->despesa, 2, ',', '.') }}</td>
        </tr>
        @endforeach
    <tfoot>
        <tr>
            <th style="text-align: right;">-</th>
            <th style="text-align: right;">-</th>
            <th style="text-align: right;">-{{ number_format($cred, 2, ',', '.') }}</th>
            <th style="text-align: right;">+{{ number_format($debi, 2, ',', '.') }}</th>
            <th style="text-align: right;">{{ number_format($debi - $cred, 2, ',', '.') }}</th>
        </tr>
    </tfoot>
    </tbody>
</table>
@endsection
