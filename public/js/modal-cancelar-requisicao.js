$('.modal-cancelar-requisicao').on('click', function(e) {
    e.preventDefault();
    var form = $(this).parent();
    
    swal({
        title: 'Tem certeza que deseja cancelar essa requisição?',
        text: 'Atenção! Esta ação não pode ser desfeita.', 
        icon: 'warning',
        buttons: true,
        buttons: ['Fechar', 'Cancelar Requisição'],
        dangerMode: true
    }).then((willDelete) => {
        if (willDelete) {
            swal('Aguarde... o registro está sendo cancelado!', {
                title: 'Pronto!',
                icon: 'success',
                buttons: false
            });

            setTimeout(function() {
                form.submit();
            }, 2000);
        } else {
            swal('Requisição não cancelada!', {
                title: 'Cancelado!',
                icon: 'success',
            });
        }
    });
});
