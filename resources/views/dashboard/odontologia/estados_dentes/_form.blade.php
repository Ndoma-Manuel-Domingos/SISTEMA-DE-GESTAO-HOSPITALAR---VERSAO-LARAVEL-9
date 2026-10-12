@csrf
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Nome do Estado <span class="text-danger">*</span> </label>
            <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome',$estado->nome ?? '') }}" required>
            @error('nome')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label>Cor SVG</label>
            <input type="color" name="cor" class="form-control" value="{{ old('cor',$estado->cor ?? '#28a745') }}">
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label>Ícone</label>
            <input type="text" name="icone" class="form-control" placeholder="fas fa-tooth" value="{{ old('icone',$estado->icone ?? '') }}">
        </div>
    </div>
</div>

<div class="form-group">
    <label>Descrição</label>
    <textarea name="descricao" class="form-control" rows="4">{{ old('descricao',$estado->descricao ?? '') }}</textarea>
</div>

<div class="form-group">
    <label>Status</label>
    <select name="ativo" class="form-control">
        <option value="1" @selected(old('ativo',$estado->ativo ?? 1)==1)>
            Ativo
        </option>
        <option value="0" @selected(old('ativo',$estado->ativo ?? 1)==0)>
            Inativo
        </option>
    </select>
</div>

<button class="btn btn-primary">
    <i class="fas fa-save"></i>
    Guardar
</button>
<a href="{{ route('odontologia.estados-dentes.index') }}" class="btn btn-secondary">
    Voltar
</a>
