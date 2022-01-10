//Formulario 4 y 5
function agregarFila(){
    $("#filas").append(`
    <tr>
        <th scope="row"></th>
        <td><input type="text" class="form-control" name="Persona[razonSocial][]" required value=""></td>
        <td><input type="number" class="form-control" name="Persona[cuit][]" required value="" max="99999999999" min="10000000000" step="1"></td>
        <td class="media">
            <input type="text" class="form-control" name="Representante[cargo][]" required value="">
            <a onClick="eliminarFila(this)" class="btn text-danger mt-2"><i class="far fa-trash-alt"></i></a>
        </td>
    </tr>   `  
    );
    reordenar();
}


function eliminarFila(fila,id = null){    
    if(id!= null){
        $.ajax({       
            url: "eliminarRegistroEntidad",
            method: "POST",
            dataType: 'json',
            data: {
                    id : id,
                    entidad :'Representante'
                },
            success: function(data){
                fila.closest('tr').remove();    
                reordenar();
            },
            error: function(data){            
                alert("Error al borrar el registro");
            },
        });
    }else{
        fila.closest('tr').remove();    
        reordenar();
    }  
}

function reordenar(){
    //Lo que hace esto es con la funcion eq(), es partir desde el indice 0, osea la primer fila, y reorganizar los num asignandolos nuevamente
    //el each() es el que me esta recorriendo toda la tabla
    var num=1;
    $('#filas tr').each(function(){
        $(this).find('th').eq(0).text(num);
        num++;
    })
}

