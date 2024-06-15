$('.btn-cnpj').on('click', function() {
    
    $('#razao-social').val('');
    $('#nome-fantasia').val('');
    $('#cep').val('');
    $('#logradouro').val('');
    $('#numero').val('');
    $('#bairro').val('');
    $('#ponto-referencia').val('');
    $('#email').val('');
    $('#telefone').val('');
    $('#cgf').val('');
    $('#celular').val('');
    $('#numero').val('');
    $('#complemento').val('');

    var cnpj = $('#cnpj').val();
    if (cnpj == '') return;

    var button = $(this);
    button.attr('disabled', true);
    button.html('<i class="fa fa-spin fa-spinner"></i>');
    cnpj = cnpj.replaceAll('.', '').replace('-', '').replace('/', '');
    var url = rota.cnpj.replace('_cnpj_', cnpj);
    $.get(url, function(result) {
        if (result.pessoa) {
            var pessoa = result.pessoa;
            if (pessoa.length == 0) return;
            $('#razao-social').val(pessoa.nome);
            $('#nome-fantasia').val(pessoa.fantasia);
            $('#cep').val(pessoa.cep);
            $('#logradouro').val(pessoa.logradouro);
            $('#numero').val(pessoa.numero);
            $('#bairro').val(pessoa.bairro);
            $('#ponto-referencia').val(pessoa.ponto_referencia);
            $('#email').val(pessoa.email);
            var tel = pessoa.telefone.replace('(', '').replace(')', '').replace('-', '').replace(' ', '');
            $('#telefone').val(tel).trigger('mask');

            if(pessoa.cgf != undefined) {
                $('#cgf').val(pessoa.cgf);
            }
            if(pessoa.celular != undefined) {
                $('#celular').val(pessoa.celular);
            }
            if(pessoa.numero != undefined) {
                $('#numero').val(pessoa.numero);
            }
            if(pessoa.complemento != undefined) {
                $('#complemento').val(pessoa.complemento);
            }

            setEstado(pessoa.uf, pessoa.municipio);
        
        }
    }).done(function() {
        setTimeout(function () {
            button.attr('disabled', false);
            button.html('<i class="fa fa-search"></i>');
        }, 2500);
        
    });

});