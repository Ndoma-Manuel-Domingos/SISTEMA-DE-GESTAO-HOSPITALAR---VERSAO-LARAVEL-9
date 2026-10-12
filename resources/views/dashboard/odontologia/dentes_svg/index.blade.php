@extends('adminlte::page')


@section('title','SVG dos Dentes')



@section('content_header')


<div class="d-flex justify-content-between">


    <h1>

        SVG dos Dentes

    </h1>


    <a href="{{ route('odontologia.dentes-svg.create') }}" class="btn btn-primary">


        <i class="fas fa-plus"></i>

        Novo SVG


    </a>


</div>


@stop




@section('content')


@if(session('success'))

<div class="alert alert-success">

    {{ session('success') }}

</div>

@endif

<div class="card">
    <div class="card-body p-0">


        <table class="table table-striped">


            <thead>


                <tr>

                    <th>
                        Dente
                    </th>


                    <th>
                        SVG ID
                    </th>


                    <th>
                        Visualização
                    </th>


                    <th>
                        Status
                    </th>


                    <th>
                        Ações
                    </th>


                </tr>


            </thead>




            <tbody>



                @foreach($svgs as $svg)


                <tr>


                    <td>

                        {{ $svg->dente->codigo_fdi }}

                        <br>

                        <small>

                            {{ $svg->dente->nome }}

                        </small>


                    </td>



                    <td>

                        {{ $svg->svg_id }}

                    </td>




                    <td>


                        <img src="{{ asset('storage/'.$svg->arquivo_svg) }}" width="60">


                    </td>




                    <td>


                        @if($svg->ativo)

                        <span class="badge badge-success">

                            Ativo

                        </span>


                        @else


                        <span class="badge badge-danger">

                            Inativo

                        </span>


                        @endif


                    </td>




                    <td>


                        <a href="{{ route('odontologia.dentes-svg.show',$svg) }}" class="btn btn-info btn-sm">

                            <i class="fas fa-eye"></i>

                        </a>



                        <a href="{{ route('odontologia.dentes-svg.edit',$svg) }}" class="btn btn-warning btn-sm">

                            <i class="fas fa-edit"></i>

                        </a>




                        <form method="POST" action="{{ route('odontologia.dentes-svg.destroy',$svg) }}" class="d-inline">


                            @csrf

                            @method('DELETE')


                            <button class="btn btn-danger btn-sm" onclick="return confirm('Excluir SVG?')">


                                <i class="fas fa-trash"></i>


                            </button>


                        </form>


                    </td>


                </tr>



                @endforeach


            </tbody>


        </table>


    </div>


    <div class="card-footer">

        {{ $svgs->links() }}

    </div>


</div>



@stop
