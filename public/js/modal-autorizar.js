$('.modal-autorizar').on('click', function(e) {
    e.preventDefault();
    var form = $(this).parent();
    
    swal({
        title: 'Tem certeza que deseja autorizar?',
        text: 'Atenção! Esta ação não pode ser desfeita.', 
        icon: 'warning',
        buttons: true,
        buttons: ['Cancelar', 'Autorizar'],
        dangerMode: true
    }).then((willDelete) => {
        if (willDelete) {
            swal('Aguarde... o registro está sendo autorizado!', {
                title: 'Pronto!',
                icon: 'success',
                buttons: false
            });

            setTimeout(function() {
                form.submit();
            }, 2000);
        } else {
            swal('Registro não autorizado!', {
                title: 'Cancelado!',
                icon: 'success',
            });
        }
    });
});
