@extends('adminlte::page')


@section('title','Editar SVG')



@section('content_header')

<h1>
    Editar SVG
</h1>

@stop



@section('content')


<div class="card card-warning">


    <div class="card-header">

        Atualizar desenho

    </div>



    <div class="card-body">


        <form method="POST" action="{{ route('odontologia.dentes-svg.update',$svg) }}" enctype="multipart/form-data">


            @method('PUT')


            @include('odontologia.dentes_svg._form')


        </form>


    </div>


</div>


@stop
