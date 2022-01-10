function agregarResiduo(){
    $("#fila").append(`
    <tr>
        <th scope="row">1</th>
        <td><input type="text" class="form-control" name=""  value=""></td>
        <td><input type="text" class="form-control" name=""  value=""></td>
        <td><input type="text" class="form-control" name=""  value=""></td> 
        <td class="media">
            <select class="form-control" name="" id="">
                <option value="Reuso">Reuso</option>
                <option value="Vertedero">Vertedero</option>
                <option value="Almacenamiento">Almacenamiento</option>
            </select>
            <a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a>
        </td>
    </tr>  `  
    );
    reordenar();
}

function reordenar(){
    var num=1;
    $('#fila tr').each(function(){
        $(this).find('th').eq(0).text(num);
        num++;
    })
}

function eliminarFila(fila){
    fila.closest('tr').remove();
    reordenar();
}

function agregarGas(){
    $("#fila2").append(`
    <tr>
        <th scope="row">1</th>
        <td><input type="text" class="form-control" name=""  value=""></td>
        <td><input type="text" class="form-control" name=""  value=""></td>
        <td><input type="text" class="form-control" name=""  value=""></td>
        <td class="media">
            <select class="form-control" name="" id="">
                <option value="Nox">Nox</option>
                <option value="SO2">SO2</option>
            </select>
            <a onClick="eliminarFila2(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a>
        </td>
    </tr>     `  
    );
    reordenar2();
}

function reordenar2(){
    var num=1;
    $('#fila2 tr').each(function(){
        $(this).find('th').eq(0).text(num);
        num++;
    })
}

function eliminarFila2(fila){
    fila.closest('tr').remove();
    reordenar2();
}