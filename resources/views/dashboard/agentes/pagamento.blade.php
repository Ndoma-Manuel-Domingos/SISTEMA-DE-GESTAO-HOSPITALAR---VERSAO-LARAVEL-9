@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pagamento de comissões aos Agentes</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard-hospital') }}">{{ __('messages.voltar') }}</a></li>
                        <li class="breadcrumb-item active">Comissões</li>
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
                <div class="col-md-3">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                Selecione o Agente
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <label>Agente</label>
                                    <select class="form-control select2" id="agente_id">
                                        <option value="">Selecione...</option>
                                        @foreach($agentes as $agent)
                                        <option value="{{ $agent->id }}">
                                            {{ $agent->nome }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer"></div>
                    </div>
                </div>

                <div class="col-12 col-md-9">
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="small-box bg-light-primary">
                                <div class="inner">
                                    <h3 id="clients">0</h3>
                                    <p>Clientes</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="small-box bg-light-success">
                                <div class="inner">
                                    <h3 id="totalCommission">
                                        0,00 Kz
                                    </h3>
                                    <p>Total Comissão</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-money-bill"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="small-box bg-light-warning">
                                <div class="inner">
                                    <h3 id="paymentAmount">
                                        0,00 Kz
                                    </h3>
                                    <p>Valor a Pagar</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-wallet"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Comissões Pendentes
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-hover" id="tableCommissions">
                                        <thead>
                                            <tr>
                                                <th width="40">#</th>
                                                <th>Paciente</th>
                                                <th>Serviço</th>
                                                <th>Valor</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3" class="text-right">
                                                    Total
                                                </th>
                                                <th id="tableTotal">
                                                    0,00
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="card-footer"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-12 col-md-12">
                    <form action="{{ route('agentes-pagamentos.store') }}" method="POST">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Dados do Pagamento</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <label for="forma_pagamento_id" class="form-label">Formas de Pagamentos</label>
                                        <div class="input-group mb-3">
                                            <select class="form-control" id="forma_pagamento_id" name="forma_pagamento_id">
                                                <option value="">{{ __('messages.escolher') }} </option>
                                                @foreach ($formas_pagamentos as $item)
                                                <option value="{{ $item->id ?? "" }}" data-id="{{ $item->tipo }}">{{ $item->titulo }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4" id="form_caixas">
                                        <label for="caixa_id" class="form-label">Caixas</label>
                                        <div class="input-group mb-3">
                                            <select class="form-control select2" id="caixa_id" name="caixa_id" style="width: 100%">
                                                <option value="">{{ __('messages.escolher') }} </option>
                                                @foreach ($caixas as $item)
                                                <option value="{{ $item->id ?? "" }}">{{ $item->nome ?? "N/A" }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4" id="form_bancos">
                                        <label for="banco_id" class="form-label">Contas Bancárias</label>
                                        <div class="input-group mb-3">
                                            <select class="form-control select2" id="banco_id" name="banco_id" style="width: 100%">
                                                <option value="">{{ __('messages.escolher') }} </option>
                                                @foreach ($bancos as $item)
                                                <option value="{{ $item->id ?? "" }}">{{ $item->nome ?? "N/A" }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4" id="form_caixas_valores">
                                        <label for="motante" class="form-label">Motante Caixa</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="motante" id="motante" value="{{ old('motante') }}" placeholder="{{ __('messages.valor') }}">
                                        </div>
                                    </div>


                                    <div class="col-12 col-md-4" id="form_bancos_valores">
                                        <label for="motante_banco" class="form-label"> Motante Conta Bancária</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="motante_banco" id="motante_banco" value="{{ old('motante_banco') }}" placeholder="{{ __('messages.valor') }}">
                                        </div>
                                    </div>

                                    <input type="hidden" name="agente_selecionado_id" id="agente_selecionado_id">

                                    <div class="col-12 col-md-4">
                                        <label for="tipo_id" class="form-label">{{ __('messages.despesa') }}</label>
                                        <div class="input-group mb-3">
                                            <select class="form-control select2" id="tipo_id" name="tipo_id">
                                                @foreach ($tipos as $item)
                                                <option value="{{ $item->id ?? "" }}">{{ $item->nome ?? "N/A" }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <label>Referência</label>
                                        <input type="text" id="referencia" class="form-control">
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <label>Observação</label>
                                        <input type="text" id="observacao" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <button type="submit" class="btn btn-light-success">
                                        <i class="fas fa-money-check"></i>
                                        Finalizar Pagamento
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection

@section('scripts')
<script>
    const routes = {
        ficha: "{{ route('comissoes.imprimir', ':id') }}"
    , };

    $('.select2').select2({
        width: '100%'
    });

    $('#agente_id').change(function() {
        let agent = $(this).val();
        if (agent == '') return;

        $("#agente_selecionado_id").val(agent);

        loadCommissions(agent);
    });

    function loadCommissions(agent) {
        $.ajax({
            url: '/agentes-pagamentos/comissoes/' + agent
            , type: 'GET'
            , beforeSend: function() {
                $('#tableCommissions tbody').html('');
            }
            , success: function(response) {
                fillCards(response);
                fillTable(response.comissoes);
            }
            , error: function() {
                alert('Erro ao consultar.');
            }
        });
    }

    function fillCards(response) {
        $('#clients').html(response.summary.clients);
        $('#totalCommission').html(
            money(response.summary.total)
        );
        $('#paymentAmount').html(
            money(response.summary.total)
        );
    }

    function fillTable(commissions) {
        let html = '';
        let total = 0;
        $.each(commissions, function(i, item) {
            total += parseFloat(item.valor);
            html += `
            <tr>
                <td>${item.id}</td>
                <td>${item.cliente ? item.cliente.nome : "N/A"}</td>
                <td>${item.servico ? item.servico.nome : "N/A"}</td>
                <td>${money(item.valor)}</td>
            </tr>
        `;
        });

        $('#tableCommissions tbody').html(html);

        $('#tableTotal').html(
            money(total)
        );
    }

    function money(value) {
        return Number(value).toLocaleString('pt-AO', {
            minimumFractionDigits: 2
            , maximumFractionDigits: 2
        }) + ' Kz';
    }

    $(document).ready(function() {
        $('form').on('submit', function(e) {
            e.preventDefault(); // Impede o envio tradicional do formulário

            //=======================================================
            // formatar valores
            let motante = document.getElementById("motante");
            // Converter de "10.000,50" para "10000.50"
            let rawValue = motante.value.replace(/\./g, "").replace(",", ".");
            motante.value = parseFloat(rawValue).toFixed(2); // Garantir 2 casas decimais

            // formatar valores
            let motante_banco = document.getElementById("motante_banco");
            // Converter de "10.000,50" para "10000.50"
            let rawValue1 = motante_banco.value.replace(/\./g, "").replace(",", ".");
            motante_banco.value = parseFloat(rawValue1).toFixed(2); // Garantir 2 casas decimais
            // //==============================================================

            let form = $(this);
            let formData = form.serialize(); // Serializa os dados do formulário

            $.ajax({
                url: form.attr('action'), // URL do endpoint no backend
                method: form.attr('method'), // Método HTTP definido no formulário
                data: formData, // Dados do formulário
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
                , beforeSend: function() {
                    // Você pode adicionar um loader aqui, se necessário
                    progressBeforeSend();
                }
                , success: function(response) {
                    // Feche o alerta de carregamento
                    Swal.close();
                    // Exibe uma mensagem de sucesso
                    showMessage('Sucesso!', 'Operação realizada com sucesso!', 'success');

                    let url_ficha = routes.ficha.replace(':id', response.pagamento.id);

                    window.open(url_ficha, '_blank', 'noopener,noreferrer');

                }
                , error: function(xhr) {
                    // Feche o alerta de carregamento
                    Swal.close();

                    // Trata erros e exibe mensagens para o usuário
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let messages = '';
                        $.each(errors, function(key, value) {
                            messages += `${value}\n *`; // Exibe os erros
                        });

                        showMessage('Erro de Validação!', messages, 'error');

                    } else {

                        showMessage('Erro!', xhr.responseJSON.message, 'error');

                    }

                }
            , });
        });
    });

    const forma_pagamento_id = document.getElementById('forma_pagamento_id');

    const form_caixas = document.getElementById('form_caixas');
    const form_bancos = document.getElementById('form_bancos');
    const form_caixas_valores = document.getElementById('form_caixas_valores');
    const form_bancos_valores = document.getElementById('form_bancos_valores');

    form_caixas.style.display = 'none';
    form_bancos.style.display = 'none';

    form_caixas_valores.style.display = 'none';
    form_bancos_valores.style.display = 'none';

    if (forma_pagamento_id) {
        forma_pagamento_id.addEventListener('change', function() {

            let selectedOption = this.options[this.selectedIndex]; // Obtém o <option> selecionado
            let tipo = selectedOption.getAttribute('data-id'); // Pega o data-id

            if (tipo === 'NU') {
                form_caixas.style.display = 'block';
                form_bancos.style.display = 'none';

                form_caixas_valores.style.display = 'block';
                form_bancos_valores.style.display = 'none';

            } else if (tipo === 'MB' || tipo === 'DE' || tipo === 'TE') {
                form_bancos.style.display = 'block';
                form_caixas.style.display = 'none';

                form_caixas_valores.style.display = 'none';
                form_bancos_valores.style.display = 'block';

            } else if (tipo === 'OU') {
                form_caixas.style.display = 'block';
                form_bancos.style.display = 'block';
                form_caixas_valores.style.display = 'block';
                form_bancos_valores.style.display = 'block';
            }
        });
    } else {
        console.error("Elemento com ID 'forma_pagamento_id' não encontrado!");
    }

    document.getElementById("motante").addEventListener("input", function(e) {
        let value = e.target.value.replace(/\D/g, ""); // Remove tudo que não for número
        let numericValue = parseFloat(value) / 100; // Ajusta casas decimais

        // Formata para exibição no padrão brasileiro (10.000,50)
        e.target.value = numericValue.toLocaleString("pt-BR", {
            minimumFractionDigits: 2
        });
    });

    document.getElementById("motante_banco").addEventListener("input", function(e) {
        let value = e.target.value.replace(/\D/g, ""); // Remove tudo que não for número
        let numericValue = parseFloat(value) / 100; // Ajusta casas decimais

        // Formata para exibição no padrão brasileiro (10.000,50)
        e.target.value = numericValue.toLocaleString("pt-BR", {
            minimumFractionDigits: 2
        });
    });

</script>
@endsection
