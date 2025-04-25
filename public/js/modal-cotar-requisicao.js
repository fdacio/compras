$('.modal-cotar-requisicao').on('click', function(e) {
    e.preventDefault();
    var form = $(this).parent();
    
    swal({
        title: 'Deseja realizar a cotação dessa requisição?',
        text: 'Será solicitado informações de fornecedores e valores.', 
        icon: 'warning',
        buttons: true,
        buttons: ['Cancelar', 'Cotar'],
        dangerMode: true
    }).then((willDelete) => {
        if (willDelete) {
            swal('Aguarde... o registro está sendo processado!', {
                title: 'Pronto!',
                icon: 'success',
                buttons: false
            });

            setTimeout(function() {
                form.submit();
            }, 2000);
        } else {
            swal('Operação de cotar requisição cancelada!', {
                title: 'Cancelado!',
                icon: 'success',
            });
        }
    });
});
