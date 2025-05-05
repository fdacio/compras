$('.modal-finalizar-cotacao').on('click', function(e) {
    e.preventDefault();
    var form = $(this).parent();
    
    swal({
        title: 'Deseja finalizar essa cotação?',
        text: 'Após a finalização teremos o fornecedor vencedor.', 
        icon: 'warning',
        buttons: true,
        buttons: ['Cancelar', 'Finalizar'],
        dangerMode: true
    }).then((willDelete) => {
        if (willDelete) {
            swal('Aguarde... o registro está sendo processado!', {
                title: 'Pronto!',
                icon: 'success',
                buttons: false
            });

            setTimeout(function() {
                form[0].submit();
            }, 2000);
        } else {
            swal('Operação de finalizar cotação cancelada!', {
                title: 'Cancelado!',
                icon: 'success',
            });
        }
    });
});
