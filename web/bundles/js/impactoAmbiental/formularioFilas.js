function agregarFila(idTabla){
    let html = $('#' + idTabla + ' tbody tr').html();
    $('#' + idTabla + ' tbody').append(`<tr>` + html + `</tr>`);
    reordenar(idTabla);

}

function eliminarFila(fila, idTabla){

    if($("#" + idTabla +" tbody tr").length != 1){
        fila.closest('tr').remove();
        reordenar(idTabla); 
    }

}

function reordenar(idTabla){

    let num = 1;
    $('#' + idTabla + ' tbody tr').each(function(){
        $(this).find('th').eq(0).text(num);
        num++;
    })

}