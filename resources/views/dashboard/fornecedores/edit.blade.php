@extends('layouts.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> <i class="fas fa-edit"></i> {{ __('messages.editar') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        @if ($empresa_logada->empresa->tipo_entidade->sigla == 'HOSP')
                        <li class="breadcrumb-item"><a href="{{ route('agentes.index') }}">{{ __('messages.voltar') }}</a></li>
                        <li class="breadcrumb-item active">Agente</li>
                        @else
                        <li class="breadcrumb-item"><a href="{{ route('fornecedores.index') }}">{{ __('messages.voltar') }}</a></li>
                        <li class="breadcrumb-item active"> {{ __('messages.controle') }} </li>
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
            <div class="card">
                <form action="{{ route('fornecedores.update', $fornecedor->id) }}" method="post" class="">
                    @csrf
                    @method('put')

                    <div class="card-header"></div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-12 col-md-3 mb-3">
                                <label for="nome" class="col-form-label text-right">{{ __('messages.designacao') }}</label>
                                <input type="text" class="form-control" name="nome" value="{{ $fornecedor->nome }}" placeholder="Informe cliente">
                            </div>

                            <div class="col-12 col-md-3 mb-3">
                                <label for="nome" class="col-form-label text-right">{{ __('messages.bilhete_identidade') }}</label>
                                <input type="text" class="form-control" name="nif" value="{{ $fornecedor->nif }}" placeholder="Informe NIF">
                            </div>

                            <div class="col-12 col-md-3 mb-3">
                                <label for="tipo_pessoa" class="col-form-label text-right">Tipo Pessoas</label>
                                <select type="text" class="form-control" id="tipo_pessoa" name="tipo_pessoa">
                                    <option value="JURIDICA" {{ $fornecedor->tipo_pessoa == 'JURIDICA' ? 'selected' : '' }}>JURÍDICA</option>
                                    <option value="FISICA" {{ $fornecedor->tipo_pessoa == 'FISICA' ? 'selected' : '' }}>FISÍCA</option>
                                </select>
                            </div>

                            @if ($empresa_logada->empresa->tipo_entidade->sigla == 'HOSP')
                            <div class="col-12 col-md-3 mb-3">
                                <label for="pertece_id" class="col-form-label text-right">Agentes</label>
                                <select type="text" class="form-control" id="pertece_id" name="pertece_id">
                                    <option value="">Escolher</option>
                                    @foreach ($agentes as $item)
                                    <option value="{{$item->id}}" {{ $fornecedor->pertece_id == $item->id ? 'selected' : '' }}>{{ $item->nome ?? "N/A" }}</option>
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
                                    <option value="corrente" {{ $fornecedor->tipo_pessoa == 'Corrente' ? 'selected' : '' }}>Corrente</option>
                                    <option value="titulos a pagar" {{ $fornecedor->tipo_pessoa == 'corrente' ? 'selected' : '' }}>Títulos a pagar</option>
                                    <option value="imobilizado" {{ $fornecedor->tipo_pessoa == 'imobilizados' ? 'selected' : '' }}>Imobilizados</option>
                                </select>
                            </div>

                            @if ($empresa_logada->empresa->tipo_entidade->sigla != 'HOSP')
                            <div class="col-12 col-md-3 mb-3">
                                <label for="nome" class="col-form-label text-right">País</label>
                                <select type="text" class="form-control" name="pais">
                                    @include('includes.paises')
                                </select>
                            </div>
                            @endif


                            <div class="col-12 col-md-3 mb-3">
                                <label for="nome" class="col-form-label text-right">Codigo Postal</label>
                                <input type="text" class="form-control" name="codigo_postal" value="{{ $fornecedor->codigo_postal }}" placeholder="Informe codigo Postal">
                            </div>

                            <div class="col-12 col-md-3 mb-3">
                                <label for="nome" class="col-form-label text-right">Localidade</label>
                                <input type="text" class="form-control" name="localidade" value="{{ $fornecedor->localidade }}" placeholder="Informe  Localidade">
                            </div>

                            <div class="col-12 col-md-3 mb-3">
                                <label for="nome" class="col-form-label text-right"> {{ __('messages.telefone') }} </label>
                                <input type="text" class="form-control" name="telefone" value="{{ $fornecedor->telefone }}" placeholder="{{ __('messages.telefone') }}">
                            </div>

                            <div class="col-12 col-md-3 mb-3">
                                <label for="nome" class="col-form-label text-right"> {{ __('messages.telemovel') }} </label>
                                <input type="text" class="form-control" name="telemovel" value="{{ $fornecedor->telemovel }}" placeholder="{{ __('messages.telemovel') }}">
                            </div>

                            <div class="col-12 col-md-3 mb-3">
                                <label for="nome" class="col-form-label text-right"> {{ __('messages.email') }}</label>
                                <input type="email" class="form-control" name="email" value="{{ $fornecedor->email }}" placeholder="{{ __('messages.email') }}">
                            </div>

                            <div class="col-12 col-md-3 mb-3">
                                <label for="nome" class="col-form-label text-right">Website</label>
                                <input type="text" class="form-control" name="website" value="{{ $fornecedor->website }}" placeholder="Informe WebSite">
                            </div>

                            <div class="col-12 col-md-3 mb-3">
                                <label for="nome" class="col-form-label text-right">{{ __('messages.observacao') }}</label>
                                <input type="text" class="form-control" name="observacao" value="{{ $fornecedor->observacao }}" placeholder="Informe Observação">
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        @if (Auth::user()->can('editar todos') || Auth::user()->can('editar fornecedores'))
                        <button type="submit" class="btn btn-light-primary">{{ __('messages.salvar') }}</button>
                        @endif
                        <button type="reset" class="btn btn-light-danger">{{ __('messages.cancelar') }} </button>
                    </div>
                </form>
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
