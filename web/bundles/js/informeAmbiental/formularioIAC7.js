var i = 2;
function agregarFilaSuelo(){
    $("#filasimpactosuelo").append(`
    <tr>
        <td><textarea name="ImpactoSuelo[descripcion][]" rows="5"></textarea></td>
        <td><textarea name="ImpactoSuelo[proceso][]" rows="5"></textarea></td>
        <td><textarea name="ImpactoSuelo[contaminacionRelevantes][]" rows="5"></textarea></td>
        <td><input class="p-top" name="ImpactoSuelo[PlanoUbbicacionPuntosMuestreo][]" type="file" /> </td>
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
        <td><textarea name="ImpactoOtro[descripcion][]" rows="5"></textarea></td>
        <td><textarea name="ImpactoOtro[proceso][]" rows="5"></textarea></td>
        <td><textarea name="ImpactoOtro[consecuencia][]" rows="5"></textarea></td>
        <td><input class="p-top" name="ImpactoOtro[PlanoUbicacion][]" type="file" /> </td>
        <td><input class="p-top" name="ImpactoOtro[ProtocoloMuestreo][]" type="file" /></td>
        <td><a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a></td>
    </tr>
    `
    );
    
}

function eliminarFila(fila,id = null){    
    if(id!= null){
        $.ajax({       
            url: "eliminarRegistroEntidad",
            method: "POST",
            dataType: 'json',
            data: {
                    id : id,
                    entidad :'Impacto'
                },
            success: function(data){
                fila.closest('tr').remove();    
                reordenar();
            },
            error: function(data){            
                alert("Error al borrar el registro");
            },
        });
    }else{
        fila.closest('tr').remove();    
        reordenar();
    }  
}

function reordenar(){
    //Lo que hace esto es con la funcion eq(), es partir desde el indice 0, osea la primer fila, y reorganizar los num asignandolos nuevamente
    //el each() es el que me esta recorriendo toda la tabla
    var num=1;
    $('#filas tr').each(function(){
        $(this).find('th').eq(0).text(num);
        num++;
    })
}