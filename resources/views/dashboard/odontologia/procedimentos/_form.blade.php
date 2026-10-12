@csrf
<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            <label>
                Nome do Procedimento
                <span class="text-danger">*</span>
            </label>
            <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome',$procedimento->nome ?? '') }}" required>
            @error('nome')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>
                Código
                <span class="text-danger">*</span>
            </label>
            <input type="text" name="codigo" class="form-control" maxlength="20" value="{{ old('codigo',$procedimento->codigo ?? '') }}" required>
        </div>
    </div>
</div>

<div class="form-group">
    <label>
        Descrição
    </label>
    <textarea name="descricao" class="form-control" rows="4">{{ old('descricao',$procedimento->descricao ?? '') }}</textarea>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>
                Duração (minutos)
            </label>
            <input type="number" name="duracao" class="form-control" value="{{ old('duracao',$procedimento->duracao ?? '') }}">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>
                Valor
            </label>
            <input type="number" step="0.01" name="valor" class="form-control" value="{{ old('valor',$procedimento->valor ?? '') }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>
                Status
            </label>
            <select name="ativo" class="form-control">
                <option value="1" @selected(old('ativo',$procedimento->ativo ?? 1)==1)>
                    Ativo
                </option>
                <option value="0" @selected(old('ativo',$procedimento->ativo ?? 1)==0)>
                    Inativo
                </option>
            </select>
        </div>
    </div>
</div>

<button class="btn btn-primary">
    <i class="fas fa-save"></i>
    Guardar
</button>

<a href="{{ route('odontologia.procedimentos.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i>
    Voltar
</a>
