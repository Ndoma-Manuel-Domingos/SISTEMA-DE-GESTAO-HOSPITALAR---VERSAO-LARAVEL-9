@csrf

<div class="row">

    <div class="col-md-8">
        <div class="form-group">
            <label>Nome <span class="text-danger">*</span></label>

            <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome', $dente->nome ?? '') }}" required>

            @error('nome')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Código FDI *</label>

            <input type="text" name="codigo_fdi" maxlength="2" class="form-control @error('codigo_fdi') is-invalid @enderror" value="{{ old('codigo_fdi', $dente->codigo_fdi ?? '') }}" required>

            @error('codigo_fdi')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

</div>

<div class="row">

    <div class="col-md-4">

        <div class="form-group">

            <label>Tipo de Dentição</label>

            <select name="tipo_denticao_id" class="form-control" required>

                <option value="">Selecione...</option>

                @foreach($tipos as $tipo)

                <option value="{{ $tipo->id }}" @selected(old('tipo_denticao_id',$dente->tipo_denticao_id ?? '') == $tipo->id)>

                    {{ $tipo->nome }}

                </option>

                @endforeach

            </select>

        </div>

    </div>

    <div class="col-md-4">

        <div class="form-group">

            <label>Arcada</label>

            <select name="arcada" class="form-control">

                <option value="Superior" @selected(old('arcada',$dente->arcada ?? '')=='Superior')>

                    Superior

                </option>

                <option value="Inferior" @selected(old('arcada',$dente->arcada ?? '')=='Inferior')>

                    Inferior

                </option>

            </select>

        </div>

    </div>

    <div class="col-md-4">

        <div class="form-group">

            <label>Quadrante</label>

            <select name="quadrante" class="form-control">

                @foreach(['Q1','Q2','Q3','Q4', 'Q5','Q6','Q7','Q8'] as $q)

                <option value="{{ $q }}" @selected(old('quadrante',$dente->quadrante ?? '')==$q)>

                    {{ $q }}

                </option>

                @endforeach

            </select>

        </div>

    </div>

</div>

<div class="row">

    <div class="col-md-4">

        <div class="form-group">

            <label>Sexo</label>

            <select name="sexo" class="form-control">

                <option value="Ambos">Ambos</option>
                <option value="Masculino">Masculino</option>
                <option value="Feminino">Feminino</option>

            </select>

        </div>

    </div>

    {{-- <div class="col-md-4">

        <div class="form-group">

            <label>Idade Inicial</label>

            <input type="number" class="form-control" name="idade_inicial" value="{{ old('idade_inicial',$dente->idade_inicial ?? '') }}">

</div>

</div>

<div class="col-md-4">

    <div class="form-group">

        <label>Idade Final</label>

        <input type="number" class="form-control" name="idade_final" value="{{ old('idade_final',$dente->idade_final ?? '') }}">

    </div>

</div> --}}

</div>

<div class="row">

    <div class="col-md-6">

        <div class="form-group">

            <label>SVG</label>

            <input type="file" name="imagem_svg" class="form-control">

        </div>

    </div>

    <div class="col-md-3">

        <div class="form-group">

            <label>Status</label>

            <select name="ativo" class="form-control">

                <option value="1">Ativo</option>

                <option value="0">Inativo</option>

            </select>

        </div>

    </div>

</div>

<hr>

<button class="btn btn-primary">

    <i class="fas fa-save"></i>

    Salvar

</button>

<a href="{{ route('odontologia.dentes.index') }}" class="btn btn-secondary">

    Cancelar

</a>
