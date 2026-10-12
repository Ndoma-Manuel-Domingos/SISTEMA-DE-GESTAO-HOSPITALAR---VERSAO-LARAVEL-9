@extends('adminlte::page')
@section('title','Novo Estado')
@section('content_header')
<h1>
    Novo Estado do Dente
</h1>
@stop

@section('content')
<div class="card card-primary">
    <div class="card-header">
        Cadastro de Estado
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('odontologia.estados-dentes.store') }}">
            @include('dashboard.odontologia.estados_dentes._form')
        </form>
    </div>
</div>
@stop
