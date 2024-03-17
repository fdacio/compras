$(function () {
    $('.menu-responsive').hide();
    $(".navbar-toggler").on('click', function(event){
        event.preventDefault;
        $('.menu-responsive').removeClass('d-none');
        $('.menu-responsive a').addClass('text-white');
        $('.menu-responsive ul').addClass('nav flex-column');
        $('.menu-responsive').toggle();
    });
});