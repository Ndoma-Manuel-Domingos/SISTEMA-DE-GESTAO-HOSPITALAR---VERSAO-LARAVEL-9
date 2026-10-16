@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> <i class="fas fa-edit"></i> {{ __('messages.editar') }}: <a href="{{ route('clientes.show', $triagem->paciente->id) }}">{{ $triagem->paciente->nome ?? "N/A" }}</a></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('triagens.index') }}">{{ __('messages.voltar') }}</a></li>
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

                        <div class="card-header"></div>
                        <form action="{{ route('triagens.update', $triagem->id) }}" method="post" class="">
                            @csrf
                            @method('put')
                            
                            
                            <div class="card-body row">
                            
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="paciente_id" class="form-label">Paciente</label>
                                    <select class="form-control select2" id="paciente_id" name="paciente_id">
                                        <option value="">{{ __('messages.escolher') }}</option>
                                        @foreach ($pacientes as $item)
                                        <option value="{{ $item->id ?? '' }}" {{ $triagem->paciente_id == $item->id ? 'selected' : "" }}>{{ $item->nome ?? "N/A" }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            
                                <!-- Prioridade -->
                                <div class="col-12 col-md-3 mb-3">
                                    <label for="prioridade_id" class="form-label">Prioridade</label>
                                    <select class="form-control select2" id="prioridade_id" name="prioridade_id">
                                        <option value="">{{ __('messages.escolher') }}</option>
                                        @foreach ($prioridades as $item)
                                        <option value="{{ $item->id ?? '' }}" {{ $triagem->prioridade_id == $item->id ? 'selected' : "" }}>
                                            @if ( $item->cor === "#FF4C4C") 🔴 @endif
                                            @if ( $item->cor === "#FF9900") 🟠 @endif
                                            @if ( $item->cor === "#FFCC00") 🟡 @endif
                                            @if ( $item->cor === "#66CC66") 🟢 @endif
                                            @if ( $item->cor === "#4DA6FF") 🔵 @endif
                                            @if ( $item->cor === "#CCCCCC") ⚪ @endif
                                            @if ( $item->cor === "#800080") 🟣 @endif
                                            {{ $item->nome ?? "N/A" }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            
                                <!-- Estado de Consciência -->
                                <div class="col-12 col-md-3 mb-3">
                                    <label for="estado_consciencia" class="form-label">Estado de Consciência</label>
                                    <select class="form-control" id="estado_consciencia" name="estado_consciencia">
                                        <option value="">{{ __('messages.escolher') }}</option>
                                        <option value="Alerta" {{ $triagem->estado_consciencia == "Alerta" ? 'selected' : '' }}>Alerta</option>
                                        <option value="Sonolento" {{ $triagem->estado_consciencia == "Alerta" ? 'selected' : '' }}>Sonolento</option>
                                        <option value="Inconsciente" {{ $triagem->estado_consciencia == "Alerta" ? 'selected' : '' }}>Inconsciente</option>
                                        <option value="Outros" {{ $triagem->estado_consciencia == "Outros" ? 'selected' : '' }}>Outros</option>
                                    </select>
                                </div>
                            
                                <!-- Queixa Principal -->
                                <div class="col-12 col-md-9 mb-3">
                                    <label for="queixa_principal" class="form-label">Queixa Principal</label>
                                    <textarea class="form-control" name="queixa_principal" placeholder="Queixa Principal" id="queixa_principal" rows="3">{{ $triagem->queixa_principal ?? '' }}</textarea>
                                </div>
                            
                                <div class="col-12 col-md-3">
                                    <div class="mb-3 mt-4 pt-1">
                                        <button type="button" id="start" class="btn btn-light-success my-1" style="width: 100%">
                                            🎤 Gravar
                                        </button>
                                        <button type="button" id="stop" class="btn btn-light-danger" style="width: 100%">
                                            ⏹ Parar
                                        </button>
                                    </div>
                                    <audio id="player" controls style="display:none"></audio>
                                    <input type="hidden" id="queixa_audio" name="queixa_audio">
                                </div>
                            
                                <!-- Sinais Vitais -->
                                <div class="col-12 col-md-3 mb-3">
                                    <label for="temperatura" class="form-label">Temperatura Corporal (ºC)</label>
                                    <input type="text" class="form-control" placeholder="Temperatura Corporal (ºC)" id="temperatura" name="temperatura" value="{{ $triagem->temperatura ?? '' }}">
                                </div>
                            
                                <div class="col-12 col-md-3 mb-3">
                                    <label for="pressao" class="form-label">Pressão Arterial Sistólica (mmHg)</label>
                                    <input type="text" class="form-control" placeholder="Pressão Arterial Sistólica (mmHg)" id="pressao" name="pressao" value="{{ $triagem->pressao ?? '' }}">
                                </div>
                            
                                <div class="col-12 col-md-3 mb-3">
                                    <label for="pressao_diatolica" class="form-label">Pressão Arterial Diastólica (mmHg)</label>
                                    <input type="text" class="form-control" placeholder="Pressão Arterial Diastólica (mmHg)" id="pressao_diatolica" name="pressao_diatolica" value="{{ $triagem->pressao_diatolica ?? '' }}">
                                </div>
                            
                                <div class="col-12 col-md-3 mb-3">
                                    <label for="freq_cardiaca" class="form-label">Frequência Cardíaca (bpm)</label>
                                    <input type="text" class="form-control" placeholder="Frequência Cardíaca (bpm)" id="freq_cardiaca" name="freq_cardiaca" value="{{ $triagem->freq_cardiaca ?? '' }}">
                                </div>
                            
                                <div class="col-12 col-md-3 mb-3">
                                    <label for="freq_respiratoria" class="form-label">Frequência Respiratória (irpm)</label>
                                    <input type="text" class="form-control" placeholder="Frequência Respiratória (irpm)" id="freq_respiratoria" name="freq_respiratoria" value="{{ $triagem->freq_respiratoria ?? '' }}">
                                </div>
                            
                                <div class="col-12 col-md-3 mb-3">
                                    <label for="saturacao_oxigenio" class="form-label">Saturação de Oxigénio (%)</label>
                                    <input type="text" class="form-control" placeholder="Saturação de Oxigénio (%)" id="saturacao_oxigenio" name="saturacao_oxigenio" value="{{ $triagem->saturacao_oxigenio ?? '' }}">
                                </div>
                            
                                <div class="col-12 col-md-3 mb-3">
                                    <label for="escala_dor" class="form-label">Dor (Escala 0 - 10)</label>
                                    <input type="number" class="form-control" id="escala_dor" placeholder="Dor (Escala 0 - 10)" name="escala_dor" min="0" max="10" step="1" value="{{ $triagem->escala_dor ?? '' }}">
                                </div>
                            
                                <!-- Antropometria -->
                                <div class="col-12 col-md-3 mb-3">
                                    <label for="peso" class="form-label">Peso (Kg)</label>
                                    <input type="text" class="form-control" id="peso" placeholder="Peso (Kg)" name="peso" value="{{ $triagem->peso ?? '' }}">
                                </div>
                            
                                <div class="col-12 col-md-3 mb-3">
                                    <label for="altura" class="form-label">Altura (cm)</label>
                                    <input type="text" class="form-control" id="altura" placeholder="Altura (cm)" name="altura" value="{{ $triagem->altura ?? '' }}">
                                </div>
                            
                                <div class="col-12 col-md-3 mb-3">
                                    <label for="circunferencia_abdominal" class="form-label">Circunferência Abdominal (cm)</label>
                                    <input type="text" class="form-control" id="circunferencia_abdominal" placeholder="Circunferência Abdominal (cm)" name="circunferencia_abdominal" value="{{ $triagem->circunferencia_abdominal ?? '' }}">
                                </div>
                            
                                <div class="col-12 col-md-3 mb-3">
                                    <label for="glicemia_capilar" class="form-label">Glicemia Capilar (mg/dL)</label>
                                    <input type="text" class="form-control" id="glicemia_capilar" name="glicemia_capilar" placeholder="Glicemia Capilar (mg/dL)" value="{{ $triagem->glicemia_capilar ?? '' }}">
                                </div>
                            
                                <div class="col-12 col-md-3 mb-3">
                                    <label for="gravidez" class="form-label">Gravida?</label>
                                    <select class="form-control" id="gravidez" name="gravidez">
                                        <option value="Não" {{ $triagem->gravidez == "Não" ? 'selected' : '' }}>Não</option>
                                        <option value="Sim" {{ $triagem->gravidez == "Sim" ? 'selected' : '' }}>Sim</option>
                                    </select>
                                </div>
                            
                                <!-- Encaminhamento -->
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="profissional_id" class="form-label">Médico</label>
                                    <select class="form-control select2" id="profissional_id" name="profissional_id">
                                        <option value="">{{ __('messages.escolher') }}</option>
                                        @foreach ($medicos as $item)
                                        <option value="{{ $item->id ?? '' }}" {{ $triagem->profissional_id == $item->id ? 'selected' : "" }}>
                                            {{ $item->funcionario->nome }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            
                                {{-- <div class="col-12 col-md-6 mb-3">
                                    <label for="tipo_atendimento_id" class="form-label">
                                        Tipo de Atendimento (Destino)
                                    </label>
                                    <select class="form-control" id="tipo_atendimento_id" name="tipo_atendimento_id">
                                        <option value="">{{ __('messages.escolher') }}</option>
                                        @foreach ($tipos_atendimentos as $item)
                                        <option value="{{ $item->sigla }}">
                                            {{ $item->nome ?? "N/A" }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div> --}}
                            
                                <!-- Observações -->
                                <div class="col-12 mb-3">
                                    <label for="observacoes" class="form-label">Observações</label>
                                    <textarea class="form-control" name="observacoes" id="observacoes" rows="3" placeholder="Observações">{{ $triagem->observacoes ?? '' }}</textarea>
                                </div>
                            </div>

                            <div class="card-footer">
                                @if (Auth::user()->can('editar todos') || Auth::user()->can('editar triagem'))
                                <button type="submit" class="btn btn-light-primary">{{ __('messages.salvar') }}</button>
                                @endif
                                <button type="reset" class="btn btn-light-danger">{{ __('messages.cancelar') }} </button>
                            </div>
                        </form>
                    </div>
                    <!-- /.row -->
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
