@extends('adminlte::page')


@section('title','Novo SVG')



@section('content_header')

<h1>
    Cadastrar SVG do Dente
</h1>

@stop



@section('content')


<div class="card card-primary">


    <div class="card-header">

        Novo desenho SVG

    </div>



    <div class="card-body">


        <form method="POST" action="{{ route('odontologia.dentes-svg.store') }}" enctype="multipart/form-data">


            @include('odontologia.dentes_svg._form')


        </form>


    </div>


</div>


@stop
