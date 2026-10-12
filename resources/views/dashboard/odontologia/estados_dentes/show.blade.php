@extends('adminlte::page')

@section('title','Detalhes do Estado')

@section('content_header')
<h1>
    Detalhes do Estado
</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>
                    Nome
                </th>
                <td>
                    {{ $estado->nome }}
                </td>
            </tr>
            <tr>
                <th>
                    Cor
                </th>
                <td>
                    <div style="width:50px;height:30px;background:{{ $estado->cor }};">
                    </div>
                </td>
            </tr>
            <tr>
                <th>
                    Ícone
                </th>
                <td>
                    @if($estado->icone)
                    <i class="{{ $estado->icone }}"></i>
                    @endif
                </td>
            </tr>
            <tr>
                <th>
                    Descrição
                </th>
                <td>
                    {{ $estado->descricao }}
                </td>
            </tr>
            <tr>
                <th>
                    Status
                </th>
                <td>
                    @if($estado->ativo)
                    <span class="badge badge-success">
                        Ativo
                    </span>
                    @else
                    <span class="badge badge-danger">
                        Inativo
                    </span>
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>
@stop
