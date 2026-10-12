@extends('adminlte::page')


@section('title','Visualizar SVG')



@section('content_header')

<h1>
    Detalhes SVG
</h1>

@stop



@section('content')


<div class="card">


    <div class="card-body">


        <h4>

            Dente:

            {{ $svg->dente->codigo_fdi }}

        </h4>


        <hr>


        <div class="text-center">


            <img src="{{ asset('storage/'.$svg->arquivo_svg) }}" style="max-width:250px;">


        </div>



        <hr>


        <p>

            <strong>ID SVG:</strong>

            {{ $svg->svg_id }}

        </p>



        <p>

            <strong>Arquivo:</strong>

            {{ $svg->arquivo_svg }}

        </p>



    </div>


</div>


@stop
