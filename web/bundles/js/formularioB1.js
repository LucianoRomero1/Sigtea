$(document).ready(function () {
    //desactivarTabla();
    if ($("input:radio[name='Planta[InicioFecha]']:checked").val() == "NO"){
        $("#inicioActividades").hide(100);   
    }
    //$("#tr").hide();
});

var i = 0;

function verFecha(){
    if ($("input:radio[name='Planta[InicioFecha]']:checked").val() == "SI"){
        $("#inicioActividades").show(200);
        $("#inicioActividades").attr('required',true);
    }else{
        $("#inicioActividades").hide(100);
        $("#inicioActividades").attr('required',false);
    }
}

function mostrarTabla(){
    $("#tabla").show(150);
    $("#buttonDatos").show(150);
    // Agrego una fila.
}

function desactivarTabla(){
    $("#tabla").hide();
    $("#buttonDatos").hide();
    //limpiarDivCompleto();
}

function limpiarDivCompleto(){
    document.getElementById('filas').innerHTML="";
}

function agregarFila(){    
    var previewHTML = $("#filas").html();
    var html = `
        <tr>
            <td>
                <input type="text" class="form-control" name="Domicilio[calle][]">
            </td>
            <td>
                <select class="form-control" id="provincia_`+i+`" name="Domicilio[provincia][]" onChange="parent.provincia('provincia_`+i+`','departamento_`+i+`')">
                    <option value="">SELECCIONE UNA PROVINCIA</option>
                </select>
            </td>
            <td>
                <select class="form-control" id="departamento_`+i+`" name="Domicilio[departamento][]" onChange="parent.localidad('departamento_`+i+`','localidad_`+i+`')">
                    <option value="">SELECCIONE UN DEPARTAMENTO</option>                        
                </select>
            </td>
            <td>
                <select class="form-control" id="localidad_`+i+`'" name="Domicilio[localidad][]" onChange="parent.departamento('localidad_`+i+`','codigoPostal_`+i+`')">
                    <option value="">SELECCIONE UNA LOCALIDAD</option>
                </select>
            </td>
            <td>
                <input type="text" class="form-control" id="codigoPostal_`+i+`" name="Domicilio[cp][]" readonly>
                <a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a>
            </td>
        </tr>
        `
    $("#filas").html(previewHTML + html);
    $('#provincia option').clone().appendTo($('#provincia_'+i));
    i++;
}

function eliminarFila(fila){
    fila.closest('tr').remove();
}