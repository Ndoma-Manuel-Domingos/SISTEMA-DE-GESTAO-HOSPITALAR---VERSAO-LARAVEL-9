@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Módulo de Odontologia</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard-principal') }}">{{ __('messages.inicio') }}</a></li>
                        <li class="breadcrumb-item active">Módulo de Odontologia</li>
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
                <div class="col-md-3 col-12">
                    <div class="small-box bg-light-primary">
                        <div class="inner">
                            <h3>Tipos</h3>
                            <p>Tipos de Dentição</p>
                        </div>
                        <a href="{{ route('odontologia.tipos-denticao.index') }}" class="small-box-footer">
                            Abrir
                        </a>
                    </div>
                </div>

                <div class="col-md-3 col-12">
                    <div class="small-box bg-light-success">
                        <div class="inner">
                            <h3>Dentes</h3>
                            <p>Cadastro</p>
                        </div>
                        <a href="{{ route('odontologia.dentes.index') }}" class="small-box-footer">
                            Abrir
                        </a>
                    </div>
                </div>

                <div class="col-md-3 col-12">
                    <div class="small-box bg-light-warning">
                        <div class="inner">
                            <h3>Estados</h3>
                            <p>Estados do Dente</p>
                        </div>
                        <a href="{{ route('odontologia.estados-dentes.index') }}" class="small-box-footer">
                            Abrir
                        </a>
                    </div>
                </div>

                <div class="col-md-3 col-12">
                    <div class="small-box bg-light-danger">
                        <div class="inner">
                            <h3>Procedimentos</h3>
                            <p>Procedimentos</p>
                        </div>
                        <a href="{{ route('odontologia.procedimentos.index') }}" class="small-box-footer">
                            Abrir
                        </a>
                    </div>

                </div>

            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection
