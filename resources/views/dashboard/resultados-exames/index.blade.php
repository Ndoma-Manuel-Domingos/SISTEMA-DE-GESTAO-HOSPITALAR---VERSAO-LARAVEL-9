@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Resultados de exames</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard-hospital') }}">Home</a></li>
                        <li class="breadcrumb-item active">Todos</li>
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
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Pesquisar resultados</h3>
                        </div>
                        <div class="card-body">
                            <form method="GET" class="row" action="{{ route('resultados-exames.index') }}">
                                <!-- SEARCH GLOBAL -->
                                <div class="col-12 col-md-3">
                                    <label for="paciente_id" class="form-label">Pacientes</label>
                                    <select name="paciente_id" id="paciente_id" class="form-control select2">
                                        <option value="">{{ __('messages.todos') }} </option>
                                        @foreach ($pacientes as $item)
                                        <option value="{{ $item->id ?? "" }}" {{ $requests['paciente_id'] == $item->id ? "selected" : "" }}>{{ $item->nome ?? "N/A" }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- STATUS -->
                                <div class="col-12 col-md-3">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">Todos</option>
                                        <option value="concluido" {{ $requests['status'] == "concluido" ? "selected" : "" }}>CONCLUÍDO</option>
                                        <option value="processo" {{ $requests['status'] == "processo" ? "selected" : "" }}>EM PROCESSO</option>
                                    </select>
                                </div>

                                <div class="col-12 col-md-3">
                                    <label for="data_inicio">Data</label>
                                    <input type="date" name="data_inicio" id="data_inicio" value="{{ $requests['data_inicio'] ?? "" }}" class="form-control">
                                </div>

                                <!-- BOTÃO -->
                                <div class="col-md-3 d-flex align-items-end">
                                    <button class="btn btn-primary btn-block">
                                        <i class="fas fa-search"></i>
                                        Pesquisar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-tools">
                                <a class="btn btn-light-danger" target="_blank" href="{{ route('resultados-exames.imprimir-all', [
                                        'paciente_id' => $requests['paciente_id'],
                                        'status' => $requests['status'],
                                    ]) }}"><i class="fas fa-file-pdf"></i> PDF
                                </a>
                            </div>
                        </div>

                        @if ($resultados)
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table class="table table-hover text-nowrap" id="carregar_tabela" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Titulo</th>
                                        <th>Paciente</th>
                                        <th>{{ __('messages.genero') }}</th>
                                        <th>{{ __('messages.idade') }}</th>
                                        <th>{{ __('messages.estados') }}</th>
                                        <th>Data</th>
                                        <th>Hora</th>
                                        <th class="text-right">{{ __('messages.accoes') }} </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($resultados as $item)
                                    <tr>
                                        <td>{{ $item->id ?? "N/A" }}</td>
                                        <td><a href="{{ route('exames.show', $item->exame_id) }}">{{ $item->referencia ?? "N/A" }}</a></td>
                                        <td>{{ $item->exame->paciente->nome ?? "N/A" }}</td>
                                        <td>{{ $item->exame->paciente->genero ?? "não definido" }}</td>
                                        <td>{{ $item->exame->paciente->idade($item->exame->paciente->data_nascimento) }} Anos</td>

                                        @if ($item->status == 'processo')
                                        <td>
                                            <span class="badge" style="background-color: #FFF3CD;">{{ $item->status ?? "N/A" }}</span>
                                        </td>
                                        @endif
                                        @if ($item->status == 'concluido')
                                        <td>
                                            <span class="badge" style="background-color: #D4EDDA;">{{ $item->status ?? "N/A" }}</span>
                                        </td>
                                        @endif

                                        <td>{{ $item->data_realizacao ?? "N/A" }}</td>
                                        <td>{{ $item->hora_realizacao ?? "N/A" }}</td>

                                        <td class="text-right">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-light-primary">{{ __('messages.opcoes') }}</button>
                                                <button type="button" class="btn btn-light-primary dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    @if (Auth::user()->can('listar todos') || Auth::user()->can('listar tratamento'))
                                                    <a href="{{ route('exames.show', $item->exame_id) }}" class="dropdown-item text-light-primary"><i class="fas fa-info"></i> {{ __('messages.mais_detalhes') }} </a>
                                                    <a href="{{ route('exames-imprimir', $item->exame_id) }}" target="_blink" class="dropdown-item text-light-primary"><i class="fas fa-file-pdf"></i> {{ __('messages.imprimir') }} </a>
                                                    @endif
                                                </div>
                                            </div>
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
