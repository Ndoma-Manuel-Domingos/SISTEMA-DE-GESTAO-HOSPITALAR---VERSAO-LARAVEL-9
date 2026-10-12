@csrf


<div class="row">


    <div class="col-md-6">


        <div class="form-group">

            <label>
                Dente
            </label>


            <select name="dente_id" class="form-control" required>


                <option value="">
                    Selecionar dente
                </option>



                @foreach($dentes as $dente)


                <option value="{{ $dente->id }}" @selected( old( 'dente_id' , $svg->dente_id ?? ''
                    )
                    ==
                    $dente->id
                    )>


                    {{ $dente->codigo_fdi }}
                    -
                    {{ $dente->nome }}


                </option>


                @endforeach


            </select>


        </div>


    </div>



    <div class="col-md-6">


        <div class="form-group">


            <label>

                ID SVG

            </label>



            <input type="text" name="svg_id" class="form-control" value="{{ old('svg_id',$svg->svg_id ?? '') }}" placeholder="Ex: 11">


        </div>


    </div>


</div>




<div class="form-group">


    <label>

        Arquivo SVG

    </label>


    <input type="file" name="arquivo_svg" class="form-control" accept=".svg">



    @if(isset($svg) && $svg->arquivo_svg)


    <div class="mt-3">


        <strong>

            Arquivo atual:

        </strong>


        <a href="{{ asset('storage/'.$svg->arquivo_svg) }}" target="_blank">

            Visualizar SVG

        </a>


    </div>


    @endif



</div>





<div class="form-group">


    <label>

        Status

    </label>



    <select name="ativo" class="form-control">


        <option value="1" @selected(old('ativo',$svg->ativo ?? 1)==1)>

            Ativo

        </option>



        <option value="0" @selected(old('ativo',$svg->ativo ?? 1)==0)>

            Inativo

        </option>



    </select>



</div>





<button class="btn btn-primary">

    <i class="fas fa-save"></i>

    Guardar

</button>



<a href="{{ route('odontologia.dentes-svg.index') }}" class="btn btn-secondary">

    Voltar

</a>
