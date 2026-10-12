<div class="modal fade" id="modalDente" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title">
                    <i class="fas fa-tooth"></i>
                    Dente
                    <span id="tituloDente"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>
                        &times;
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="dente_id" name="dente_id">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>
                                Estado do Dente
                            </label>
                            <select id="estado_dente_id" class="form-control">
                                <option value="">
                                    Selecione
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>
                                Procedimento
                            </label>
                            <select id="procedimento_id" class="form-control">
                                <option value="">
                                    Selecione
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>
                        Observação Clínica
                    </label>
                    <textarea id="observacao" class="form-control" rows="4" placeholder="Digite observações..."></textarea>
                </div>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    As alterações serão salvas automaticamente.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Fechar
                </button>
                <button type="button" class="btn btn-primary" id="btnSalvarDente">
                    <i class="fas fa-save"></i>
                    Salvar
                </button>
            </div>
        </div>
    </div>
</div>
