
function agregarFila1(){
    $("#filas1").append(`
    <tr>
        <td><input class ='form-control' type="text" name="DestinoSuelo[verdes][nombre][]"  value="" required></td>
        <td><input class ='form-control' type="number" name="DestinoSuelo[verdes][superficie][]"  value="" required></td>
        <td class = 'media'>
            <input class ='form-control' type="number" name="DestinoSuelo[verdes][porcentaje][]"  value="" required>
            <a onClick="eliminarFila1(this)" class="btn text-danger "><i class="far fa-trash-alt"></i></a>
        </td>
    </tr>`  
    );
    reordenar1();
}
function reordenar1(){
    var num=1;
    $('#filas1 tr').each(function(){
        $(this).find('th').eq(0).text(num);
        num++;
    })
}
function eliminarFila(fila,id = null){    
    if(id!= null){
        $.ajax({       
            url: "eliminarRegistroEntidad",
            method: "POST",
            dataType: 'json',
            data: {
                    id : id,
                    entidad :'DestinoSuelo'
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


function agregarFila2(){
    $("#filas2").append(`
    <tr>
        <td><input class ='form-control' type="text" name="DestinoSuelo[retardadores][nombre][]"  value="" required></td>
        <td class = 'media'>
            <input class ='form-control' type="number" name="DestinoSuelo[retardadores][superficie][]"  value="" required>
            <a onClick="eliminarFila2(this)" class="btn text-danger "><i class="far fa-trash-alt"></i></a>
        </td>
    </tr>`
    );
    reordenar2();
}
function reordenar2(){
    var num=1;
    $('#filas2 tr').each(function(){
        $(this).find('th').eq(0).text(num);
        num++;
    })
}
function eliminarFila2(fila,id = null){    
    if(id!= null){
        $.ajax({       
            url: "eliminarRegistroEntidad",
            method: "POST",
            dataType: 'json',
            data: {
                    id : id,
                    entidad :'DestinoSuelo'
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


function agregarFila3(){
    $("#filas3").append(`
    <tr>
        <td><input class ='form-control' type="text" name="DestinoSuelo[equipamiento][nombre][]"  value="" required></td>
        <td class = 'media'>
            <input class ='form-control' type="number" name="DestinoSuelo[equipamiento][superficie][]"  value="" required>
            <a onClick="eliminarFila3(this)" class="btn text-danger "><i class="far fa-trash-alt"></i></a>
        </td>
    </tr>`
    );
    reordenar3();
}
function reordenar3(){
    var num=1;
    $('#filas3 tr').each(function(){
        $(this).find('th').eq(0).text(num);
        num++;
    })
}
function eliminarFila3(fila,id = null){    
    if(id!= null){
        $.ajax({       
            url: "eliminarRegistroEntidad",
            method: "POST",
            dataType: 'json',
            data: {
                    id : id,
                    entidad :'DestinoSuelo'
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


