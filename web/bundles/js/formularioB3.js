// Javascript
$(document).ready(function () {
    
    if ($("input:radio[name='InmuebleAnexo[opt]']:checked").val() != "SI"){
        desactivarTabla();
    }
    
});

function desactivarTabla(){
    $("#tabla").hide();
    $("#buttonDatos").hide();
    limpiarDivCompleto();
}

function mostrarTabla(){
    $("#tabla").show(150);
    $("#buttonDatos").show(150);
    // Agrego una fila.
    agregarFilaInmuebleAnexo();
}

function limpiarDivCompleto(){
    document.getElementById('filasInmuebleAnexo').innerHTML="";
}

function agregarFilaPartidaInmobiliaria(){
    $("#filasPartidaInmobiliaria").append(`
    <tr>
        <td><input type="text" name="PartidaInmobiliaria[partida]"></td>
        <td><input type="text" name="PartidaInmobiliaria[lat]"></td>
        <td>
            <input type="text" name="PartidaInmobiliaria[long]">
            <a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a>
        </td>
    </tr>  
    `
    );
}

function agregarFilaInmuebleAnexo(){
    $("#filasInmuebleAnexo").append(`
    <tr>
        <td><input type="text" placeholder="Para editar la tabla, seleccione previamente 'Si'" name="InmuebleAnexo[domicilio][]"></td>
        <td>
            <input type="text" name="InmuebleAnexo[actividad][]">
            <a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a>
        </td>
    </tr>
    `);
}
function eliminarFila(fila){
    fila.closest('tr').remove();
}