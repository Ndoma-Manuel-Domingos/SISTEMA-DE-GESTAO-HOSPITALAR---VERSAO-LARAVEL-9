@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('messages.mais_detalhes') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard-principal') }}">{{ __('messages.voltar') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.controle') }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-12 col-md-9">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-4">
                                <table class="table text-nowrap">
                                    <tbody>
                                        <tr>
                                            <th>{{ __('messages.conta') }}</th>
                                            <td class="text-right">{{ $agente->conta ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('messages.designacao') }}</th>
                                            <td class="text-right">{{ $agente->nome ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('messages.email') }}</th>
                                            <td class="text-right">{{ $agente->email ?? 'N/A' }}</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                            <div class="col-12 col-md-6 col-lg-4">
                                <table class="table text-nowrap">
                                    <tbody>
                                        <tr>
                                            <th>Cadastrado por</th>
                                            <td class="text-right">{{ $agente->pertence->nome ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('messages.estado_civil') }}</th>
                                            <td class="text-right">{{ $agente->estado->nome ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th> {{ __('messages.bilhete_identidade') }} </th>
                                            <td class="text-right">{{ $agente->nif ?? 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-12 col-md-6 col-lg-4">
                                <table class="table text-nowrap">
                                    <tbody>
                                        <tr>
                                            <th>Morada</th>
                                            <td class="text-right">{{ $agente->localidade ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Estado</th>
                                            <td class="text-right">{{ $agente->estado ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('messages.telefone') }}</th>
                                            <td class="text-right">{{ $agente->telefone ?? 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">

                        <a href="{{ route('agentes.edit', $agente->id) }}" class="btn btn-light-primary mr-2">
                            <i class="fas fa-edit"></i> Editar
                        </a>

                        @if ($agente->estado != "activo")
                        <button class="btn btn-light-success mr-2 btn-status" data-id="{{ $agente->id }}" data-status="activo">
                            <i class="fas fa-check-circle"></i> Ativar
                        </button>
                        @endif
                        @if ($agente->estado != "desactivo")
                        <button class="btn btn-light-danger mr-2 btn-status" data-id="{{ $agente->id }}" data-status="desactivo">
                            <i class="fas fa-times-circle"></i> Desativar
                        </button>
                        @endif
                        @if ($agente->estado != "suspenso")
                        <button class="btn btn-light-warning btn-status" data-id="{{ $agente->id }}" data-status="suspenso">
                            <i class="fas fa-pause-circle"></i> Suspender
                        </button>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="card">
                    <div class="card-body {{ $agente->saldo > 0 ? 'bg-light-success' : 'bg-light-danger' }}">
                        <h3>Saldo Disponível Acumulado</h3>
                        <h2>{{ number_format($agente->saldo ?? 0, 2, ",", '.') }} AOA</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Listagem das comissões</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th width="40"></th>
                                    <th>Código</th>
                                    <th>Paciente</th>
                                    <th>Data</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($agente->atendimentos as $atendimento)
                                <tr class="linha-atendimento" data-id="{{ $atendimento->id }}" style="cursor:pointer">
                                    <td class="text-center">
                                        <i class="fas fa-chevron-right seta"></i>
                                    </td>
                                    <td>{{ $atendimento->numero }}</td>
                                    <td>{{ $atendimento->paciente->nome ?? "N/A" }}</td>
                                    <td>{{ $atendimento->data_at }}</td>
                                </tr>
                                <tr class="linha-detalhes" id="detalhes-{{ $atendimento->id }}">
                                    <td colspan="4" class="p-0 border-0">
                                        <div class="detalhes">
                                            @foreach($atendimento->contaHospitalar->itens as $item)
                                            <div class="item-servico">
                                                <div class="servico">
                                                    <i class="fas fa-angle-right text-primary"></i>
                                                    {{ $item->servico->nome }}
                                                </div>
                                                <div class="qtd">
                                                    {{ $item->quantidade }}
                                                </div>
                                                <div class="valor">
                                                    {{ number_format($item->comissao_acumulada,2,',','.') }} Kz
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Listagem dos pagamentos das comissões</h5>
                    </div>
                    <div class="card-body table-responsive">


                        <table class="table table-hover text-nowrap" id="carregar_tabela" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Nº</th>
                                    <th>Data</th>
                                    <th>Forma Pagamento</th>
                                    <th>Referência</th>
                                    <th>Observação</th>
                                    <th>Total</th>
                                    <th class="text-right">{{ __('messages.accoes') }} </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($agente->pagamentos as $item)
                                <tr>
                                    <td>{{ $item->numero ?? "N/A" }}</td>
                                    <td>{{ $item->created_at?->format('d/m/Y \à\s H:i:s') ?? 'N/A' }}</td>
                                    <td>{{ $item->forma_pagamento->titulo ?? "N/A" }}</td>
                                    <td>{{ $item->referencia ?? "N/A" }}</td>
                                    <td>{{ $item->observacao ?? "N/A" }}</td>
                                    <td>{{ number_format($item->total ?? 0, 2, ",", ".") }}</td>
                                    <td class="text-right">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-light-primary">{{ __('messages.accoes') }} </button>
                                            <button type="button" class="btn btn-light-primary dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <a class="dropdown-item" target="_blink" href="{{ route('comissoes.imprimir', $item->id) }}"><i class="fas fa-print text-light-primary"></i> {{ __('messages.imprimir') }} </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection

@section('scripts')
<script>
    $('.linha-atendimento').click(function() {
        let id = $(this).data('id');
        $('#detalhes-' + id)
            .stop(true, true)
            .fadeToggle(100)
            .find('.detalhes')
            .hide()
            .slideToggle(200);

        $(this).find('.seta').toggleClass('ativo');

    });

    $('.btn-status').click(function() {
        let id = $(this).data('id');
        let status = $(this).data('status');
        Swal.fire({
            title: 'Confirmar'
            , text: 'Deseja realmente ' + status + ' este agente?'
            , icon: 'question'
            , showCancelButton: true
            , confirmButtonColor: '#3085d6'
            , cancelButtonColor: '#d33'
            , confirmButtonText: 'Sim'
            , cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/agentes/' + id + '/status'
                    , type: 'POST'
                    , data: {
                        status: status
                        , _token: $('meta[name="csrf-token"]').attr('content')
                    }
                    , success: function(res) {
                        Swal.fire({
                            icon: 'success'
                            , title: 'Sucesso'
                            , text: res.message
                            , timer: 1500
                            , showConfirmButton: false
                        });
                        location.reload();
                    }
                    , error: function() {
                        Swal.fire(
                            'Erro'
                            , 'Não foi possível alterar o estado.'
                            , 'error'
                        );
                    }
                });
            }
        });
    });

</script>
@endsection
