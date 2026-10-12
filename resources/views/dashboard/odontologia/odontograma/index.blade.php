@extends('adminlte::page')


@section('title','Odontograma')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-tooth"></i>
        Odontograma
    </h1>

    <a href="{{ url()->previous() }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i>
        Voltar
    </a>
</div>
@stop

@section('content')
<div class="row">
    <!-- Informações do paciente -->
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    Paciente
                </h3>
            </div>
            <div class="card-body">
                <h4>
                    {{ $paciente->nome }}
                </h4>
                <p>
                    <strong>Data nascimento:</strong>
                    {{\Carbon\Carbon::parse($paciente->data_nascimento)->format('d/m/Y')}}
                </p>
                <p>
                    <strong>Idade:</strong>
                    {{ $idade }} anos
                </p>
                <p>
                    <strong>Sexo:</strong>
                    {{ $paciente->sexo }}
                </p>
                <hr>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    Dentição selecionada:
                    <strong>
                        {{ $tipoDenticao->nome }}
                    </strong>
                </div>
            </div>
        </div>
    </div>
    <!-- Área SVG -->
    <div class="col-md-8">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">
                    Odontograma
                </h3>
            </div>
            <div class="card-body text-center">
                <div id="odontograma-container">
                    <!-- SVG será carregado aqui Exemplo: dentes permanentes.svg dentes deciduos.svg-->
                    {!! $svgOdontograma !!}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Legenda dos estados -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            Legenda
        </h3>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($estados as $estado)
            <div class="col-md-3 mb-2">
                <div class="d-flex align-items-center">
                    <span style="width:25px;height:25px;background:{{ $estado->cor }};display:inline-block;border-radius:50%;margin-right:10px;"></span>
                    {{ $estado->nome }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Modal -->

@include('odontologia.odontograma.modal')
@stop
@section('css')
<style>
    #odontograma-container svg {
        width: 100%;
        max-height: 650px;
    }

    #odontograma-container svg path {
        cursor: pointer;
        transition: all .2s ease;
    }

    #odontograma-container svg path:hover {
        opacity: .7;
        stroke: #000;
        stroke-width: 2;
    }

    .dente-selecionado {
        stroke: #000;
        stroke-width: 3;
    }

</style>

@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="{{ asset('js/odontologia/odontograma.js') }}"></script>
@stop
