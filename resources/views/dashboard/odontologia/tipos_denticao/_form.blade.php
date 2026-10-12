@csrf

<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            <label for="nome">
                Nome <span class="text-danger">*</span>
            </label>
            <input type="text" name="nome" id="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome', $tipo->nome ?? '') }}" maxlength="100" required>
            @error('nome')
            <span class="invalid-feedback">
                {{ $message }}
            </span>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="idade_inicial">
                Idade Inicial <span class="text-danger">*</span>
            </label>
            <input type="number" name="idade_inicial" id="idade_inicial" class="form-control @error('idade_inicial') is-invalid @enderror" value="{{ old('idade_inicial', $tipo->idade_inicial ?? '') }}" min="0" max="120" required>
            @error('idade_inicial')
            <span class="invalid-feedback">
                {{ $message }}
            </span>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="idade_final">
                Idade Final <span class="text-danger">*</span>
            </label>
            <input type="number" name="idade_final" id="idade_final" class="form-control @error('idade_final') is-invalid @enderror" value="{{ old('idade_final', $tipo->idade_final ?? '') }}" min="0" max="120" required>
            @error('idade_final')
            <span class="invalid-feedback">
                {{ $message }}
            </span>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Status</label>
            <select name="ativo" class="form-control">
                <option value="1" {{ old('ativo',$tipo->ativo ?? 1)==1?'selected':'' }}>
                    Ativo
                </option>
                <option value="0" {{ old('ativo',$tipo->ativo ?? 1)==0?'selected':'' }}>
                    Inativo
                </option>
            </select>
        </div>
    </div>
</div>

<div class="form-group">
    <label>Descrição</label>
    <textarea name="descricao" rows="4" class="form-control">{{ old('descricao',$tipo->descricao ?? '') }}</textarea>
</div>

<div class="mt-3">
    <button class="btn btn-primary">
        <i class="fas fa-save"></i>
        Salvar
    </button>
    <a href="{{ route('odontologia.tipos-denticao.index') }}" class="btn btn-secondary">
        Cancelar
    </a>
</div>
