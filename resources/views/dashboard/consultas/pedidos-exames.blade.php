@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pedidos de Exames</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('consultorio.index') }}">{{ __('messages.voltar') }}</a></li>
                        <li class="breadcrumb-item active">Pedidos</li>
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
                            <h1 class="h5">Listagem dos pedidos de exames e outros</h1>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-hover text-nowrap" id="carregar_tabela" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Número</th>
                                        <th>Paciente</th>
                                        <th>Prioridade</th>
                                        <th>Cor</th>
                                        <th>{{ __('messages.estados') }}</th>
                                        <th class="text-right">{{ __('messages.accoes') }} </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($solicitacoes as $item)
                                    <tr>
                                        <td>{{ $item->id ?? "" }}</td>
                                        <td>{{ $item->solicitacao ?? "N/A" }}</td>
                                        <td><a href="{{ route('clientes.show', $item->paciente->id) }}">{{ $item->paciente->nome ?? "N/A" }}</a></td>
                                        <td>{{ $item->prioridade->nome ?? "N/A" }}</td>
                                        <td>{{ $item->prioridade->tipo_cor($item->prioridade->cor) }}</td>

                                        @if ($item->status == 'pendente')
                                        <td><span class="badge" style="background-color: #FFF3CD;">{{ $item->status ?? "N/A" }}</span>
                                        </td>
                                        @endif

                                        @if ($item->status == 'em_analise')
                                        <td><span class="badge" style="background-color: #B8DAFF;">{{ $item->status ?? "N/A" }}</span>
                                        </td>
                                        @endif

                                        @if ($item->status == 'agendado')
                                        <td><span class="badge" style="background-color: #D4EDDA;">{{ $item->status ?? "N/A" }}</span>
                                        </td>
                                        @endif

                                        @if ($item->status == 'executado')
                                        <td><span class="badge" style="background-color: #D4EDDA;">{{ $item->status ?? "N/A" }}</span>
                                        </td>
                                        @endif

                                        @if ($item->status == 'cancelado')
                                        <td>
                                            <span class="badge" style="background-color: #F8D7DA;">{{ $item->status ?? "N/A" }}</span>
                                        </td>
                                        @endif
                                        <td class="text-right">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-light-primary">{{ __('messages.opcoes') }}</button>
                                                <button type="button" class="btn btn-light-primary dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    @if (Auth::user()->can('editar todos') || Auth::user()->can('consultorio'))
                                                    <a href="{{ route('pdf.solicitacoes-medicas-individual', $item->id) }}" class="dropdown-item text-light-primary"><i class="fas fa-table"></i> Imprimir</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>

            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
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
