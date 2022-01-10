$(document).ready(function () {
    $('.back').click(function(event){
        event.preventDefault();
        window.location.href=$(this).attr('href');   
    })

    $(".btn-outline-dark").click(function(event){
        event.preventDefault();
        $('#formulario').attr('action', $(this).data('url'));
        $('#formulario').submit();
    })
});