$( document ).ready(function() {
    $("#sitiosContaminados_si").on("click", function(){
        mostrarTabla("#sitiosContaminados_si", "#div_sitios_contaminados")
    })
    $("#sitiosContaminados_no").on("click", function(){
        mostrarTabla("#sitiosContaminados_si", "#div_sitios_contaminados")
    })

    
    function mostrarTabla(check, tabla){
        if($(check)[0].checked){
            $(tabla).css("display","block")
        }else{
            $(tabla).css("display","none")
        }
    }

    
});

function eliminarFilaBd(fila,idTabla,id = null){    
    if(id!= null){
        $.ajax({       
            url: "eliminarRegistroEntidad",
            method: "POST",
            dataType: 'json',
            data: {
                    id : id,
                    entidad :'MarcoLegal'
                },
            success: function(data){
                fila.closest('tr').remove();
                reordenar(idTabla);   
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

function eliminarFilaBd2(fila,idTabla,id = null){    
    if(id!= null){
        $.ajax({       
            url: "eliminarRegistroEntidad",
            method: "POST",
            dataType: 'json',
            data: {
                    id : id,
                    entidad :'SitioContaminado'
                },
            success: function(data){
                fila.closest('tr').remove();
                reordenar(idTabla);   
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