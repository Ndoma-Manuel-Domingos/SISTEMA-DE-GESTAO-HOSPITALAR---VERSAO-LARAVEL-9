@extends('adminlte::page')


@section('title','Estados dos Dentes')



@section('content_header')


<div class="d-flex justify-content-between">


    <h1>
        Estados dos Dentes
    </h1>


    <a href="{{ route('odontologia.estados-dentes.create') }}" class="btn btn-primary">

        <i class="fas fa-plus"></i>

        Novo Estado

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


    <div class="card-header">


        <form>


            <div class="input-group">


                <input type="text" name="pesquisa" class="form-control" placeholder="Pesquisar estado..." value="{{ request('pesquisa') }}">


                <div class="input-group-append">

                    <button class="btn btn-primary">

                        <i class="fas fa-search"></i>

                    </button>

                </div>


            </div>


        </form>


    </div>



    <div class="card-body p-0">


        <table class="table table-striped">


            <thead>

                <tr>

                    <th>Nome</th>

                    <th>Cor</th>

                    <th>Ícone</th>

                    <th>Status</th>

                    <th width="150">
                        Ações
                    </th>

                </tr>

            </thead>



            <tbody>


                @foreach($estados as $estado)


                <tr>


                    <td>

                        {{ $estado->nome }}

                    </td>


                    <td>


                        <span style="
background:{{ $estado->cor }};
padding:10px;
display:inline-block;
border-radius:5px;
">

                        </span>


                        {{ $estado->cor }}


                    </td>



                    <td>


                        @if($estado->icone)

                        <i class="{{ $estado->icone }}"></i>

                        @endif


                    </td>



                    <td>


                        @if($estado->ativo)

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


                        <a href="{{ route('odontologia.estados-dentes.show',$estado) }}" class="btn btn-info btn-sm">

                            <i class="fas fa-eye"></i>

                        </a>



                        <a href="{{ route('odontologia.estados-dentes.edit',$estado) }}" class="btn btn-warning btn-sm">

                            <i class="fas fa-edit"></i>

                        </a>



                        <form action="{{ route('odontologia.estados-dentes.destroy',$estado) }}" method="POST" class="d-inline">


                            @csrf

                            @method('DELETE')


                            <button class="btn btn-danger btn-sm" onclick="return confirm('Excluir estado?')">


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

        {{ $estados->links() }}

    </div>


</div>


@stop
