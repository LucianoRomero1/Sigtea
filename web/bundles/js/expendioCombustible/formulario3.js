function agregarFila(tipo){
    $("#filas"+tipo).append(`
    <tr>
        <td><input type="number" name="BocaExpendio[`+tipo+`][bocaExpendio][]" min="0" step="1"/></td>
        <td><input type="text" name="BocaExpendio[`+tipo+`][nombreProducto][]" /></td>
        <td><input type="text" name="BocaExpendio[`+tipo+`][caudal][]" /></td>
        <td><textarea name="BocaExpendio[`+tipo+`][observacion][]" placeholder="Observacion" rows="3" cols="45"></textarea>
        <a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a></td>        
    </tr>
    `
    );
    i++;
}

function eliminarFila(fila,id = null){
    if(id!=null){
        $.ajax({       
            url: "eliminarRegistroEntidad",
            method: "POST",
            dataType: 'json',
            data: {
                    id : id,
                    entidad :'BocaExpendio'
                },
            success: function(data){
                fila.closest('tr').remove();    
            },
            error: function(data){            
                alert("Error al borrar el registro");
            },
        });
    }else{
        fila.closest('tr').remove();    
    }  
}