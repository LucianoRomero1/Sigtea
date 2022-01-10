function provincia(idProvincia, idLocalidad, idAdicional){
    $.ajax({
        url: 'departamento',
        method: "GET",
        dataType: 'json',
        data: {provinciaId : $('#'+idProvincia).val()},
        success: function(data){                
            $("#"+idLocalidad).empty().append('<option value="">SELECIONE UN DEPARTAMENTO</option>');
            if(data.length > 0){
                $(data).each(function(i){ // indice, valor                    
                    $("#"+idLocalidad).append('<option value="' + data[i].id + '">' + data[i].nombre + '</option>')
                });
            }
        },
        error: function(data){
            alert("Error no se encontro los departamentos");
        },
    });
}
function localidad(idLocalidad,idDepartamento){
    $.ajax({
        url: 'localidad',
        method: "GET",
        dataType: 'json',
        data: {departamentoId : $("#"+idLocalidad).val()},
        success: function(data){                
            $("#"+idDepartamento).empty().append('<option value="">SELECIONE UNA LOCALIDAD</option>');
            if(data.length > 0){
                $(data).each(function(i){ // indice, valor
                    $("#"+idDepartamento).append('<option value="' + data[i].id + '" data-codigoPostal="'+ data[i].codigoPostal +'">' + data[i].nombre + '</option>');
                });
            }
        },
        error: function(data){
            alert("Error no se encontro los departamentos");
        },
    });
}
function departamento(idDepartamento,idCodigoPostal){
    $("#"+idCodigoPostal).val($("#"+idDepartamento).find(':selected').attr('data-codigoPostal'));
}

