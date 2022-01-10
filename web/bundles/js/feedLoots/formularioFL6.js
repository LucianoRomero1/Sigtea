function agregarFila(){
    $("#filas").append(`
    <tr>
        <th scope="row">1</th>
        <td><input type="text" class="form-control" name="Recurso[tipo][]"  value=""></td>
        <td><input type="text" class="form-control" name=""  value=""></td>
        <td class="media">
            <input type="text" class="form-control" name=""  value="">
            <a onClick="eliminarFila(this)" class="btn text-danger mt-2"><i class="far fa-trash-alt"></i></a>
        </td>
    </tr>      `  
    );
    reordenar();
}


function eliminarFila(fila){
    fila.closest('tr').remove();
    reordenar();
}

function reordenar(){
    var num=1;
    $('#filas tr').each(function(){
        $(this).find('th').eq(0).text(num);
        num++;
    })
}

