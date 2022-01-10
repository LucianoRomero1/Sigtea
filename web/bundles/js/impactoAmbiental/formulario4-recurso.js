let contador = 1;

function agregarRecurso(i){

    if( i != null){
        contador = i;
    }else{
        contador ++;
    }
    let html = `
    <div id="recurso${contador}" class="tabla-pers">
        <div class="row">
            <div class="col-md-12">
                <p>Recurso: <span data-toggle="tooltip" class="text-success" data-placement="right" title="Límite: 50 caracteres.">(?)</span></p>
                <input type="text" value="" class="form-control" maxlength="50" name="Recurso[recurso][]" required />
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-6">
                <p>Extracción / Capacitación: <span data-toggle="tooltip" class="text-success" data-placement="right" title="(?) Por ejemplo, para la captación de agua subterránea deberá indicarse la cantidad de pozos, su ubicación en plano general de la planta y deberá detallarse las características de los mismos. Para captación de agua superficial deberá indicarse el nombre del cuerpo de agua, su ubicación en plano y características de la toma y conducción. Para la extracción de suelo deberá indicarse y georreferenciarse el sitio de extracción y deberá detallarse la profundidad de extracción. Anexar en papel y en digital, imágenes del plano o fotografías sitio de extracción, su georreferenciación, etc., según corresponda. Indicar el nombre de estos anexos, en la última celda de la tabla. Límite 875 caracteres. ">(?)</span></p>
                <textarea maxlength="875" class="form-control" name="Recurso[extraccion][]" required></textarea>
            </div>
            <div class="col-md-6">
                <p>Tareas / Procesos / Etapas en los que se utiliza: <span data-toggle="tooltip" class="text-success" data-placement="right" title="Indicar todas las tareas o procesos en los que se utiliza ese recurso, utilizando la misma nomenclatura que en los puntos, 4.3 y 4.4.2. Límite: 875 caracteres.">(?)</span></p>
                <textarea maxlength="875" class="form-control" name="Recurso[proceso][]" required></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p>Cantidad / Unidad de tiempo: <span data-toggle="tooltip" class="text-success" data-placement="right" title="Deberán indicarse la cantidad correspondiente a cada tarea o proceso de la fila anterior y sumar el total. Límite: 875 caracteres.">(?)</span></p>
                <textarea maxlength="875" class="form-control" name="Recurso[cantidad][]" required></textarea>
            </div>
            <div class="col-md-6">
                <div class="text-center">
                    <p>Archivo: <span data-toggle="tooltip" class="text-success" data-placement="right" title="Anexar en papel y en digital imagenes / planos / fotografías del sitio de extracción, su georreferenciación, etc. Adjuntar además las solicitudes o autorizaciones que correspondan, por ejemplo, del Ministerio de la Producción por la extracción de suelo.">(?)</span></p>
                    <input class="p-top" name="Almacenamiento" type="file" /> 
                    <a id="" class="btn btn-info text-light">Subir</a>
                </div>
            </div>
        </div>
        <div class="text-center">
            <a class="btn text-danger" onClick="eliminarFila('recurso${contador}')">
                <i class="fas fa-trash-alt"></i>
            </a>
        </div>
    </div>
    <br/>
    
    `

    $("#recursos").append(html);
}

function eliminarFila(id){
    var tr = document.getElementById(id);
    if (tr){
        var parent = tr.parentElement;
        parent.removeChild(tr);
    }
}