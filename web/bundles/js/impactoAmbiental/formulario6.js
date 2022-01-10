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
    // let divLast = $('#' + idGeneral).last();

    // var num=1;
    // $(divLast).find('select').each(function(){
    //     var innerSelect = $(this).attr('id');
    //     $(this).removeAttr("id");
    //     $(this).attr("id", innerSelect + num);
    //     num++;
    //     console.log($(this));
    // });

    let html = $('#' + idGeneral + ' div').html();
    $("#" + idGeneral).append('<div>' + html + '</div>');
}

function eliminar(trash, idGeneral){

    if($("#" + idGeneral +" .tabla-sub-pers").length != 1){
        // trash.closest('.tabla-sub-pers').closest('div').remove();
        trash.closest('#tablaActividades > div').remove();
    }
}