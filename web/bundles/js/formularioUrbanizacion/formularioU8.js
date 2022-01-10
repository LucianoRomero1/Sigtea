
function agregarFila(){
    $("#filas").append(`
    <tr>
        <th scope="row">{{loop.index}}</th>
        <td><input class="form-control" type="text" name="Coordenadas[partida][]" required ></td>
        <td><input class="form-control" type="text" name="Coordenadas[lat][]" required ></td>
        <td><input class="form-control" type="text" name="Coordenadas[long][]" required ></td>
        <td>
            <a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a>
        </td>
    </tr> `  
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
                    entidad :'PartidaInmobiliaria'
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