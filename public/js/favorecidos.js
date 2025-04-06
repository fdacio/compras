$('.btn-cnpj-cpf').on('click', function () {
    var cnpj_cpf = $('#cnpj-cpf').val();
    if (cnpj_cpf == '') return;
    var button = $(this);
    button.attr('disabled', true);
    button.html('<i class="fa fa-spin fa-spinner"></i>');
    cnpj_cpf = cnpj_cpf.replaceAll('.', '').replace('-', '').replace('/', '');
    var url = rota.favorecido.replace('_cnpjcpf_', cnpj_cpf);
    $.get(url, function (favorecido) {
        if (favorecido.pessoa == undefined) {
            $('span.text-danger').html('CPF/CNPJ Não cadastrado');
            return;
        }
        $('span.text-danger').html('');
        var nomeRazaoSocial = (favorecido.pessoa.pessoa_juridica != undefined) ? favorecido.pessoa.pessoa_juridica.razao_social : favorecido.pessoa.pessoa_fisica.nome;
        $('#razao-social-nome').val(nomeRazaoSocial);
        var texto = (favorecido.pessoa.pessoa_juridica != undefined) ? favorecido.pessoa.pessoa_juridica.razao_social : favorecido.pessoa.pessoa_fisica.nome;
        $('select[id=favorecidos]').append('<option value="' + favorecido.id + '" selected="selected">' + texto + '</option>');
        $('#id_favorecido').val(favorecido.id);
        if ($('#banco') != undefined) {
            $('#banco').val(favorecido.banco);
        }
        if ($('#agencia') != undefined) {
            $('#agencia').val(favorecido.agencia);
        }
        if ($('#conta') != undefined) {
            $('#conta').val(favorecido.conta);
        }
        if ($('#operacao') != undefined) {
            $('#operacao').val(favorecido.operacao);
        }
        if ($('#chave-pix') != undefined) {
            $('#chave-pix').val(favorecido.chave_pix);
        }

    }).done(function () {
        setTimeout(function () {
            button.attr('disabled', false);
            button.html('<i class="fa fa-search"></i>');
        }, 1500);
    });

});

$('#favorecidos').select2({
    placeholder: 'Informe Razão Social ou Nome',
    minimumInputLength: 1,
    theme: 'bootstrap',
    language: 'pt-BR',
    ajax: {
        url: rota.favorecidos,
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                tipo_pessoa: $('#pessoa').val(),
                nome_razao_social: $.trim(params.term)
            }
        },
        processResults: function (data) {
            return {
                results: $.map(data, function (favorecido) {
                    var texto = (favorecido.pessoa.pessoa_fisica != undefined) ? favorecido.pessoa.pessoa_fisica.nome : favorecido.pessoa.pessoa_juridica.razao_social;
                    var cpfCnpj = (favorecido.pessoa.pessoa_fisica != undefined) ? favorecido.pessoa.pessoa_fisica.cpf : favorecido.pessoa.pessoa_juridica.cnpj;
                    var _favorecido = favorecido;
            
                    return {
                        text: texto,
                        id: favorecido.id,
                        cnpj_cpf: cpfCnpj,
                        favorecido: _favorecido,
                    }
                })
            }
        },
        select: function (data) { },
        cache: true
    }

}).on("select2:select", function (e) {
    var cnpjCpf = e.params.data.cnpj_cpf;
    var id = e.params.data.id;
    var favorecido = e.params.data.favorecido;
    
    $('#cnpj-cpf').val(cnpjCpf).trigger('mask');
    $('#id_favorecido').val(id);
    if ($('#banco') != undefined) {
        $('#banco').val(favorecido.banco);
    }
    if ($('#agencia') != undefined) {
        $('#agencia').val(favorecido.agencia);
    }
    if ($('#conta') != undefined) {
        $('#conta').val(favorecido.conta);
    }
    if ($('#operacao') != undefined) {
        $('#operacao').val(favorecido.operacao);
    }
    if ($('#chave-pix') != undefined) {
        $('#chave-pix').val(favorecido.chave_pix);
    }

});
