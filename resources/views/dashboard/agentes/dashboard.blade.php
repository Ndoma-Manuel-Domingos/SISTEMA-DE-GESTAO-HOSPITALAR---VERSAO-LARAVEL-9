@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard agentes</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard-hospital') }}">{{ __('messages.voltar') }}</a></li>
                        <li class="breadcrumb-item active">Agentes</li>
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
                            <h3 class="card-title">Pesquisas</h3>
                        </div>
                        <div class="card-body">
                            <form method="GET" class="row">

                                <div class="col-md-3 col-12">
                                    <label>Data Inicial</label>
                                    <input type="date" class="form-control" name="inicio" value="{{ $inicio->format('Y-m-d') }}">
                                </div>
                                <div class="col-md-3 col-12">
                                    <label>Data Final</label>
                                    <input type="date" class="form-control" name="fim" value="{{ $fim->format('Y-m-d') }}">
                                </div>
                                <!-- BOTÃO -->
                                <div class="col-md-3 d-flex align-items-end">
                                    <button class="btn btn-primary btn-block">
                                        <i class="fas fa-search"></i>
                                        Filtrar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 col-12">
                    <a href="{{ route('agentes.index') }}" class="text-decoration-none">
                        <div class="small-box bg-light-primary">
                            <div class="inner">
                                <h3>{{ number_format($totalAgentes) }} </h3>
                                <p>Total Agentes</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-tie"></i>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3 col-12">
                    <a href="{{ route('agentes.index') }}" class="text-decoration-none">
                        <div class="small-box bg-light-success">
                            <div class="inner">
                                <h3>{{ number_format($agentesAtivos) }} </h3>
                                <p>Agentes Ativos</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-check"></i>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3 col-12">
                    <a href="{{ route('clientes.index') }}" class="text-decoration-none">
                        <div class="small-box bg-light-warning">
                            <div class="inner">
                                <h3> {{ number_format($pacientes) }}</h3>
                                <p>Pacientes Indicados</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-injured"></i>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3 col-12">
                    <a href="{{ route('agentes.index') }}" class="text-decoration-none">
                        <div class="small-box bg-light-danger">
                            <div class="inner">
                                <h3>{{ number_format($receita,2,',','.') }}</h3>
                                <p>Receita Gerada</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-12">
                    <a href="{{ route('lista.comissoes-agentes') }}" class="text-decoration-none">
                        <div class="small-box bg-light-primary">
                            <div class="inner">
                                <h3>{{ number_format($comissaoPendente,2,',','.') }}</h3>
                                <p>Comissões Pendentes</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6 col-12">
                    <a href="{{ route('lista.pagamentos-agentes') }}" class="text-decoration-none">
                        <div class="small-box bg-light-success">
                            <div class="inner">
                                <h3>{{ number_format($comissaoPaga,2,',','.') }} </h3>
                                <p>Comissões Pagas</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            Top Agentes por Pacientes
                        </div>
                        <div class="card-body">
                            <canvas id="graficoPacientes"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            Top Agentes por Comissão
                        </div>
                        <div class="card-body">
                            <canvas id="graficoComissao"></canvas>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Agentes sem movimento</strong>
                        </div>

                        <div class="card-body table-responsive">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Agente</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($agentesSemMovimento as $agente)
                                    <tr>
                                        <td>{{ $agente->nome ?? "N/A" }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td class="text-center">
                                            Todos os agentes tiveram movimento.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- agente supervisor, controle de agentes, agente operador, listar disponibilidade medica, criar disponibilidade medica --}}

            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            Evolução das Comissões
                        </div>
                        <div class="card-body">
                            <canvas id="graficoEvolucao"></canvas>
                        </div>
                    </div>
                </div>
            </div>


        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@php
$nomePaciente = $topAgentesPacientes->pluck('agente.nome');
$dadosPaciente = $topAgentesPacientes->pluck('total');

$nomeComissao = $topAgentesComissao->pluck('agente.nome');
$dadosComissao = $topAgentesComissao->pluck('total');

$evolucaoComissaoMes = $evolucaoComissao->pluck('mes');
$evolucaoComissaoTotal = $evolucaoComissao->pluck('total');
@endphp

@endsection

@section('scripts')
<script>
    const ctxPacientes = document.getElementById('graficoPacientes');

    new Chart(ctxPacientes, {
        type: 'bar'
        , data: {
            labels: @json($nomePaciente)
            , datasets: [{
                label: 'Pacientes'
                , data: @json($dadosPaciente)
                , backgroundColor: [
                    '#36A2EB'
                    , '#4BC0C0'
                    , '#FF6384'
                    , '#FF9F40'
                    , '#9966FF'
                    , '#2ECC71'
                    , '#F1C40F'
                ]
            }]
        }
    });

    const ctxComissao = document.getElementById('graficoComissao');

    new Chart(ctxComissao, {
        type: 'bar'
        , data: {
            labels: @json($nomeComissao)
            , datasets: [{
                label: 'Comissão'
                , data: @json($dadosComissao)
                , backgroundColor: [
                    '#36A2EB'
                    , '#4BC0C0'
                    , '#FF6384'
                    , '#FF9F40'
                    , '#9966FF'
                    , '#2ECC71'
                    , '#F1C40F'
                ]
            }]
        }
    });


    const ctxEvolucao = document.getElementById('graficoEvolucao');

    new Chart(ctxEvolucao, {
        type: 'line'
        , data: {
            labels: @json($evolucaoComissaoMes)
            , datasets: [{
                label: 'Comissões'
                , data: @json($evolucaoComissaoTotal)
                , borderColor: [
                    '#36A2EB'
                    , '#4BC0C0'
                    , '#FF6384'
                    , '#FF9F40'
                    , '#9966FF'
                    , '#2ECC71'
                    , '#F1C40F'
                ]
                , fill: false
            }]
        }
    });

</script>
@endsection
