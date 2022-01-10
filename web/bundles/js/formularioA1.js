var i = 0;

function agregarFila(){
    var grupo = $("#grupo");
    $('#filas').append(`
    <div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-row">
                    <p for="grupo">Grupo</p>
                    <select class="form-control grupo" id="grupo_`+i+`" name="grupo[]" required onchange="parent.grupo(grupo_`+i+`,actividad_`+i+`,caucm_`+i+`,ambiental_`+i+`)">
                        <option value="">SELECCIONE UN GRUPO</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-row">
                    <p for="actividad">ACTIVIDAD DE EMPRESA</p>                    
                    <select class="form-control" id="actividad_`+i+`" name="actividadEmpresa[]" required  onchange="parent.actividad(actividad_`+i+`,caucm_`+i+`,ambiental_`+i+`)">                        
                    <option value="">SELECCIONE UNA ACTIVIDAD</option>
                    </select>
                    <div class='spinner form-row'>
                        <div class="three-quarters-loader"></div>
                        <span class='spinner-message'>Cargando actividades...</span>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-4">
                <div class="form-row">
                    <p for="prse">PRINCIPAL / SECUNDARIA</p>
                    <select class="form-control" id="prse_`+i+`" name="prse[]" required>
                        <option value="0">SELECCIONE UN NIVEL</option>
                        <option value="1">Principal</option>
                        <option value="2">Secundaria</option>                        
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-row">
                    <p for="caucm">CÓDIGO CUACM</p>
                    <input type="text" class="form-control" id="caucm_`+i+`" readonly name="caucm[]">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-row">
                    <p for="ambiental">ESTANDAR AMBIENTAL</p>
                    <input type="text" class="form-control" id="ambiental_`+i+`" readonly name="estandarAmbiental[]">
                </div>
                <hr/>
            </div>            
        </div>    
        <a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a>
    </div>
    `);
    $('#grupo option').clone().appendTo($('#grupo_'+i));
    i = i + 1;
}

function eliminarFila(fila){
    fila.closest('div').remove();
}

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