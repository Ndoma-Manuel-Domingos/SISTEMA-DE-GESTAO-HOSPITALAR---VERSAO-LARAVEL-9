@extends('adminlte::page')



@section('title','Editar Procedimento')




@section('content_header')

<h1>

    Editar Procedimento

</h1>

@stop





@section('content')



<div class="card card-warning">


    <div class="card-header">

        Atualização do Procedimento

    </div>




    <div class="card-body">


        <form method="POST" action="{{ route('odontologia.procedimentos.update',$procedimento) }}">



            @method('PUT')



            @include('odontologia.procedimentos._form')



        </form>


    </div>


</div>



@stop
