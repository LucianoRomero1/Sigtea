function agregarFila(idTabla){
    let html = $('#' + idTabla + ' tbody tr').html();
    $('#' + idTabla + ' tbody').append(`<tr>` + html + `</tr>`);
    reordenar(idTabla);

}

function eliminarFila(fila, idTabla){

    if($("#" + idTabla +" tbody tr").length != 1){
        fila.closest('tr').remove();
        reordenar(idTabla); 
    }

}

function eliminarFilaBd(fila,id = null){    
    
    if(id!= null){
        $.ajax({       
            url: "eliminarRegistroEntidad",
            method: "POST",
            dataType: 'json',
            data: {
                    id : id,
                    entidad :'Proceso'
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

function eliminarFilaBd2(fila,id = null){    
    
    if(id!= null){
        $.ajax({       
            url: "eliminarRegistroEntidad",
            method: "POST",
            dataType: 'json',
            data: {
                    id : id,
                    entidad :'SustanciaTanque'
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



function reordenar(idTabla){

    let num = 1;
    $('#' + idTabla + ' tbody tr').each(function(){
        $(this).find('th').eq(0).text(num);
        num++;
    })

}