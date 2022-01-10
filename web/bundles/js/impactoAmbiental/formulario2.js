
let contador = null;

function agregarFila(i){
    let previewHtml = $("#tablaPeritos").html();
    let personas = $("#personas").html();
    if( contador == null){
        contador = i+1;
    }

    let html = `
        <tr id="persona${contador}">
            <th scope="row">${contador}</th>
            <td>
                <select class="form-control" name="Perito[persona][]">
                    ${personas}
                </select>
            </td>
            <td>
                <input type="text" class="form-control" name="Perito[profesion][]" required />
            </td>
            <td>
                <input type="number" class="form-control" name="Perito[firma][]" required />
            </td>
            <td>
                <a class="btn text-danger" onClick="eliminarFila(${contador})">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </td>
        </tr> 
    `;
    $("#tablaPeritos").html(previewHtml + html);
    contador ++;
}

function eliminarFila(i){
    var tr = document.getElementById("persona" + i);
    if (tr){
        var parent = tr.parentElement;
        parent.removeChild(tr);
    }
}