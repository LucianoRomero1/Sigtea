$( document ).ready(function() {

    $("#aguaSubterranea_si").on("click", function(){
        mostrarTabla("#aguaSubterranea_si", "#divAguaSubterranea")
    })
    $("#aguaSubterranea_no").on("click", function(){
        mostrarTabla("#aguaSubterranea_si", "#divAguaSubterranea")
    })

    

    $("#aguaSuperficial_si").on("click", function(){
        mostrarTabla("#aguaSuperficial_si", "#divAguaSuperficial")
    })
    $("#aguaSuperficial_no").on("click", function(){
        mostrarTabla("#aguaSuperficial_si", "#divAguaSuperficial")
    })

    $("#aguaRedPublica_si").on("click", function(){
        mostrarTabla("#aguaRedPublica_si", "#divAguaRedPublica")
    })
    $("#aguaRedPublica_no").on("click", function(){
        mostrarTabla("#aguaRedPublica_si", "#divAguaRedPublica")
    })

    $("#materiaPrima_si").on("click", function(){
        mostrarTabla("#materiaPrima_si", "#divSuelo")
    })
    $("#materiaPrima_no").on("click", function(){
        mostrarTabla("#materiaPrima_si", "#divSuelo")
    })

    $("#extraccion_si").on("click", function(){
        mostrarTabla("#extraccion_si", "#divExtracion")
        mostrarOrigen("#extraccion_si", "#divOrigen")
    })
    $("#extraccion_no").on("click", function(){
        mostrarTabla("#extraccion_si", "#divExtracion")
        mostrarOrigen("#extraccion_si", "#divOrigen")
    })

    function mostrarTabla(check, tabla){
        if($(check)[0].checked){
            $(tabla).css("display","block")
        }else{
            $(tabla).css("display","none")
        }
    }

    function mostrarOrigen(check, tabla){
        if($(check)[0].checked){
            $(tabla).css("display","none")
        }else{
            $(tabla).css("display","block")
        }
    }

});

function eliminarFilaBd(fila,idTabla,id = null){    
    var i = 0;
    if(id!= null){
        $.ajax({       
            url: "eliminarRegistroEntidad",
            method: "POST",
            dataType: 'json',
            data: {
                    id : id,
                    entidad :'Agua'
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
    var i = 0;
    if(id!= null){
        $.ajax({       
            url: "eliminarRegistroEntidad",
            method: "POST",
            dataType: 'json',
            data: {
                    id : id,
                    entidad :'Suelo'
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
    var i = 0;
    if(id!= null){
        $.ajax({       
            url: "eliminarRegistroEntidad",
            method: "POST",
            dataType: 'json',
            data: {
                    id : id,
                    entidad :'OtroRecurso'
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
