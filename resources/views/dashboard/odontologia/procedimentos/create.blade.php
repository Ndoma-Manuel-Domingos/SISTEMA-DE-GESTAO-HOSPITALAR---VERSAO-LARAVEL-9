@extends('adminlte::page')


@section('title','Novo Procedimento')



@section('content_header')

<h1>

    Novo Procedimento Odontológico

</h1>

@stop




@section('content')


<div class="card card-primary">


    <div class="card-header">

        Cadastro de Procedimento

    </div>




    <div class="card-body">


        <form method="POST" action="{{ route('dashboard.odontologia.procedimentos.store') }}">



            @include('odontologia.procedimentos._form')



        </form>


    </div>


</div>


@stop
