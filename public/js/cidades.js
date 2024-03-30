
var nomeCidade = "";
var idCidade = 0;

$('select[name=estado]').change(function () {
    if ($(this).val() != '') {
        getCidades($(this).val());
    }
});

function setEstado(estado, cidade) {
    nomeCidade = cidade;
    $("select[name=estado] option").attr('selected', false);
    $("select[name=estado] option").filter(function () {
        return $(this).text() === estado;
    }).attr('selected', true).trigger('change');
}

function setEstadoCidadeId(estado, id) {
    idCidade = id;
    $("select[name=estado] option").attr('selected', false);
    $("select[name=estado] option").filter(function () {
        return $(this).text() === estado;
    }).attr('selected', true).trigger('change');
}

//Função ajax para obter as cidades do estado selecionado
function getCidades(id_estado) {

    $('select[name=id_municipio]').empty();
    $('select[name=id_municipio]').append('<option value="">Carregando...</option>');
    setTimeout(function () {
        //Rota vem de variável globa no layout.app.blade
        var url = rota.cidades.replace('_estado_', id_estado);
        $.get(url, function (cidades) {
            $('select[name=id_municipio]').empty();
            $('select[name=id_municipio]').append('<option value="">Selecione a Cidade</option>');
            var selected = '';
            $.each(cidades, function (key, cidade) {
                if (nomeCidade != '') {
                    var texto1 = removeAcento(nomeCidade.toLowerCase());
                    var texto2 = removeAcento(cidade.nome.toLowerCase());
                    if ( texto1 == texto2) { selected = 'selected = "selected"'; } else { selected = ""; };
                }
                if (idCidade > 0) {
                    if (idCidade == cidade.id) { selected = 'selected = "selected"'; } else { selected = ""; };
                }

                $('select[name=id_municipio]').append('<option value="' + cidade.id + '" ' + selected + '>' + cidade.nome + '</option>');
            });
        });
    }, 1500);
}



function removeAcento (text)
{       
    text = text.toLowerCase();                                                         
    text = text.replace(new RegExp('[ÁÀÂÃ]','gi'), 'a');
    text = text.replace(new RegExp('[ÉÈÊ]','gi'), 'e');
    text = text.replace(new RegExp('[ÍÌÎ]','gi'), 'i');
    text = text.replace(new RegExp('[ÓÒÔÕ]','gi'), 'o');
    text = text.replace(new RegExp('[ÚÙÛ]','gi'), 'u');
    text = text.replace(new RegExp('[Ç]','gi'), 'c');
    return text;                 
}
