// Javascript

function agregarFila(){
    $("#filas").append(`
    <tr>
        <td><input type="text" name="Coordenadas[partida][]" required></td>
        <td><input type="text" name="Coordenadas[lat][]" required></td>
        <td><input type="text" name="Coordenadas[long][]" required></td>
        <td>
            <a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a>
        </td>
    </tr>    
`
    );
}

function eliminarFila(fila,id){
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
}