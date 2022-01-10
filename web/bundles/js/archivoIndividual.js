/* Ejemplo de cómo configurar en el HTML

    <div class="row">
        <div class="col-md-6">
            <input id="archivo1" class="p-top" type="file" /> 
            <a id="button1" onclick="subirArchivo(1)"  class="btn btn-info text-light">Subir</a>
        </div>
        <div id="nombreArchivo1" class="col-md-6 p-top">
            <div id="spinner1" class='spinner form-row'>
                <div class="three-quarters-loader"></div>
            </div>
        </div>
    </div> 

    <div class="row">
        <div class="col-md-6">
            <input id="archivo1" class="p-top" type="file" /> 
            <a id="button1" onclick="subirArchivo(1,3)"  class="btn btn-info text-light">Subir</a>
        </div>
        <div id="nombreArchivo1" class="col-md-6 p-top">
            {% if Storage is defined %}
                <div>
                    <h6 class="text-success"><i class='fas fa-check'></i> {{Storage.nombre}} </h6>
                </div>
            {% endif %}
            <div id="spinner1" class='spinner form-row'>
                <div class="three-quarters-loader"></div>
            </div>
        </div>
    </div> 

*/

function subirArchivo(id, inciso){
    let fd = new FormData();
    let file = $('#archivo' + id )[0].files[0];
    fd.append('files[]' , file);
    fd.append('inciso' , inciso);
    fd.append('tramite' , $("input[name='idTramite']").val());

    if (file != undefined){
        $('#spinner' + id).attr('style','display:block !important');
        $('#button' + id).hide(100);
        $.ajax
        ({
            method: 'POST',
            url: 'archivo',
            data: fd,
            processData: false,
            contentType: false,
            
            success: function (res)
            {
                if(res.success){
                    alert(res.res);
                    $('#nombreArchivo' + id).html(`
                        <h6 class="text-success"><i class='fas fa-check'></i> ${file.name} </h6>
                    `);
                    $('#button' + id).show(100);
                }else{
                    $('#nombreArchivo' + id).html(`
                        <h6 class="text-danger"><i class='far fa-times-circle text-danger'></i> ERROR - ${file.name} </h6>
                    `);
                    alert(res.res);
                    $('#button' + id).show(100);
                }
            }

        });
    }
    
}