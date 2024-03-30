$('.btn-cpf').on('click', function () {
    var cpf = $('#cpf').val();
    if (cpf == '') return;
    var button = $(this);
    button.attr('disabled', true);
    button.html('<i class="fa fa-spin fa-spinner"></i>');
    cpf = cpf.replaceAll('.', '').replace('-', '');
    var url = rota.cpf.replace('_cpf_', cpf);
    $.get(url, function (response) {
        if (response.length == 0) return;
        $('#nome').val(response.nome);
        $('#rg').val(response.rg);
        $('#rg-orgao').val(response.rg_orgao);
        $('#rg-emissao').val(response.rg_emissao);
        $('#nascimento').val(response.nascimento);
        $('#sexo').val(response.sexo);
        $('#cep').val(response.cep);
        $('#logradouro').val(response.logradouro);
        $('#numero').val(response.numero);
        $('#bairro').val(response.bairro);
        $('#ponto-referencia').val(response.ponto_referencia);
        $('#email').val(response.email);
        var tel = response.telefone.replace('(', '').replace(')', '').replace('-', '').replace(' ', '');
        $('#telefone').val(tel).trigger('mask.maskedinput');
        $('#celular').val(response.celular);
        $('#numero').val(response.numero);
        $('#complemento').val(response.complemento);
        setEstado(response.uf, response.municipio);
    }).done(function () {
        setTimeout(function () {
            button.attr('disabled', false);
            button.html('<i class="fa fa-search"></i>');
        }, 2500);
    });

});