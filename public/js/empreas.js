$('.btn-cnpj-cpf').on('click', function() {
    var cnpj_cpf = $('#cnpj-cpf').val();
    if (cnpj_cpf == '') return;
    var button = $(this);
    button.attr('disabled', true);
    button.html('<i class="fa fa-spin fa-spinner"></i>');
    cnpj_cpf = cnpj_cpf.replaceAll('.', '').replace('-', '').replace('/', '');
    var url = rota.empresa.replace('_cnpjcpf_', cnpj_cpf);
    $.get(url, function(empresa) {
        if (empresa.pessoa == undefined) {
            $('span.text-danger').html('CPF/CNPJ Não cadastrado');
            return;
        }
        $('span.text-danger').html('');
        var nomeRazaoSocial = (empresa.pessoa.pessoa_juridica != undefined) ? empresa.pessoa.pessoa_juridica.razao_social : empresa.pessoa.pessoa_fisica.nome;
        $('#razao-social-nome').val(nomeRazaoSocial);
        var texto = (empresa.pessoa.pessoa_juridica != undefined) ? empresa.pessoa.pessoa_juridica.razao_social : empresa.pessoa.pessoa_fisica.nome;
        $('select[id=empresaes]').append('<option value="' + empresa.id + '" selected="selected">' + texto + '</option>');
        $('#id_empresa').val(empresa.id);
    }).done(function() {
        setTimeout(function () {
        button.attr('disabled', false);
        button.html('<i class="fa fa-search"></i>');
        }, 2500);        
    });

});

$('#empresaes').select2({
    placeholder: 'Informe Razão Social ou Nome',
    minimumInputLength: 1,
    theme:'bootstrap',
    language: 'pt-BR',
    ajax: {
        url: rota.empresaes,
        dataType: 'json',
        delay: 250,
        data: function(params) {
            return {
                tipo_pessoa: $('#pessoa').val(),
                nome_razao_social: $.trim(params.term)
            }
        },
        processResults: function(data) {
            return {
                results: $.map(data, function(empresa) {
                    var texto = (empresa.pessoa.pessoa_fisica != undefined) ? empresa.pessoa.pessoa_fisica.nome : empresa.pessoa.pessoa_juridica.razao_social;
                    var cpfCnpj = (empresa.pessoa.pessoa_fisica != undefined) ? empresa.pessoa.pessoa_fisica.cpf : empresa.pessoa.pessoa_juridica.cnpj;
                    return {
                        text: texto,
                        id: empresa.id,
                        cnpj_cpf: cpfCnpj
                    }
                })
            }
        },
        select: function(data) {},
        cache: true
    }

}).on("select2:select", function(e) {
    var cnpjCpf = e.params.data.cnpj_cpf;
    var id = e.params.data.id;
    $('#cnpj-cpf').val(cnpjCpf).trigger('mask');
    $('#id_empresa').val(id);
});
