var i = 2;
function agregarFilaSuelo(){
    $("#filasimpactosuelo").append(`
    <tr>
        <td><textarea name="ImpactoSuelo[descripcion][]" rows="5"></textarea></td>
        <td><textarea name="ImpactoSuelo[proceso][]" rows="5"></textarea></td>
        <td><textarea name="ImpactoSuelo[contaminacionRelevantes][]" rows="5"></textarea></td>
        <td><input class="p-top" name="ImpactoSuelo[PlanoUbicacionPuntosMuestreo][]" type="file" /> </td>
        <td><input class="p-top" name="ImpactoSuelo[ProtocoloMuestreo][]" type="file" /></td>
        <td><a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a></td>
    </tr>
    `
    );
    
}
function agregarFilaAgua(){
    $("#filasimpactoagua").append(`
    <tr>
        <td><textarea name="ImpactoAguaSubterranea[descripcion][]" rows="5"></textarea></td>
        <td><textarea name="ImpactoAguaSubterranea[proceso][]" rows="5"></textarea></td>
        <td><textarea name="ImpactoAguaSubterranea[contaminacionRelevantes][]" rows="5"></textarea></td>
        <td><input class="p-top" name="ImpactoAguaSubterranea[PlanoUbicacionFreatimetrosEscurrimiento][]" type="file" /></td>
        <td><a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a></td>
    </tr>
    `
    );
    
}
function agregarFilaAire(){
    $("#filasimpactoaire").append(`
    <tr>
        <td><textarea name="ImpactoAire[descripcion][]" rows="5"></textarea></td>
        <td><textarea name="ImpactoAire[proceso][]" rows="5"></textarea></td>
        <td><textarea name="ImpactoAire[contaminacionRelevantes][]" rows="5"></textarea></td>
        <td><input class="p-top" name="ImpactoAire[PlanoUbbicacionPuntosMuestreo][]" type="file" /> </td>
        <td><input class="p-top" name="ImpactoAire[ProtocoloMuestreo][]" type="file" /></td>
        <td><a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a></td>
    </tr>
    `
    );
    
}
function agregarFilaCuerpoReceptor(){
    $("#filasimpactocuerporeceptor").append(`
    <tr>
        <td><textarea name="ImpactoCuerpoReceptor[origen][]" rows="5"></textarea></td>
        <td><textarea name="ImpactoCuerpoReceptor[descripcion][]" rows="5"></textarea></td>
        <td><textarea name="ImpactoCuerpoReceptor[caudal][]" rows="5"></textarea></td>
        <td><textarea name="ImpactoCuerpoReceptor[parametroReceptor][]" rows="5"></textarea></td>
        <td><textarea name="ImpactoCuerpoReceptor[cuerpoReceptor][]" rows="5"></textarea></td>
        <td><input class="p-top" name="ImpactoCuerpoReceptor[SistemaTratamiento][]" type="file" /> </td>
        <td><input class="p-top" name="ImpactoCuerpoReceptor[ProtocoloMuestreo][]" type="file" /></td>
        <td><input class="p-top" name="ImpactoCuerpoReceptor[ProtocoloMuestreo][]" type="file" /></td>
        <td><a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a></td>
    </tr>
    `
    );
    
}
function agregarFilaOtro(){
    $("#filasimpactootro").append(`
    <tr>
        <td><textarea name="ImpactoCuerpoReceptor[descripcion][]" rows="5"></textarea></td>
        <td><textarea name="ImpactoCuerpoReceptor[proceso][]" rows="5"></textarea></td>
        <td><textarea name="ImpactoCuerpoReceptor[consecuencia][]" rows="5"></textarea></td>
        <td><input class="p-top" name="ImpactoCuerpoReceptor[PlanoUbicacion][]" type="file" /> </td>
        <td><input class="p-top" name="ImpactoCuerpoReceptor[ProtocoloMuestreo][]" type="file" /></td>
        <td><a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a></td>
    </tr>
    `
    );
    
}

function eliminarFila(fila){
    fila.closest('tr').remove();
}