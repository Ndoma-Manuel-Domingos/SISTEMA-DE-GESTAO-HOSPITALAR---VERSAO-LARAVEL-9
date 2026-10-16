@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Fichas de Consulta por Preencher</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('consultorio.index') }}">{{ __('messages.voltar') }}</a></li>
                        <li class="breadcrumb-item active">Consultório</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <!-- /.row -->
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        @if ($consultas)
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table class="table table-hover text-nowrap" id="carregar_tabela" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Consulta Nº</th>
                                        <th>Atendimento</th>
                                        <th>Paciente</th>
                                        <th>Gênero</th>
                                        <th> {{ __('messages.data') }} - Hora</th>
                                        <th class="text-right">{{ __('messages.accoes') }} </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($consultas as $item)
                                    <tr>
                                        <td><a href="{{ route('consultas.show', $item->id) }}">{{ $item->id ?? "" }}</a></td>
                                        <td><a href="{{ route('atendimentos.show', $item->atendimento_id) }}">{{ $item->atendimento->numero ?? "" }}</a></td>
                                        <td><a href="{{ route('clientes.show', $item->paciente_id) }}">{{ $item->paciente->nome ?? "N/A" }}</a></td>
                                        <td><a href="{{ route('clientes.show', $item->paciente_id) }}">{{ $item->paciente->genero ?? "N/A" }}</a></td>
                                        <td>{{ $item->data_consulta->format("d/m/Y") }} {{ $item->hora_consulta }}</td>
                                        <td>
                                            @if (Auth::user()->can('consultorio'))
                                            <a class="btn btn-light-primary float-right" href="{{ route('consultorio.create', ['origem' => 'atendimento', 'atendimento_id' => $item->atendimento_id]) }}"><i class="fas fa-table text-light-primary"></i> Preencher a Ficha médica</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        @endif
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('scripts')
<script>
    $(function() {
        $("#carregar_tabela").DataTable({
            language: {
                url: ""
            }
            , "responsive": true
            , "lengthChange": false
            , "autoWidth": false
            , "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#carregarTabelaEstudantes_wrapper .col-md-6:eq(0)');
    });
</script>
@endsection
