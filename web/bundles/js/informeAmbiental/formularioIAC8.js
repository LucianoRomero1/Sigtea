$( document ).ready(function() {

    $("#residuosPeligrosos_si").on("click", function(){
        mostrarTabla("#residuosPeligrosos_si", "#div_residuos_peligrosos")
    })
    $("#residuosPeligrosos_no").on("click", function(){
        mostrarTabla("#residuosPeligrosos_si", "#div_residuos_peligrosos")
    })
    $("#residuosIndustriales_si").on("click", function(){
        mostrarTabla("#residuosIndustriales_si", "#div_residuos_industriales")
    })
    $("#residuosIndustriales_no").on("click", function(){
        mostrarTabla("#residuosIndustriales_si", "#div_residuos_industriales")
    })
    $("#residuosPatologicos_si").on("click", function(){
        mostrarTabla("#residuosPatologicos_si", "#div_residuos_patologicos")
    })
    $("#residuosPatologicos_no").on("click", function(){
        mostrarTabla("#residuosPatologicos_si", "#div_residuos_patologicos")
    })
    $("#otrosResiduos_si").on("click", function(){
        mostrarTabla("#otrosResiduos_si", "#div_otros_residuos")
    })
    $("#otrosResiduos_no").on("click", function(){
        mostrarTabla("#otrosResiduos_si", "#div_otros_residuos")
    })
    $("#efluentesLiquidos_si").on("click", function(){
        mostrarTabla("#efluentesLiquidos_si", "#div_efluentes_liquidos")
    })
    $("#efluentesLiquidos_no").on("click", function(){
        mostrarTabla("#efluentesLiquidos_si", "#div_efluentes_liquidos")
    })
    $("#efluentesSanitarios_si").on("click", function(){
        mostrarTabla("#efluentesSanitarios_si", "#div_efluentes_sanitarios")
    })
    $("#efluentesSanitarios_no").on("click", function(){
        mostrarTabla("#efluentesSanitarios_si", "#div_efluentes_sanitarios")
    })
    $("#emisionesPuntuales_si").on("click", function(){
        mostrarTabla("#emisionesPuntuales_si", "#div_emisiones_puntuales")
    })
    $("#emisionesPuntuales_no").on("click", function(){
        mostrarTabla("#emisionesPuntuales_si", "#div_emisiones_puntuales")
    })
    $("#emisionesDifusas_si").on("click", function(){
        mostrarTabla("#emisionesDifusas_si", "#div_efluentes_difusas")
    })
    $("#emisionesDifusas_no").on("click", function(){
        mostrarTabla("#emisionesDifusas_si", "#div_efluentes_difusas")
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
                    entidad :'Residuo'
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
                    entidad :'Efluente'
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

function eliminarFilaBd3(fila,idTabla, id = null){    
    if(id!= null){
        $.ajax({       
            url: "eliminarRegistroEntidad",
            method: "POST",
            dataType: 'json',
            data: {
                    id : id,
                    entidad :'EmisionGaseosa'
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