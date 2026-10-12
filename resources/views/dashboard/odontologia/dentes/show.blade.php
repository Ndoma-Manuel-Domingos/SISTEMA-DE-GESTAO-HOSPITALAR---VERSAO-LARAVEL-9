@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detalhes</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard-principal') }}">{{ __('messages.inicio') }}</a></li>
                        <li class="breadcrumb-item active">Detalhes</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            Informações
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="200">ID</th>
                                    <td>{{ $dente->id }}</td>
                                </tr>
                                <tr>
                                    <th>Nome</th>
                                    <td>{{ $dente->nome }}</td>
                                </tr>
                                <tr>
                                    <th>Idade Inicial</th>
                                    <td>{{ $dente->tipoDenticao->idade_inicial }}</td>
                                </tr>
                                <tr>
                                    <th>Idade Final</th>
                                    <td>{{ $dente->tipoDenticao->idade_final }}</td>
                                </tr>
                                <tr>
                                    <th>Descrição</th>
                                    <td>{{ $dente->descricao }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($dente->ativo)
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
                                    <th>Criado em</th>
                                    <td>{{ $dente->created_at?->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Atualizado em</th>
                                    <td>{{ $dente->updated_at?->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="card-footer">
                            <a href="{{ route('odontologia.dentes.index') }}" class="btn btn-secondary">
                                Voltar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection
