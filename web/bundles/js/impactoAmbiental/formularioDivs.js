// Mostrar y ocultar divs

function mostrar(id){
    $('#' + id).css("display", "block");

    $( "#" + id + " .form-control" ).each(function(index) {
        this.setAttribute('required', true);
    })
}

function ocultar(id){
    $('#' + id).css("display", "none");

    $( "#" + id + " .form-control" ).each(function(index) {
        this.removeAttribute('required', false);
    })
}

// Agregar y eliminar divs

function agregar(idGeneral){
    let html = $('#' + idGeneral + ' div').html();
    $("#" + idGeneral).append(html);
}

function eliminar(trash, idGeneral){
    if($("#" + idGeneral +" .tabla-sub-pers").length != 1){
        trash.closest('.tabla-sub-pers').remove();
    }
}