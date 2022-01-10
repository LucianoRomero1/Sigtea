
function agregarFila(){

    let html = `
        <tr>
            <th scope="row"></th>
            <td>
                <input type="text" value="" class="form-control" name="TipoImpacto[tipo][]" required />
            </td>
            <td>
                <div>
                    <a class="btn text-danger" onClick="eliminarFila(this)">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </div>
            </td>
        </tr>
    `;
    $("#filas").append(html);
    reordenar();
}

function eliminarFila(fila){
    fila.closest('tr').remove();
    reordenar();
}

function reordenar(){
    let num = 1;
    $('#filas tr').each(function(){
        $(this).find('th').eq(0).text(num);
        num++;
    })
}