$('.btn-cnpj-cpf').on('click', function() {
    var cnpj_cpf = $('#cnpj-cpf').val();
    if (cnpj_cpf == '') return;
    var button = $(this);
    button.attr('disabled', true);
    button.html('<i class="fa fa-spin fa-spinner"></i>');
    cnpj_cpf = cnpj_cpf.replaceAll('.', '').replace('-', '').replace('/', '');
    if (cnpj_cpf.length == 14) {
        var url = rota.cnpj.replace('_cnpj_', cnpj_cpf);
    } else if (cnpj_cpf == 11) {
        var url = rota.cpf.replace('_cpf_', cnpj_cpf);
    }    
    $.get(url, function(response) {
        if (response.length == 0) return;
        $('#razao-social-nome').val((response.razao_social != undefined) ? response.razao_social : response.nome);
    }).done(function() {
        setTimeout(function () {
        button.attr('disabled', false);
        button.html('<i class="fa fa-search"></i>');
        }, 2500);
        
    });

});