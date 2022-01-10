let contadorProceso = 1;

let contadoresProceso = new Array(20).fill(0).map(() => new Array(3).fill(0));

function agregarDivProceso(i = null){

    let previewHtml = $("#divProceso").html();
    if( i != null && i != 1){
        contadorProceso = i;
    }else{
        contadorProceso ++;
    }

    let html = `
        <div id="proceso${contadorProceso}" style="margin-top: 15px;" class="tabla-pers">
            <div class="row">
                <div class="col-md-12">
                    <p>Nombre del proceso: <span data-toggle="tooltip" class="text-success" data-placement="right" title="Indicar el nombre principal con el cual se identifica al proceso. (Mantener la misma nomenclatura).">(?)</span></p>
                    <input type="text" value="" class="form-control" name="EtapaOperativa[proceso][]" required />
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-md-12">
                    <p>Descripción: <span data-toggle="tooltip" class="text-success" data-placement="right" title="(?) Describir concisamente el proceso completo indicado en la fila precedente. Detallar las operaciones que se desarrollan en el mismo. Mencionar, en caso de corresponder, las tecnologías utilizadas, medidas de seguridad, etc. Límite 2600 caracteres. ">(?)</span></p>
                    <textarea class="form-control" maxlength="2600" name="EtapaOperativa[descripcion][]" required></textarea>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-md-12">
                    <p>Materias primas, Insumos, sustancias auxiliares, fluídos, agua: <span data-toggle="tooltip" data-placement="right" title="(?) Listar y estimar cuantitativamente (en la unidad que corresponda), los requerimientos de materias primas e insumos que se utilizan en el proceso, o en cada operación del mismo, como así también las sustancias auxiliares, servicios y mano de obra necesarios para llevar adelante ese proceso. Deberá identificarse como mínimo: sustancia, composición, estado físico, características de peligrosidad, capacidad y condiciones de almacenamiento, medidas de seguridad y consumo estimado. Para el uso de energía deberá indicarse además si será adquirida (debiendo adjuntarse la correspondiente prefactibilidad otorgada por el proveedor) o generación propia (debiendo describirse el método de generación, capacidad, combustible) y para el uso, su abastecimiento: público (agua de red) o propio (fuentes: superficial, subterránea, otras (especificar). (Aclaración: deberá corroborarse con lo declarado en el Formulario B de la Resolución N° 403/16). Límite 2600 caracteres. ">(?)</span></p>
                    <textarea class="form-control" maxlength="2600" name="EtapaOperativa[materia][]" required></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p>Productos y subproductos:<span data-toggle="tooltip" class="text-success" data-placement="right" title="(?) Listar los productos y subproductos que se obtienen en el proceso, o en cada operación del mismo. Deberán detallarse las características de cada producto, estado físico e indicarse también las condiciones de almacenamiento (capacidad, tipo de envases, contenedores o tanques, condiciones edilicias y de seguridad) y transporte y, en caso de corresponder, indicar la ubicación en plano de la planta. (Aclaración: deberá corroborarse con lo declarado en el Formulario B de la Resolución N° 403/16). Límite 875 caracteres.">(?)</span></p>
                    <textarea class="form-control" maxlength="875" name="EtapaOperativa[producto][]" required></textarea>
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
                        <tbody id="proceso${contadorProceso}Residuos">
                            <tr>
                                <th scope="row">${contadoresProceso[contadorProceso][0] + 1}</th>
                                <td>
                                    <input type="text" value="" class="form-control"  name="EtapaOperativa[Residuo][${contadorProceso}][${contadoresProceso[contadorProceso][0]}][residuo]" required />
                                </td>
                                <td>
                                    <select name="EtapaOperativa[Residuo][${contadorProceso}][${contadoresProceso[contadorProceso][0]}][tipo]" class="form-control">
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
                        <a class="btn text-primary" onClick="agregarResiduoOperativo('proceso${contadorProceso}', ${contadorProceso})">Agregar residuo</a>
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
                        <tbody id="proceso${contadorProceso}Efluentes">
                            <tr>
                                <th scope="row">${contadoresProceso[contadorProceso][1] + 1}</th>
                                <td>
                                    <input type="text" value="" class="form-control" name="EtapaOperativa[Efluente][${contadorProceso}][${contadoresProceso[contadorProceso][1]}][efluente]" required />
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
                        <a class="btn text-primary" onClick="agregarEfluenteOperativo('proceso${contadorProceso}', ${contadorProceso})">Agregar efluentes</a>
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
                        <tbody id="proceso${contadorProceso}Emisiones">
                            <tr>
                                <th scope="row">${contadoresProceso[contadorProceso][2] + 1}</th>
                                <td>
                                    <input type="text" value="" class="form-control" name="EtapaOperativa[Emision][${contadorProceso}][${contadoresProceso[contadorProceso][2]}][emision]" required />
                                </td>
                                <td>
                                    <select name="EtapaOperativa[Emision][${contadorProceso}][${contadoresProceso[contadorProceso][2]}][tipo]"  class="form-control">
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
                        <a class="btn text-primary" onClick="agregarEmisionOperativa('proceso${contadorProceso}', ${contadorProceso})">Agregar emisiones</a>
                    </div>
                </div>
                <br/>
            </div>
            <br/>
            <hr/>
            <div class="text-center btn text-danger">
                <a onClick="eliminarDiv('proceso${contadorProceso}')"><i class="fas fa-trash-alt"></i></a>
            </div>
        </div>
    `
    contadorProceso ++;
    $("#divProceso").html( previewHtml + html);
}

function agregarResiduoOperativo(id, i){
    let previewHtml = $('#' + id + "Residuos").html();

    contadoresProceso[i][0] = $('#' + id + "Residuos").children().length;
    console.log($('#' + id + "Residuos").children().length);
    contadoresProceso[i][0] ++;
    let html = `
        <tr id="proceso${i}Residuo${contadoresProceso[i][0]}">
            <th scope="row">${contadoresProceso[i][0]}</th>
            <td>
                <input type="text" value="" class="form-control" name="EtapaOperativa[Residuo][${i}][${contadoresProceso[i][0]}][residuo]" required />
            </td>
            <td>
                <select name="EtapaOperativa[Residuo][${i}][${contadoresProceso[i][0]}][tipo]" class="form-control">
                    <option value="ResiduoPeligroso">Residuo peligroso</option>
                    <option value="ResiduoNoPeligroso">Residuos no peligrosos industriales o de act. de servicio</option>
                    <option value="ResiduoSolido">Residuos sólidos urbanos asimilables a estos</option>
                    <option value="ResiduoPatologicos">Residuos patológicos o provenientes de catering de buques o aeronaves</option>
                    <option value="Otros">Otros residuos</option>
                </select>
            </td>
            <td>
                <div>
                    <a class="btn text-danger" onClick="eliminarDiv('proceso${i}Residuo${contadoresProceso[i][0]}')"">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </div>
            </td>
        </tr>
    `
    $("#" + id + "Residuos").html( previewHtml + html);
}

function agregarEfluenteOperativo(id, i){
    let previewHtml = $('#' + id + "Efluentes").html();
    contadoresProceso[i][1] = $('#' + id + "Efluentes").children().length;
    contadoresProceso[i][1] ++;
    let html = `
    <tr id="proceso${i}Efluente${contadoresProceso[i][1]}">
        <th scope="row">${contadoresProceso[i][1]}</th>
        <td>
            <input type="text" value="" class="form-control" name="EtapaOperativa[Efluente][${i}][${contadoresProceso[i][1]}][efluente]" required />
        </td>
        <td>
            <div>
                <a class="btn text-danger" onClick="eliminarDiv('proceso${i}Efluente${contadoresProceso[i][1]}')"">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </div>
        </td>
        
    </tr>
    `
    $("#" + id + "Efluentes").html( previewHtml + html);
}

// Se agrega una emisión, recibiendo el ID del div a la tarea que pertenece.
function agregarEmisionOperativa(id, i){
    let previewHtml = $('#' + id + "Emisiones").html();
    contadoresProceso[i][2] = $('#' + id + "Emisiones").children().length;
    contadoresProceso[i][2] ++;
    let html = `
    <tr id="proceso${i}Emision${contadoresProceso[i][2]}">
        <th scope="row">${contadoresProceso[i][2]}</th>
        <td>
            <input type="text" value="" class="form-control" name="EtapaOperativa[Emision][${i}][${contadoresProceso[i][2]}][emision]" required />
        </td>
        <td>
            <select name="EtapaOperativa[Emision][${i}][${contadoresProceso[i][2]}][tipo]"  class="form-control">
                <option value="Fuente puntual">Fuente puntual</option>
                <option value="Emisión difusa">Emisión difusa</option>
            </select>
        </td>
        <td>
            <div>
                <a class="btn text-danger" onClick="eliminarDiv('proceso${i}Emision${contadoresProceso[i][2]}')"">
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