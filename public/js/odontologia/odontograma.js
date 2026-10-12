$(document).ready(function () {
    $(document).on('click', '[id]', function () {
        let codigo = $(this).attr('id');
        if (!/^[0-9]{2}$/.test(codigo)) {
            return;
        }
        buscarDente(codigo);
    });
});

function buscarDente(codigo) {
    $.ajax({
        url: '/odontologia/odontograma/dente/' + codigo,
        method: 'GET',
        success: function (response) {
            if (response.success) {
                $('#tituloDente').text(response.dente.codigo + ' - ' + response.dente.nome);
                $('#dente_id').val(response.dente.id);
                carregarEstados(response.estados);

                carregarProcedimentos(response.procedimentos);

                $('#modalDente').modal('show');
            }
        },
        error: function () {
            alert('Erro ao carregar dente');
        }
    });
}

function carregarEstados(estados) {

    let select = $('#estado_dente_id');
    select.empty();
    select.append(
        '<option value="">Selecione</option>'
    );
    estados.forEach(function (item) {
        select.append(
            `
            <option value="${item.id}">
            ${item.nome}
            </option>
            `
        );
    });
}

function carregarProcedimentos(procedimentos) {
    let select = $('#procedimento_id');
    select.empty();
    select.append(
        '<option value="">Selecione</option>'
    );
    procedimentos.forEach(function (item) {
        select.append(
            `
            <option value="${item.id}">
            ${item.nome}
            </option>
            `
        );
    });
}
