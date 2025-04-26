$('.modal-desativar-user').on('click', function(e) {
    e.preventDefault();
    var form = $(this).parent();
    
    swal({
        title: 'Desativar o usuário?',
        text: 'Atenção! Este usuário não terá mais acesso ao sistema.', 
        icon: 'warning',
        buttons: true,
        buttons: ['Cancelar', 'Desativar'],
        dangerMode: true
    }).then((willDelete) => {
        if (willDelete) {
            swal('Aguarde... o registro está sendo desativado!', {
                title: 'Pronto!',
                icon: 'success',
                buttons: false
            });

            setTimeout(function() {
                form.submit();
            }, 2000);
        } else {
            swal('Registro não desativado!', {
                title: 'Cancelado!',
                icon: 'success',
            });
        }
    });
});
