// Javascript

$(document).ready(function () {
    
    ocultarTablas();
    if ($("input:radio[name='Efluentes[poseeEfluentes]']:checked").val() != "SI"){
        ocultarDiv();
    }else{
        mostrarDiv();
    }
    
});

function ocultarTablas(){

    var emisionGaseosa = "EmisionGaseosa";
    var emisionGaseosaCombustion = "EmisionGaseosaCombustion";
    var emisionGaseosaGases = "EmisionGaseosaGases";
    
    if ($("input:radio[name='EmisionGaseosa[poseeComponenetesNaturales]']:checked").val() != "SI"){
        
        $("#tabla" + emisionGaseosa).hide();
        $("#button" + emisionGaseosa).hide();
    }
    
    if ($("input:radio[name='EmisionGaseosaCombustion[poseeCombustibles]']:checked").val() != "SI"){
        $("#tabla" + emisionGaseosaCombustion).hide();
        $("#button" + emisionGaseosaCombustion).hide();
    }

    if ($("input:radio[name='EmisionGaseosaGases[poseeNoContemplados]']:checked").val() != "SI"){
        $("#tabla" + emisionGaseosaGases).hide();
        $("#button" + emisionGaseosaGases).hide();
    }

}

function ocultarDiv(){
    $("#residuosLiquidos").css("display", "none");
    document.querySelector('#efluenteTemperaturaAmbiente').checked = true;
    document.querySelector('#efluenteNoResiduosPeligrosos').checked = true;
    document.querySelector('#residuoPosee').checked = true;
    document.querySelector('#efluenteVertidos').checked = true;
    
    
}

// GENERICO DE TABLAS
function activarTabla(nombre){
    $("#tabla" + nombre).show(150);
    $("#button" + nombre).show(150);
    
    if (nombre == "EmisionGaseosa"){
        agregarFilaEmisionGaseosa();
    }else if(nombre == "EmisionGaseosaCombustion"){
        agregarFilaEmisionGaseosaCombustion();
    }else if (nombre == "EmisionGaseosaGases"){
        agregarFilaEmisionGaseosaGases();
    }
}

function desactivarTabla(nombre){

    $("#tabla" + nombre).hide(150);
    $("#button" + nombre).hide(150);

    limpiarFilas(nombre);
}

function limpiarFilas(nombre){
    document.getElementById("filas"+ nombre).innerHTML="";
}

// GENERICO DE DIVS

function limpiarDivCompleto(nombre){
    document.getElementById(nombre).innerHTML="";
    $("#button" + nombre ).prop( "disabled", true );
    
}


// FIN GENÉRICO DE TABLAS
function mostrarDiv(){
    $("#residuosLiquidos").css("display", "block");
}

function agregarFilaEmisionGaseosa(){
    $("#filasEmisionGaseosa").append(`
    <tr>
        <td><input type="text" placeholder="Para editar la tabla, seleccione previamente 'Si'" name="EmisionGaseosa[emision][]"><input type="hidden" name="EmisionGaseosa[tipo]" value="no_contemplados"\></td>
        <td><input type="text" name="EmisionGaseosa[proceso][]"></td>
        <td>
            <input type="text" name="EmisionGaseosa[tratamiento][]">
            <a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a>
        </td>
    </tr>
    `
    );
}

function agregarFilaEmisionGaseosaCombustion(){
    $("#filasEmisionGaseosaCombustion").append(`
    <tr>
        <td><input type="text" placeholder="Para editar la tabla, seleccione previamente 'Si'" name="EmisionGaseosaCombustion[emision][]"><input type="hidden" name="EmisionGaseosa[tipo]" value="combustible"\></td>
        <td><input type="text" name="EmisionGaseosaCombustion[proceso][]"></td>
        <td>
            <input type="text" name="EmisionGaseosaCombustion[tratamiento][]">
            <a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a>
        </td>
    </tr>    
    `
    );
}

function agregarFilaEmisionGaseosaGases(){
    $("#filasEmisionGaseosaGases").append(`
    <tr>
        <td><input type="text" class="form-control" name="EmisionGaseosaGases[proceso][]"><input type="hidden" name="EmisionGaseosaGases[tipo]" value="no_contemplados"\></td>
        <td><input type="text" class="form-control" name="EmisionGaseosaGases[componentes][]"></td>
        <td>
            <input type="text" class="form-control" name="EmisionGaseosaGases[tratamiento][]">
            <a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a>
        </td>
    </tr> 
    `);
}

// Funciones para los inputs.

var contadorEfluente = 1;

function agregarEfluente(){
    $("#efluentes").append(`
    <div id="efluente` + contadorEfluente + `" class="row">
        <div class="col-md-12">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>                        
                </thead>
                <tbody>
                    <tr>
                        <td style="width:20%">PROCESO QUE LO GENERA</td>
                        <td style="width:80%"><textarea rows="3" cols="100" name="Efluentes[procesoGenerado][]"></textarea></td>
                    </tr>
                    <tr>
                        <td style="width:20%">COMPONENTE/S RELEVANTE/S</td>
                        <td style="width:80%"><textarea rows="3" cols="100" name="Efluentes[componenteRelevante][]"></textarea></td>
                    </tr>
                    <tr>
                        <td style="width:20%">CANTIDAD</td>
                        <td style="width:80%">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Valor</label>
                                        <input type="text" class="form-control" name="Efluentes[cantidad][]">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Volumen</label>
                                        <select class="form-control" name="Efluentes[volumen][]">
                                            <option>m3</option>
                                            <option>lt</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Unidad de Tiempo</label>
                                        <select class="form-control" name="Efluentes[periodoTiempo][]">
                                            <option>semanal</option>
                                            <option>mensual</option>
                                            <option>diario</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:20%">GESTIÓN (Seleccione al menos una opción)</td>
                        <td style="width:80%">
                            <div class="form-row">
                                <div class="input-group-text">
                                    <input type="radio" aria-label="Checkbox for following text input" name="Efluentes[gestion][]"> Decantación
                                </div>
                                <div class="input-group-text">
                                    <input type="radio" aria-label="Checkbox for following text input" name="Efluentes[gestion][]"> Tratamiento biológico
                                </div>
                                <div class="input-group-text">
                                    <input type="radio" aria-label="Checkbox for following text input" name="Efluentes[gestion][]"> Neutralización
                                </div>
                                <div class="input-group-text">
                                    <input type="radio" aria-label="Checkbox for following text input" name="Efluentes[gestion][]"> Oxidación
                                </div>
                                <div class="input-group-text">
                                    <input type="radio" aria-label="Checkbox for following text input" name="Efluentes[gestion][]"> Ninguno
                                </div>
                                <div class="input-group-text">
                                    <input type="radio" aria-label="Checkbox for following text input" name="Efluentes[gestion][]"> Otro
                                </div>
                            </div>
                        </td>
                        <tr>
                        <td style="width:20%">CUERPO RECEPTOR</td>
                        <td style="width:80%"><textarea rows="3" cols="100" name="Efluentes[receptor][]"></textarea></td>
                    </tr>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="text-center">
            <a onClick="eliminarDiv('efluente` + contadorEfluente +`')" class="btn text-danger"><i class="far fa-trash-alt"></i></a>
        </div>
    </div>
    

    `);
    contadorEfluente +=1;
}

var contadorLiquido = 1;

function agregarLiquido(){
    $("#liquidos").append(`
    <div id="liquido` + contadorLiquido + `">        
        <div class="row">
            <div class="col-md-12">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>                        
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width:20%">PROCESO QUE LO GENERA</td>
                            <td style="width:80%"><textarea rows="3" cols="100" name="Residuo[proceso][]"></textarea></td>
                        </tr>
                        <tr>
                            <td style="width:20%">COMPONENTE/S RELEVANTE/S</td>
                            <td style="width:80%"><textarea rows="3" cols="100" name="Residuo[componente][]"></textarea></td>
                        </tr>
                        <tr>
                            <td style="width:20%">CANTIDAD</td>
                            <td style="width:80%">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Valor</label>
                                            <input type="text" class="form-control" name="Residuo[cantidad][]">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Volumen</label>
                                            <select class="form-control" name="Residuo[volumen][]">
                                                <option>m3</option>
                                                <option>lt</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Unidad de Tiempo</label>
                                            <select class="form-control" name="Residuo[periodoTiempo][]">
                                                <option>semanal</option>
                                                <option>mensual</option>
                                                <option>diario</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:20%">GESTIÓN (Seleccione al menos una opción)</td>
                            <td style="width:80%">
                                <div class="form-row">
                                    <div class="input-group-text">
                                        <input type="radio" aria-label="Checkbox for following text input" name="Residuo[gestion][]"> Decantación
                                    </div>
                                    <div class="input-group-text">
                                        <input type="radio" aria-label="Checkbox for following text input" name="Residuo[gestion][]"> Tratamiento biológico
                                    </div>
                                    <div class="input-group-text">
                                        <input type="radio" aria-label="Checkbox for following text input" name="Residuo[gestion][]"> Neutralización
                                    </div>
                                    <div class="input-group-text">
                                        <input type="radio" aria-label="Checkbox for following text input" name="Residuo[gestion][]"> Oxidación
                                    </div>
                                    <div class="input-group-text">
                                        <input type="radio" aria-label="Checkbox for following text input" name="Residuo[gestion][]"> Ninguno
                                    </div>
                                    <div class="input-group-text">
                                        <input type="radio" aria-label="Checkbox for following text input" name="Residuo[gestion][]"> Otro
                                    </div>
                                </div>
                            </td>
                            <tr>
                            <td style="width:20%">CUERPO RECEPTOR</td>
                            <td style="width:80%"><textarea rows="3" cols="100" name="Residuo[receptor][]"></textarea></td>
                        </tr>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="text-center">
            <a onClick="eliminarDiv('liquido` + contadorLiquido +`')" class="btn text-danger"><i class="far fa-trash-alt"></i></a>
        </div>
    </div>
    `);
    contadorLiquido += 1;
}

var contadorEfluenteVertido = 1;

function agregarEfluenteVertido(){
    $("#efluentesVertidos").append(`
    <div id="efluenteVertido`+ contadorEfluenteVertido +`">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>                        
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width:20%">PROCESO QUE LO GENERA</td>
                            <td style="width:80%"><textarea rows="3" cols="100" name="EfluentesLiquidos[proceso][]"></textarea><input type="hidden" name="Efluentes[tipo]" value="liquidos"\> </td>
                        </tr>
                        <tr>
                            <td style="width:20%">COMPONENTE/S RELEVANTE/S</td>
                            <td style="width:80%"><textarea rows="3" cols="100" name="EfluentesLiquidos[componente][]"></textarea></td>
                        </tr>
                        <tr>
                            <td style="width:20%">CANTIDAD</td>
                            <td style="width:80%">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Valor</label>
                                            <input type="text" class="form-control" name="EfluentesLiquidos[cantidad][]">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Volumen</label>
                                            <select class="form-control" name="EfluentesLiquidos[volumen][]">
                                                <option>m3</option>
                                                <option>lt</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Unidad de Tiempo</label>
                                            <select class="form-control" name="EfluentesLiquidos[periodoTiempo][]">
                                                <option>semanal</option>
                                                <option>mensual</option>
                                                <option>diario</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:20%">GESTIÓN (Seleccione al menos una opción)</td>
                            <td style="width:80%">
                                <div class="form-row">
                                    <div class="input-group-text">
                                        <input type="radio" aria-label="Checkbox for following text input" name="EfluentesLiquidos[gestion][]"> Decantación
                                    </div>
                                    <div class="input-group-text">
                                        <input type="radio" aria-label="Checkbox for following text input" name="EfluentesLiquidos[gestion][]"> Tratamiento biológico
                                    </div>
                                    <div class="input-group-text">
                                        <input type="radio" aria-label="Checkbox for following text input" name="EfluentesLiquidos[gestion][]"> Neutralización
                                    </div>
                                    <div class="input-group-text">
                                        <input type="radio" aria-label="Checkbox for following text input" name="EfluentesLiquidos[gestion][]"> Oxidación
                                    </div>
                                    <div class="input-group-text">
                                        <input type="radio" aria-label="Checkbox for following text input" name="EfluentesLiquidos[gestion][]"> Ninguno
                                    </div>
                                    <div class="input-group-text">
                                        <input type="radio" aria-label="Checkbox for following text input" name="EfluentesLiquidos[gestion][]"> Otro
                                    </div>
                                </div>
                            </td>
                            <tr>
                            <td style="width:20%">CUERPO RECEPTOR</td>
                            <td style="width:80%"><textarea rows="3" name="EfluentesLiquidos[receptor][]" cols="100"></textarea></td>
                        </tr>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="text-center">
            <a onClick="eliminarDiv('efluenteVertido` + contadorEfluenteVertido +`')" class="btn text-danger"><i class="far fa-trash-alt"></i></a>
        </div>
        
    </div>
    `);
    contadorEfluenteVertido += 1;
    $( "#buttonEfluenteVertido" ).prop( "disabled", false );
}

function eliminarEfluentesVertidos(){

    for (var i=1; i<=contadorEfluenteVertido; i++){
        eliminarDiv("efluenteVertido" + i);
    }
    $( "#buttonEfluenteVertido" ).prop( "disabled", true );
}

function eliminarFila(fila){
    fila.closest('tr').remove();
}

function eliminarDiv(id){

    var div = document.getElementById(id);
    if (div){
        var parent = div.parentElement;
        parent.removeChild(div);
    }
    
}