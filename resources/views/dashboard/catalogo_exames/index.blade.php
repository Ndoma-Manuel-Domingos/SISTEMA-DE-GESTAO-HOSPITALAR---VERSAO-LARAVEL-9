@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Catálogo de Exames</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('messages.voltar') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.controle') }}</li>
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
                            <h3 class="card-title">
                                Catálogo de Exames Disponíveis
                            </h3>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('catalogo-exames.store') }}">
                                @csrf
                                {{-- Pesquisa --}}
                                <div class="form-group">
                                    <input type="text" id="pesquisa" class="form-control" placeholder="Pesquisar exame...">
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="tabelaExames">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th width="50"><input type="checkbox" id="selecionarTodos"></th>
                                                <th>Código</th>
                                                <th>Exame</th>
                                                <th>Categoria</th>
                                                <th>Acção</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($exames as $exame)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="exames[]" value="{{ $exame->id }}" class="checkExame">
                                                </td>
                                                <td>{{ $exame->codigo }}</td>
                                                <td>{{ $exame->nome }}</td>
                                                <td>
                                                    <span class="badge badge-info">{{ $exame->categoria }}</span>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-light-primary btnDetalhe" data-id="{{ $exame->id }}" data-nome="{{ $exame->nome }}" data-parametros='@json($exame->parametros)'>
                                                        <i class="fas fa-eye"></i> Mais Detalhe
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <hr>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-light-success btn-lg">
                                        <i class="fas fa-save"></i>
                                        Salvar Exames Selecionados
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>


    <div class="modal fade" id="modalDetalhes" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Detalhes do Exame: <span id="nomeExame"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Parâmetro</th>
                                <th>Subparâmetros</th>
                            </tr>
                        </thead>
                        <tbody id="listaParametros">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection
@section('scripts')
<script>
    // Selecionar todos

    $("#selecionarTodos").click(function() {
        $(".checkExame").prop('checked', this.checked);
    });

    // Pesquisa
    $("#pesquisa").keyup(function() {
        let valor = $(this).val().toLowerCase();
        $("#tabelaExames tbody tr").filter(function() {
            $(this).toggle(
                $(this).text().toLowerCase().indexOf(valor) > -1
            );
        });
    });

    $(document).ready(function() {
        $('form').on('submit', function(e) {
            e.preventDefault();

            let form = $(this);
            let formData = form.serialize();

            $.ajax({
                url: form.attr('action')
                , method: "POST"
                , data: formData
                , headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
                , beforeSend: function() {
                    progressBeforeSend();
                }
                , success: function(response) {
                    Swal.close();
                    showMessage('Sucesso!', 'Operação realizada com sucesso!', 'success');
                    window.location.reload();
                }
                , error: function(xhr) {
                    Swal.close();

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let messages = '';

                        $.each(errors, function(key, value) {
                            messages += `${value}\n* `;
                        });

                        showMessage('Erro de Validação!', messages, 'error');
                    } else {
                        showMessage('Erro!', xhr.responseJSON.message, 'error');
                    }
                }
            });

        });
    });


    $(document).on('click', '.btnDetalhe', function() {
        let nome = $(this).data('nome');
        let parametros = $(this).data('parametros');
        $('#nomeExame').text(nome);
        let html = '';
        if (parametros.length > 0) {
            parametros.forEach(function(parametro) {
                let sub = '';
                if (parametro.subparametros.length > 0) {
                    sub += '<ul>';
                    parametro.subparametros.forEach(function(item) {
                        sub += `<li>${item.nome}</li>`;
                    });
                    sub += '</ul>';
                } else {
                    sub = '<span class="text-muted">Sem subparâmetros</span>';
                }
                html += `
                    <tr>
                        <td style="vertical-align: middle;">
                            ${parametro.ordem}
                        </td>
                        <td style="vertical-align: middle;">
                            ${parametro.nome}
                        </td>
                        <td>
                            ${sub}
                        </td>
                    </tr>
                `;
            });

        } else {
            html = `
                <tr>
                    <td colspan="2" class="text-center">
                        Nenhum parâmetro cadastrado
                    </td>
                </tr>
            `;
        }
        $('#listaParametros').html(html);
        $('#modalDetalhes').modal('show');
    });

</script>
@endsection
