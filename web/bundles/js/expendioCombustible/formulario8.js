var impactoSuelo = 1;
var impactoAgua = 1;
var impactoAire = 1;
var impactoCuerpoReceptor = 1;
var impactoOtro = 1;
var impactoMitigacionSuelo = 1;
var impactoMitigacionAgua = 1;
var impactoMitigacionAire = 1;
var impactoMitigacionCuerpoReceptor = 1;
var impactoMitigacionOtro = 1;

function eliminarFila(fila,contador,id = null, entidad = null){
    switch(contador){
        case 'ImpactoSuelo':
            impactoSuelo--;
            break;
        case 'ImpactoAguaSubterranea':
            impactoAgua--;
            break;
        case 'ImpactoCuerpoReceptor':
            impactoCuerpoReceptor--;
            break;
        case 'ImpactoOtro':
            impactoOtro--;
            break;
        case 'ImpactoAire':
            impactoAire--;
            break;
        case 'MitigacionSuelo':
            impactoMitigacionSuelo--;
            break;
        case 'MitigacionAgua':
            impactoMitigacionAgua--;
            break;
        case 'MitigacionAire':
            impactoMitigacionAire--;
            break;
        case 'MitigacionCuerpoReceptor':
            impactoMitigacionCuerpoReceptor--;
            break;
        case 'MitigacionOtro':
            impactoMitigacionOtro--;
            break;
        default:
            break;
    }
    if(id==null){
        $.ajax({       
            url: "eliminarRegistroEntidad",
            method: "POST",
            dataType: 'json',
            data: {
                    id : id,
                    entidad : entidad
                },
            success: function(data){
                fila.closest('tr').remove();    
            },
            error: function(data){            
                alert("Error al borrar el registro");
            },
        })
    }else{
        fila.closest('tr').remove();    
    } 
}

function eliminarTabla(table,id = null,entidad = null){
    if(id==null){
        $.ajax({       
            url: "eliminarRegistroEntidad",
            method: "POST",
            dataType: 'json',
            data: {
                    id : id,
                    entidad : entidad
                },
            success: function(data){
                table.closet('table > tbody > tr').remove();
            },
            error: function(data){            
                alert("Error al borrar el registro");
            },
        })
    }else{
        table.closet('table > tbody > tr').remove();
    } 
}

function agregarFila(tipo){
    var contador =0;
    switch(tipo){
        case 'ImpactoSuelo':
            contador = impactoSuelo;
            impactoSuelo++;
            break;
        case 'ImpactoAguaSubterranea':
            contador = impactoAgua;
            impactoAgua++;
            break;
        case 'ImpactoAire':
            contador = impactoAire;
            impactoAire++;
            break;
        case 'ImpactoCuerpoReceptor':
            contador = impactoCuerpoReceptor;
            impactoCuerpoReceptor++;
            break;
        case 'ImpactoOtro':
            contador = impactoOtro;
            impactoOtro++;
            break;        
        case 'MitigacionSuelo':
            contador = impactoMitigacionSuelo;
            impactoMitigacionSuelo++;
            break;
        case 'MitigacionAgua':
            contador = impactoMitigacionAgua;
            impactoMitigacionAgua++;
            break;
        case 'MitigacionAire':
            contador = impactoMitigacionAire;
            impactoMitigacionAire++;
            break;
        case 'MitigacionCuerpoReceptor':
            contador = impactoMitigacionCuerpoReceptor;
            impactoMitigacionCuerpoReceptor++;
            break;
        case 'MitigacionOtro':
            contador = impactoMitigacionOtro;
            impactoMitigacionOtro++;
            break;
    }
    var html=`
    <tr>
        <td><textarea name="`+tipo+`[]" cols="120" rows='1' required></textarea></td>`;
        if(contador>1){
            html +=`<td><a onClick="eliminarFila(this,'`+tipo+`')" class="btn text-danger"><i class="far fa-trash-alt"></i></a></td>`;
        }
        html+=`</tr>`;
    $("#filas"+tipo).append(html);
}

var tiposPeligrosos =0;
function agregarFilaResiduosPeligroso(){
    $('#filasresiduosPeligrosos').append(
        ` <tr>
        <td>
            <select name="Residuos[Peligrosos][tipo][]" class="custom-select" id="tiposPeligrosos_`+tiposPeligrosos+`"></select>
        </td>
        <td><input type="text" name="Residuos[Peligrosos][destino][]" ></td>
        <td><input type="text" name="Residuos[Peligrosos][volumen][]" ></td>
        <td><input type="text" name="Residuos[Peligrosos][empresa][]" ></td>
        <td><a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a></td>
    </tr>`);
    $('#tiposPeligrosos option').clone().appendTo($('#tiposPeligrosos_'+tiposPeligrosos));  
    tiposPeligrosos++;      
}

var tiposNoPeligrosos =0;
function agregarFilaResiduosNoPeligroso(){
    $('#filasresiduosNoPeligrosos').append(
        ` <tr>
        <td>
            <select name="Residuos[NoPeligrosos][tipo][]" class="custom-select" id="tiposNoPeligrosos_`+tiposNoPeligrosos+`"></select>
        </td>
        <td><input type="text" name="Residuos[NoPeligrosos][destino][]" ></td>
        <td><input type="text" name="Residuos[NoPeligrosos][volumen][]" ></td>
        <td><input type="text" name="Residuos[NoPeligrosos][empresa][]" ></td>
        <td><a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a></td>
    </tr>`);
    $('#tiposNoPeligrosos option').clone().appendTo($('#tiposNoPeligrosos_'+tiposNoPeligrosos));        
    tiposNoPeligrosos++;
}

function agregarFilaLiquidosDesagote(){
    $('#filasLiquidisDesagote').append(
        `<tr>
        <td><input type="text" name="Liquidos[Desagote][numero][]"></td>
        <td><input type="text" name="Liquidos[Desagote][empresa][]" ></td>
        <td><input type="text" name="Liquidos[Desagote][destino][]" ></td>
        <td><a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a></td>
    </tr>`);
}

var j = 0;
function agregarFilaLiquidosResiduales(){
    $('#filasLiquidosResiduales').append(`
    <div class="row">
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
                <td style="width:80%"><textarea class="form-control" rows="3" cols="100" name="LiquidosResiduales[procesoGenerado][]"></textarea></td>
            </tr>
            <tr>
                <td style="width:20%">COMPONENTE/S RELEVANTE/S</td>
                <td style="width:80%"><textarea class="form-control" rows="3" cols="100" name="LiquidosResiduales[componenteRelevante][]"></textarea></td>
            </tr>
            <tr>
                <td style="width:20%">CAUDAL</td>
                <td style="width:80%">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Valor</label>
                                <input class="form-control" value="" type="text" class="form-control" name="LiquidosResiduales[cantidad][]">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Volumen</label>
                                <select class="form-control" name="LiquidosResiduales[volumen][]">
                                    <option>m3</option>
                                    <option>lt</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Unidad de Tiempo</label>
                                <select class="form-control" name="LiquidosResiduales[periodoTiempo][]">
                                    <option >semanal</option>
                                    <option >mensual</option>
                                    <option >diario</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="width:20%">Tratamiento (Seleccione al menos una opción)</td>
                <td style="width:80%">
                    <div class="form-row">
                        <div class="input-group-text">
                            <input type="radio" aria-label="Checkbox for following text input" value="Decantación" name="LiquidosResiduales[gestion][]"> Decantación
                        </div>
                        <div class="input-group-text">
                            <input type="radio" aria-label="Checkbox for following text input" value="Tratamiento biológico" name="LiquidosResiduales[gestion][]"> Tratamiento biológico
                        </div>
                        <div class="input-group-text">
                            <input type="radio" aria-label="Checkbox for following text input" value="Neutralización" name="LiquidosResiduales[gestion][]"> Neutralización
                        </div>
                        <div class="input-group-text">
                            <input type="radio" aria-label="Checkbox for following text input" value="Oxidación" name="LiquidosResiduales[gestion][]"> Oxidación
                        </div>
                        <div class="input-group-text">
                            <input type="radio"  aria-label="Checkbox for following text input" value="Reducción" name="LiquidosResiduales[gestion][]"> Reducción
                        </div>
                        <div class="input-group-text">
                            <input type="text" name="LiquidosResiduales[gestion][]" placeholder="Otro">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="width:20%">DESTINO</td>
                <td style="width:80%">
                    <select name="LiquidosResiduales[destino][]" class="selectDestinoLiquidosResiduales" data-otro='`+j+`'>
                        <option value="Colectora cloacal">Colectora cloacal</option>
                        <option value="Conducto pluvial abierto">Conducto pluvial abierto</option>
                        <option value="Conducto pluvial cerrado">Conducto pluvial cerrado</option>
                        <option value="Cuenca elemental cerrada">Cuenca elemental cerrada</option>
                        <option value="Curso de agua superficial">Curso de agua superficial</option>
                        <option value="Cursos de agua no permanente">Cursos de agua no permanente</option>
                        <option value="Pozos o campos de drenaje">Pozos o campos de drenaje</option>
                    </select>
                </td>
            </tr>            
            <tr><td><a onClick="eliminarTabla(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a></td></tr>
        </tbody>
    </table>
</div>
    `);
    j++;
}
var e = 0;
function agregarFilaEmisionGaseosa(){
    $('#emisiongaseosa').append(`
    <div class="row">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>                        
            </thead>
            <tbody>
                <tr>
                    <td style="width:20%">Operación que lo genera</td>
                    <td style="width:80%"><textarea class="form-control" rows="3" cols="100" name="Emision[Gaseosa][procesoGenerado][]"></textarea></td>
                </tr>
                <tr>
                    <td style="width:20%">Componentes relevantes</td>
                    <td style="width:80%"><textarea class="form-control" rows="3" cols="100" name="Emision[Gaseosa][componenteRelevante][]"></textarea></td>
                </tr>                            
                <tr>
                    <td style="width:20%">Tratamiento (Seleccione al menos una opción)</td>
                    <td style="width:80%">
                        
                        <div class="form-row">
                            <div class="input-group-text">
                                <input type="radio"  aria-label="Checkbox for following text input" value="Adsorción" name="Emision[Gaseosa][gestion][]"> Adsorción
                            </div>
                            <div class="input-group-text">
                                <input type="radio"  aria-label="Checkbox for following text input" value="Filtro (carbón activado)" name="Emision[Gaseosa][gestion][]"> Filtro (carbón activado)
                            </div>
                            <div class="input-group-text">
                                <input type="radio" aria-label="Checkbox for following text input" value="Scrubber" name="Emision[Gaseosa][gestion][]"> Scrubber
                            </div>
                            <div class="input-group-text">
                            <input type="text" name="Emision[Gaseosa][gestion][]" placeholder="Otro">
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="width:20%">DESTINO</td>
                    <td style="width:80%">
                        <select name="Emision[Gaseosa][destino][]" class="selectDestinoEmision" data-otro='`+e+`'>
                            <option value="Colectora cloacal">Colectora cloacal</option>
                            <option value="Conducto pluvial abierto">Conducto pluvial abierto</option>
                            <option value="Conducto pluvial cerrado">Conducto pluvial cerrado</option>
                            <option value="Cuenca elemental cerrada">Cuenca elemental cerrada</option>
                            <option value="Curso de agua superficial">Curso de agua superficial</option>
                            <option value="Cursos de agua no permanente">Cursos de agua no permanente</option>
                            <option value="Pozos o campos de drenaje">Pozos o campos de drenaje</option>
                        </select>
                    </td>
                </tr>                
                <tr><td><a onClick="eliminarTabla(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a></td></tr>
            </tbody>
        </table>
    </div>
    `);
    e++;
}

function agregarFilaRuido(){
    $('#filasotro').append(`
        <tr>
            <td><input type="text" name="Ruido[operacion][]" ></td>
            <td><input type="text" name="Ruido[tratamiento][]" ></td>
            <td><input type="text" name="Ruido[observacion][]" ></td>
            <td><a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a></td>
        </tr>
    `);
}