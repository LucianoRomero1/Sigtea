let contadorTarea = 1;

let contadores = new Array(20).fill(0).map(() => new Array(3).fill(0));

function agregarDivTarea(i = null){

    let previewHtml = $("#divTarea").html();
    if( i != null && i != 1){
        contadorTarea = i;
    }else{
        contadorTarea ++;
    }
    let html = `
        <div id="tarea${contadorTarea}" style="margin-top: 15px;" class="tabla-pers">
            <div class="row">
                <div class="col-md-12">
                    <p>Tarea: <span data-toggle="tooltip" class="text-success" data-placement="right" title="Indicar la tarea a desarrollar">(?)</span></p>
                    <input type="text" value="" class="form-control"  name="EtapaConstructiva[tarea][]"required />
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-md-12">
                    <p>Descripción: <span data-toggle="tooltip" class="text-success" data-placement="right" title="Detallar la tarea indicada en la fila precedente, mencionando, en caso de corresponder, los procedimientos constructivos, tecnologías utilizadas, etc. Límite: 875 caracteres.">(?)</span></p>
                    <textarea maxlength="3500" class="form-control"  name="EtapaConstructiva[descripcion][]" required></textarea>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-md-12">
                    <p>Insumos: <span data-toggle="tooltip" class="text-success" data-placement="right" title="(?) Listar y estimar cuantitativamente los requerimientos de materiales, energía eléctrica, gas, agua, combustibles y mano de obra necesarios para llevar adelante esa tarea. Deberá describirse cualitativamente cada uno, indicar estado físico, si posee características de peligrosidad y detallar las condiciones de almacenamiento (capacidad, tipo de envases, contenedores o tanques, condiciones edilicias y de seguridad) y transporte. Es recomendable indicar la ubicación en plano de la planta. Para el uso de energía deberá indicarse además si será adquirida (debiendo adjuntarse la correspondiente prefactibilidad otorgada por el proveedor) o generación propia (debiendo describirse el método de generación, capacidad, combustible). (Aclaración: deberá corroborarse con lo declarado en el Formulario B de la Resolución N° 403/16). Límite 875 caracteres.">(?)</span></p>
                    <textarea class="form-control" name="EtapaConstructiva[insumo][]" required></textarea>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-12">
                    <p>Residuos: <span data-toggle="tooltip" class="text-success" data-placement="right" title="Especificar y listar cada uno de los residuos que se generarán durante la ejecución de esta tarea. (Aclaración: Deberá corroborarse con lo declarado en el formulario B de la resolución N° 403/16 Ministerio de Medio Ambiente).">(?)</span></p>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">N°</th>
                                <th scope="col">Residuo</th>
                                <th scope="col">Tipo</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody id="tarea${contadorTarea}Residuos">
                            <tr>
                                <th scope="row">${contadores[contadorTarea][0] + 1}</th>
                                <td>
                                    <input type="text" value="" class="form-control"  name="EtapaConstructiva[Residuo][${contadorTarea}][${contadores[contadorTarea][0]}][residuo]" required />
                                </td>
                                <td>
                                    <select name="EtapaConstructiva[Residuo][${contadorTarea}][${contadores[contadorTarea][0]}][tipo]" class="form-control">
                                        <option value="ResiduoPeligroso">Residuo peligroso</option>
                                        <option value="ResiduoNoPeligroso">Residuos no peligrosos industriales o de act. de servicio</option>
                                        <option value="ResiduoSolido">Residuos sólidos urbanos asimilables a estos</option>
                                        <option value="ResiduoPatologicos">Residuos patológicos o provenientes de catering de buques o aeronaves</option>
                                        <option value="Otros">Otros residuos</option>
                                    </select>
                                </td>
                                <td>
                                    <div>
                                        <a class="btn text-danger" onClick="">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                                
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-center">
                        <a class="btn text-primary" onClick="agregarResiduo('tarea${contadorTarea}', ${contadorTarea})">Agregar residuo</a>
                    </div>

                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-md-12">
                    <p>Efluentes: <span data-toggle="tooltip" class="text-success" data-placement="right" title="(?) Especificar y listar cada uno de los efluentes líquidos que se generarán durante la ejecución de esta tarea. (Aclaración: deberá corroborarse con lo declarado en el Formulario B de la Resolución N° 403/16 Ministerio de Medio Ambiente). ">(?)</span></p>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">N°</th>
                                <th scope="col">Efluente</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody id="tarea${contadorTarea}Efluentes">
                            <tr>
                                <th scope="row">${contadores[contadorTarea][1] + 1}</th>
                                <td>
                                    <input type="text" value="" class="form-control" name="EtapaConstructiva[Efluente][${contadorTarea}][${contadores[contadorTarea][1]}][efluente]" required />
                                </td>
                                <td>
                                    <div>
                                        <a class="btn text-danger" onClick="">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                                
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-center">
                        <a class="btn text-primary" onClick="agregarEfluente('tarea${contadorTarea}', ${contadorTarea})">Agregar efluentes</a>
                    </div>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-md-12">
                    <p>Emisiones: <span data-toggle="tooltip" class="text-success" data-placement="right" title="(?) Especificar y listar cada una de las emisiones al aire que se producirán durante la ejecución de esta tarea. (Aclaración: deberá corroborarse con lo declarado en el Formulario B de la Resolución N° 403/16 Ministerio de Medio Ambiente). ">(?)</span></p>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">N°</th>
                                <th scope="col">Emisión</th>
                                <th scope="col">Tipo</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody id="tarea${contadorTarea}Emisiones">
                            <tr>
                                <th scope="row">${contadores[contadorTarea][2] + 1}</th>
                                <td>
                                    <input type="text" value="" class="form-control" name="EtapaConstructiva[Emision][${contadorTarea}][${contadores[contadorTarea][2]}][emision]" required />
                                </td>
                                <td>
                                    <select name="EtapaConstructiva[Emision][${contadorTarea}][${contadores[contadorTarea][2]}][tipo]"  class="form-control">
                                        <option value="Fuente puntual">Fuente puntual</option>
                                        <option value="Emisión difusa">Emisión difusa</option>
                                    </select>
                                </td>
                                <td>
                                    <div>
                                        <a class="btn text-danger" onClick="">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                                
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-center">
                        <a class="btn text-primary" onClick="agregarEmision('tarea${contadorTarea}', ${contadorTarea})">Agregar emisiones</a>
                    </div>
                </div>
                <br/>
            </div>
            <br/>
            <hr/>
            <div class="text-center btn text-danger">
                <a onClick="eliminarDiv('tarea${contadorTarea}')"><i class="fas fa-trash-alt"></i></a>
            </div>
        </div>
    `
    contadorTarea ++;
    $("#divTarea").html( previewHtml + html);
}

function agregarResiduo(id, i){
    let previewHtml = $('#' + id + "Residuos").html();
    contadores[i][0] = $('#' + id + "Residuos").children().length;
    contadores[i][0] ++;
    let html = `
        <tr id="tarea${i}Residuo${contadores[i][0]}">
            <th scope="row">${contadores[i][0]}</th>
            <td>
                <input type="text" value="" class="form-control" name="EtapaConstructiva[Residuo][${i}][${contadores[i][0]}][residuo]" required />
            </td>
            <td>
                <select name="EtapaConstructiva[Residuo][${i}][${contadores[i][0]}][tipo]" class="form-control">
                    <option value="ResiduoPeligroso">Residuo peligroso</option>
                    <option value="ResiduoNoPeligroso">Residuos no peligrosos industriales o de act. de servicio</option>
                    <option value="ResiduoSolido">Residuos sólidos urbanos asimilables a estos</option>
                    <option value="ResiduoPatologicos">Residuos patológicos o provenientes de catering de buques o aeronaves</option>
                    <option value="Otros">Otros residuos</option>
                </select>
            </td>
            <td>
                <div>
                    <a class="btn text-danger" onClick="eliminarDiv('tarea${i}Residuo${contadores[i][0]}')"">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </div>
            </td>
        </tr>
    `
    $("#" + id + "Residuos").html( previewHtml + html);
}

function agregarEfluente(id, i){
    let previewHtml = $('#' + id + "Efluentes").html();
    contadores[i][1] = $('#' + id + "Efluentes").children().length;
    contadores[i][1] ++;
    let html = `
    <tr id="tarea${i}Efluente${contadores[i][1]}">
        <th scope="row">${contadores[i][1]}</th>
        <td>
            <input type="text" value="" class="form-control" name="EtapaConstructiva[Efluente][${i}][${contadores[i][1]}][efluente]" required />
        </td>
        <td>
            <div>
                <a class="btn text-danger" onClick="eliminarDiv('tarea${i}Efluente${contadores[i][1]}')"">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </div>
        </td>
        
    </tr>
    `
    $("#" + id + "Efluentes").html( previewHtml + html);
}

// Se agrega una emisión, recibiendo el ID del div a la tarea que pertenece.
function agregarEmision(id, i){
    let previewHtml = $('#' + id + "Emisiones").html();
    contadores[i][2] = $('#' + id + "Emisiones").children().length;
    contadores[i][2] ++;
    let html = `
    <tr id="tarea${i}Emision${contadores[i][2]}">
        <th scope="row">${contadores[i][2]}</th>
        <td>
            <input type="text" value="" class="form-control" name="EtapaConstructiva[Emision][${i}][${contadores[i][2]}][emision]" required />
        </td>
        <td>
            <select name="EtapaConstructiva[Emision][${i}][${contadores[i][2]}][tipo]"  class="form-control">
                <option value="Fuente puntual">Fuente puntual</option>
                <option value="Emisión difusa">Emisión difusa</option>
            </select>
        </td>
        <td>
            <div>
                <a class="btn text-danger" onClick="eliminarDiv('tarea${i}Emision${contadores[i][2]}')"">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </div>
        </td>
        
    </tr>
    `
    $("#" + id + "Emisiones").html( previewHtml + html);
}

// Se eliminan los divs pasando el ID completo
function eliminarDiv(id){
    var tr = document.getElementById(id);
    if (tr){
        var parent = tr.parentElement;
        parent.removeChild(tr);
    }
}