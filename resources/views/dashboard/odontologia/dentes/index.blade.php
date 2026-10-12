@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dentes</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard-principal') }}">{{ __('messages.inicio') }}</a></li>
                        <li class="breadcrumb-item active">Dentes</li>
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
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                </div>

                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <form>
                                <div class="input-group">
                                    <input type="text" name="pesquisa" class="form-control" placeholder="Pesquisar..." value="{{ request('pesquisa') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <a href="{{ route('odontologia.dentes.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                                Novo Dente
                            </a>
                        </div>

                        <div class="card-body p-0">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Nome</th>
                                        <th>Quadrante</th>
                                        <th>Aracada</th>
                                        <th>Lado</th>
                                        <th>Status</th>
                                        <th width="180">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($dentes as $dente)
                                    <tr>
                                        <td>{{ $dente->codigo_fdi }}</td>
                                        <td>{{ $dente->nome ?? 'N/A' }}</td>
                                        <td>{{ $dente->quadrante ?? 'N/A' }}</td>
                                        <td>{{ $dente->arcada ?? 'N/A' }}</td>
                                        <td>{{ $dente->lado ?? 'N/A' }}</td>
                                        <td>{{ $dente->tipoDenticao->nome ?? 'N/A' }}</td>
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
                                        <td>
                                            <a href="{{ route('odontologia.dentes.show',$dente) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('odontologia.dentes.edit',$dente) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('odontologia.dentes.destroy',$dente) }}" method="POST" style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return confirm('Deseja excluir?')" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            Nenhum registro encontrado.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            {{ $dentes->links() }}
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
