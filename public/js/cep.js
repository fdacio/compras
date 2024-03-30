
$('.btn-cep').on('click', function () {
    var cep = $('.cep').val();
    cep = cep.replace('.', '').replace('-', '');
    if (cep == '') return;
    var button = $(this);
    button.attr('disabled', true);
    var icon = button.html();
    button.html('<i class="fa fa-spin fa-spinner"></i>');
    $('#logradouro').val('');
    $('#bairro').val('');
    //rota.cep é global no layout app.blade.php 
    var url = rota.cep.replace('_cep_', cep);

    $.get(url, function (response) {
        $('#logradouro').val(response.logradouro);
        $('#bairro').val(response.bairro);
        setEstado(response.uf, response.localidade);
    }).done(function (response) {
        setTimeout(function () {
            button.attr('disabled', false);
            button.html(icon);
        }, 2500); // Para dá tempo de carregar todas as cidades para input select
    });

});

