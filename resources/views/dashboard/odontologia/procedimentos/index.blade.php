@extends('adminlte::page')

@section('title','Procedimentos Odontológicos')
@section('content_header')
<div class="d-flex justify-content-between">
    <h1>
        Procedimentos Odontológicos
    </h1>

    <a href="{{ route('odontologia.procedimentos.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i>
        Novo Procedimento
    </a>
</div>
@stop

@section('content')
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-header">
        <form method="GET">
            <div class="input-group">
                <input type="text" name="pesquisa" class="form-control" placeholder="Pesquisar procedimento..." value="{{ request('pesquisa') }}">
                <div class="input-group-append">
                    <button class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="card-body p-0">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>
                        Código
                    </th>
                    <th>
                        Nome
                    </th>
                    <th>
                        Duração
                    </th>
                    <th>
                        Valor
                    </th>
                    <th>
                        Status
                    </th>
                    <th width="160">
                        Ações
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($procedimentos as $procedimento)
                <tr>
                    <td>
                        <strong>
                            {{ $procedimento->codigo }}
                        </strong>
                    </td>
                    <td>
                        {{ $procedimento->nome }}
                    </td>
                    <td>
                        @if($procedimento->duracao)
                        {{ $procedimento->duracao }} min
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        @if($procedimento->valor)
                        {{ number_format($procedimento->valor,2,',','.') }}
                        @else
                        -
                        @endif
                    </td>
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
                    <td>
                        <a href="{{ route('odontologia.procedimentos.show',$procedimento) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('odontologia.procedimentos.edit',$procedimento) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('odontologia.procedimentos.destroy',$procedimento) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Deseja remover este procedimento?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">
                        Nenhum procedimento encontrado.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        {{ $procedimentos->links() }}
    </div>
</div>
@stop
