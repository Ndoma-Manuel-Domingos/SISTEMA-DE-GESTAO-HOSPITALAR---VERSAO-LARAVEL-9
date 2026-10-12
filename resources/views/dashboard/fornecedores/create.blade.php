@extends('layouts.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> <i class="fas fa-plus"></i> {{ __('messages.novo') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        @if ($empresa_logada->empresa->tipo_entidade->sigla == 'HOSP')
                        <li class="breadcrumb-item"><a href="{{ route('agentes.index') }}">{{ __('messages.voltar') }}</a></li>
                        <li class="breadcrumb-item active">Agentes</li>
                        @else
                        <li class="breadcrumb-item"><a href="{{ route('fornecedores.index') }}">{{ __('messages.voltar') }}</a></li>
                        <li class="breadcrumb-item active"> {{ __('messages.fornecedores') }} </li>
                        @endif
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
                        <form action="{{ route('fornecedores.store') }}" method="post" class="">
                            @csrf

                            <div class="card-header"></div>

                            <div class="card-body row">

                                <div class="col-12 col-md-3 mb-3">
                                    <label for="nome" class="col-form-label text-right">{{ __('messages.designacao') }}</label>
                                    <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome') }}" placeholder="Informe o Nome">
                                </div>

                                <div class="col-12 col-md-3 mb-3">
                                    <label for="nif" class="col-form-label text-right">{{ __('messages.bilhete_identidade') }}</label>
                                    <input type="text" class="form-control" id="nif" name="nif" value="{{ old('nif') }}" placeholder="Informe NIF">
                                </div>

                                <div class="col-12 col-md-3 mb-3">
                                    <label for="tipo_pessoa" class="col-form-label text-right">Tipo Pessoas</label>
                                    <select type="text" class="form-control" id="tipo_pessoa" name="tipo_pessoa">
                                        <option value="JURIDICA">JURÍDICA</option>
                                        <option value="FISICA">FISÍCA</option>
                                    </select>
                                </div>

                                @if ($empresa_logada->empresa->tipo_entidade->sigla == 'HOSP')
                                <div class="col-12 col-md-3 mb-3">
                                    <label for="pertece_id" class="col-form-label text-right">Agentes</label>
                                    <select type="text" class="form-control" id="pertece_id" name="pertece_id">
                                        <option value="">Escolher</option>
                                        @foreach ($agentes as $item)
                                        <option {{ $item->id }}>{{ $item->nome ?? "N/A" }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif

                                <div class="col-12 col-md-3 mb-3">
                                    @if ($empresa_logada->empresa->tipo_entidade->sigla == 'HOSP')
                                    <label for="tipo_fornecedor" class="col-form-label text-right">Tipo Agente</label>
                                    @else
                                    <label for="tipo_fornecedor" class="col-form-label text-right">Tipo Fornecedor</label>
                                    @endif
                                    <select type="text" class="form-control" id="tipo_fornecedor" name="tipo_fornecedor">
                                        <option value="corrente">Corrente</option>
                                        <option value="titulos a pagar">Títulos a pagar</option>
                                        <option value="imobilizado">Imobilizados</option>
                                    </select>
                                </div>

                                @if ($empresa_logada->empresa->tipo_entidade->sigla != 'HOSP')
                                <div class="col-12 col-md-3 mb-3">
                                    <label for="pais" class="col-form-label text-right">País</label>
                                    <select type="text" class="form-control" id="pais" name="pais">
                                        @include('includes.paises')
                                    </select>
                                </div>
                                @endif

                                <div class="col-12 col-md-3 mb-3">
                                    <label for="codigo_postal" class="col-form-label text-right">Codígo Postal</label>
                                    <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" value="{{ old('codigo_postal') }}" placeholder="Informe codigo Postal">
                                </div>

                                <div class="col-12 col-md-3 mb-3">
                                    <label for="localidade" class="col-form-label text-right">Localidade</label>
                                    <input type="text" class="form-control" id="localidade" name="localidade" value="{{ old('localidade') }}" placeholder="Informe  Localidade">
                                </div>

                                <div class="col-12 col-md-3 mb-3">
                                    <label for="telefone" class="col-form-label text-right"> {{ __('messages.telefone') }} </label>
                                    <input type="text" class="form-control" id="telefone" name="telefone" value="{{ old('telefone') }}" placeholder="{{ __('messages.telefone') }}">
                                </div>

                                <div class="col-12 col-md-3 mb-3">
                                    <label for="telemovel" class="col-form-label text-right"> {{ __('messages.telemovel') }} </label>
                                    <input type="text" class="form-control" id="telemovel" name="telemovel" value="{{ old('telemovel') }}" placeholder="{{ __('messages.telemovel') }}">
                                </div>

                                <div class="col-12 col-md-3 mb-3">
                                    <label for="email" class="col-form-label text-right">{{ __('messages.email') }}</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="{{ __('messages.email') }}">
                                </div>

                                <div class="col-12 col-md-3 mb-3">
                                    <label for="website" class="col-form-label text-right">WebSite</label>
                                    <input type="text" class="form-control" id="website" name="website" value="{{ old('website') }}" placeholder="Informe WebSite">
                                </div>

                                <div class="col-12 col-md-3 mb-3">
                                    <label for="observacao" class="col-form-label text-right">{{ __('messages.observacao') }}</label>
                                    <input type="text" class="form-control" id="observacao" name="observacao" value="{{ old('observacao') }}" placeholder="Informe Observação">
                                </div>

                            </div>

                            <div class="card-footer">
                                @if (Auth::user()->can('criar todos') || Auth::user()->can('criar fornecedores'))
                                <button type="submit" class="btn btn-light-primary">{{ __('messages.salvar') }}</button>
                                @endif
                                <button type="reset" class="btn btn-light-danger">{{ __('messages.cancelar') }} </button>
                            </div>
                        </form>
                    </div>
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
    $(document).ready(function() {
        $('form').on('submit', function(e) {
            e.preventDefault(); // Impede o envio tradicional do formulário

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
                    window.location.reload();
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

</script>
@endsection
