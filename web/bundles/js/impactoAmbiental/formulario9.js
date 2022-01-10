function grupo(idGrupo,idActividad,idCaucm,idambiental){
    if($('#'+idGrupo).val()!=null){
        $.ajax({
            beforeSend: function(){
                $('#'+idActividad).prop('disabled',true);
                $('.spinner').attr('style','display:block !important');
            },
            url: "actividad",
            method: "GET",
            dataType: 'json',
            data: {grupoId : $('#'+idGrupo).val()},
            success: function(data){
                if(data.length>0){
                    $('#'+idActividad).prop('disabled',false);
                    $('.spinner').attr('style','display:none !important');
                    $(data).each(function(i){ // indice, valor
                        $('#'+idActividad).append('<option value="' + data[i].id + '" data-cuacm="'+data[i].cuacm+'" data-estandarAmbiental="'+data[i].estandarAmbiental+'">' + data[i].nombreActividad + '</option>');
                    })
                }else{
                    $('#'+idActividad).prop('disabled',false);
                    $('.spinner').attr('style','display:none !important');
                    $('#'+idActividad).empty().append('<option value="">SELECIONE UNA ACTIVIDAD</option>');
                    $('#'+idCaucm).val(" ");
                    $('#'+idambiental).val(" ");
                }
            },
            error: function(data){
                $('#'+idActividad).prop('disabled',false);
                $('.spinner').attr('style','display:none !important');
                alert("Error no se encontro la Actividad");
            },
        });
    }
}

function actividad(idActividad,idCaucm,idambiental){
    $('#'+idCaucm).val($('#'+idActividad).find(':selected').attr('data-cuacm'));
    $('#'+idambiental).val($('#'+idActividad).find(':selected').attr('data-estandarAmbiental'));
}