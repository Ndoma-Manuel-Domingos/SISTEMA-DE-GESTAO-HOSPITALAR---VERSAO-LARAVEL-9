@extends('adminlte::page')

@section('title','Editar Estado')
@section('content_header')
<h1>
    Editar Estado
</h1>
@stop

@section('content')
<div class="card card-warning">
    <div class="card-header">
        Atualização
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('odontologia.estados-dentes.update',$estado) }}">
            @method('PUT')
            @include('dashboard.odontologia.estados_dentes._form')
        </form>
    </div>
</div>
@stop
