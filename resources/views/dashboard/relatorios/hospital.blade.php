@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Relatórios Hospitalares</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard-hospital') }}">{{ __('messages.voltar') }}</a></li>
                        <li class="breadcrumb-item active">Relatórios</li>
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
                        <div class="card-body">
                            <form id="filtro-form" class="row align-items-end">
                                <div class="col-md-3" col-12>
                                    <label for="inicio">Data inicial</label>
                                    <input type="date" id="inicio" class="form-control" value="{{ now()->toDateString() }}">
                                </div>

                                <div class="col-md-3" col-12>
                                    <label for="fim">Data final</label>
                                    <input type="date" id="fim" class="form-control" value="{{ now()->toDateString() }}">
                                </div>

                                <div class="col-md-3 col-12">
                                    <label for="categoria_id">Categoria</label>
                                    <select id="categoria_id" class="form-control">
                                        <option value="">Todas as categorias</option>
                                        @foreach($categorias as $categoria)
                                            <option value="{{ $categoria->id }}">
                                                {{ $categoria->categoria }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3" col-12>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-filter"></i> Filtrar
                                    </button>

                                    <button type="button" id="hoje" class="btn btn-outline-secondary">
                                        Hoje
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="erro" class="alert alert-danger d-none"></div>
            <div class="row">
                <div class="col-md-6">
                    <div class="small-box bg-light-primary">
                        <div class="inner">
                            <h3 id="total-vendas">0</h3>
                            <p>Serviços prestados</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-stethoscope"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="small-box bg-light-success">
                        <div class="inner">
                            <h3 id="faturacao">0 Kz</h3>
                            <p>Faturação no período</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-bar mr-1"></i>
                                Serviços mais prestados
                            </h3>
                        </div>
                        <div class="card-body">
                            <canvas id="grafico-produtos"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Vendas por categoria</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="grafico-categorias"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Evolução diária</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="grafico-evolucao"></canvas>
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
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    $(function() {
        let graficoProdutos = null;
        let graficoCategorias = null;
        let graficoEvolucao = null;

        const formatarKz = valor =>
            Number(valor || 0).toLocaleString('pt-PT', {
                minimumFractionDigits: 2
                , maximumFractionDigits: 2
            }) + ' Kz';

        async function carregarDados() {
            const erro = $('#erro');
            erro.addClass('d-none').text('');

            const inicio = $('#inicio').val();
            const fim = $('#fim').val();
            const categoriaId = $('#categoria_id').val();

            if (!inicio || !fim || inicio > fim) {
                erro.removeClass('d-none').text('Seleciona um intervalo de datas válido.');
                return;
            }

            try {
                const resposta = await $.get(
                    @json(route('relatorios.hospital.dados')), { inicio: inicio, fim: fim, categoria_id: categoriaId}
                );

                $('#total-vendas').text(resposta.total_vendas);
                $('#faturacao').text(formatarKz(resposta.faturacao));

                if (graficoProdutos) graficoProdutos.destroy();
                if (graficoCategorias) graficoCategorias.destroy();
                if (graficoEvolucao) graficoEvolucao.destroy();

                graficoProdutos = new Chart(
                    document.getElementById('grafico-produtos'), {
                        type: 'bar'
                        , data: {
                            labels: resposta.produtos.map(p => p.nome)
                            , datasets: [{
                                label: 'Total de serviços'
                                , data: resposta.produtos.map(p => Number(p.quantidade))
                                , backgroundColor: '#17a2b8'
                            }]
                        }
                        , options: {
                            responsive: true
                            , maintainAspectRatio: false
                            , indexAxis: 'y'
                            , scales: {
                                x: {
                                    beginAtZero: true
                                }
                            }
                        }
                    }
                );

                graficoCategorias = new Chart(
                    document.getElementById('grafico-categorias'), {
                        type: 'doughnut'
                        , data: {
                            labels: resposta.categorias.map(c => c.categoria)
                            , datasets: [{
                                label: 'Quantidade'
                                , data: resposta.categorias.map(c => Number(c.quantidade))
                            }]
                        }
                        , options: {
                            responsive: true
                            , maintainAspectRatio: false
                        }
                    }
                );

                graficoEvolucao = new Chart(
                    document.getElementById('grafico-evolucao'), {
                        type: 'line'
                        , data: {
                            labels: resposta.evolucao.map(e => e.dia)
                            , datasets: [{
                                label: 'Serviços prestados'
                                , data: resposta.evolucao.map(e => Number(e.quantidade))
                                , borderColor: '#007bff'
                                , backgroundColor: 'rgba(0,123,255,0.15)'
                                , fill: true
                                , tension: 0.25
                            }]
                        }
                        , options: {
                            responsive: true
                            , maintainAspectRatio: false
                            , scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    }
                );
            } catch (error) {
                erro.removeClass('d-none').text(
                    error.responseJSON?.message ||
                    'Não foi possível carregar os relatórios.'
                );
            }
        }

        $('#filtro-form').on('submit', function(e) {
            e.preventDefault();
            carregarDados();
        });

        $('#hoje').on('click', function() {
            const hoje = new Date();
            const data = [
                hoje.getFullYear()
                , String(hoje.getMonth() + 1).padStart(2, '0')
                , String(hoje.getDate()).padStart(2, '0')
            ].join('-');

            $('#inicio').val(data);
            $('#fim').val(data);
            carregarDados();
        });

        carregarDados();
    });

</script>
@endsection
