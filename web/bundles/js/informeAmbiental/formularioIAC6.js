function eliminarFilaBd(fila,idTabla,id = null){    
    if(id!= null){
        $.ajax({       
            url: "eliminarRegistroEntidad",
            method: "POST",
            dataType: 'json',
            data: {
                    id : id,
                    entidad :'ElectricaAdquirida'
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
                    entidad :'ElectricaPropia'
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

function eliminarFilaBd3(fila,idTabla,id = null){    
    if(id!= null){
        $.ajax({       
            url: "eliminarRegistroEntidad",
            method: "POST",
            dataType: 'json',
            data: {
                    id : id,
                    entidad :'Gas'
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

function eliminarFilaBd4(fila,idTabla, id = null){    
    if(id!= null){
        $.ajax({       
            url: "eliminarRegistroEntidad",
            method: "POST",
            dataType: 'json',
            data: {
                    id : id,
                    entidad :'OtraEnergia'
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