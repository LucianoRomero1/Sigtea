let contador = null;

function agregarFila(i){
    let previewHtml = $("#tablaFactor").html();
    if( contador == null){
        contador = i+1;
    }

    let html = `
        <tr id="factor${contador}">
            <th scope="row">${contador}</th>
            <td>
                <input type="text" class="form-control" name="Factor[factor][]" />
            </td>
            <td>
                <textarea class="form-control" maxlength="180" name="Factor[descripcion][]" required></textarea>
            </td>
            <td>
                <div class="row">
                    <div class="col-md-12">
                        <input id="archivo${contador + 5}" class="p-top" type="file" /> 
                        <a id="button${contador + 5}" onclick="subirArchivo(${contador + 5})"  class="btn btn-info text-light">Subir</a>
                    </div>
                </div>
                <div class="row">
                    <div id="nombreArchivo${contador + 5}" class="col-md-12 p-top">
                        <div id="spinner${contador + 5}" class='spinner form-row'>
                            <div class="three-quarters-loader"></div>
                        </div>
                    </div>
                </div>
            </td>
            <td>
                <a class="btn text-danger" onClick="eliminarFila(${contador})">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </td>
        </tr> 
    `;
    $("#tablaFactor").html(previewHtml + html);
    contador ++;
}

function eliminarFila(i){
    var tr = document.getElementById("factor" + i);
    if (tr){
        var parent = tr.parentElement;
        parent.removeChild(tr);
    }
}