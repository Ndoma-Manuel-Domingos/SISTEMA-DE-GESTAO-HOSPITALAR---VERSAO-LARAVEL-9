@extends('adminlte::page')
@section('title','Detalhes do Procedimento')
@section('content_header')
<h1>
    Detalhes do Procedimento
</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="220">
                    Código
                </th>
                <td>
                    {{ $procedimento->codigo }}
                </td>
            </tr>
            <tr>
                <th>
                    Nome
                </th>
                <td>
                    {{ $procedimento->nome }}
                </td>
            </tr>
            <tr>
                <th>
                    Descrição
                </th>
                <td>
                    {{ $procedimento->descricao ?? 'Sem descrição' }}
                </td>
            </tr>
            <tr>
                <th>
                    Duração
                </th>
                <td>
                    @if($procedimento->duracao)
                    {{ $procedimento->duracao }} minutos
                    @else
                    Não informado
                    @endif
                </td>
            </tr>
            <tr>
                <th>
                    Valor
                </th>
                <td>
                    @if($procedimento->valor)
                    {{ number_format($procedimento->valor,2,',','.') }}
                    @else
                    Não informado
                    @endif
                </td>
            </tr>
            <tr>
                <th>
                    Estado
                </th>
                <td>
                    @if($procedimento->ativo)
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
            <tr>
                <th>
                    Criado em
                </th>
                <td>
                    {{ $procedimento->created_at->format('d/m/Y H:i') }}
                </td>
            </tr>
            <tr>
                <th>
                    Atualizado em
                </th>
                <td>
                    {{ $procedimento->updated_at->format('d/m/Y H:i') }}
                </td>
            </tr>
        </table>
    </div>
    <div class="card-footer">
        <a href="{{ route('odontologia.procedimentos.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Voltar
        </a>
    </div>
</div>
@stop
