var i = 0;

function agregarFilaLiquidos(tipo){
    $("#filas"+tipo).append(`
    <tr>
        <td>
            <select name="Tanque[almacenamientoLiquido][Tipo][]" required class="selectTipo" data-numero=`+i+`>
                <option value="aereo">Tanque Aéreo</option>
                <option value="subterraneo">Tanque Subterráneo</option>
                <option value="otro">Otro</option>
            </select>
            <input tipe="text" name="Tanque[almacenamientoLiquido][tipo][otro][]" id="otro`+i+`" style="display:none;"/>
        </td>
        <td><textarea name="Tanque[almacenamientoLiquido][descripcion][]" cols="50"></textarea></td>
        <td><input type="text" name="Tanque[almacenamientoLiquido][sustancia][]" /></td>
        <td><input type="text" name="Tanque[almacenamientoLiquido][capacidad][]" />
        <a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a></td>        
    </tr>
    `
    );
    i++;
}
function agregarFilaGnc(tipo){
    $("#filas"+tipo).append(`
    <tr>
        <td><input type="text" name="Tanque[almacenamientognc][almacenamiento][]"/></td>
        <td><input type="text" name="Tanque[almacenamientognc][unidad][]" /></td>
        <td><input type="text" name="Tanque[almacenamientognc][capacidad][]" />
        <a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a></td>        
    </tr>
    `
    );
}

function agregarFilaOtro(tipo){
    $("#filas"+tipo).append(`
    <tr>
        <td><input type="text" name="Tanque[almacenamientootro][almacenamiento][]"/></td>
        <td><input type="text" name="Tanque[almacenamientootro][unidad][]" /></td>
        <td><input type="text" name="Tanque[almacenamientootro][capacidad][]" />
        <a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a></td>        
    </tr>
    `
    );
}

function eliminarFila(fila,id = null){
    if(id != null){
        $.ajax({       
            url: "eliminarRegistroEntidad",
            method: "POST",
            dataType: 'json',
            data: {
                    id : id,
                    entidad : 'AlmacenamientoTanque'
                },
            success: function(data){
                fila.closest('tr').remove();    
            },
            error: function(data){            
                alert("Error al borrar el registro");
            },
        });
    }else{
        fila.closest('tr').remove();    
    }  
}