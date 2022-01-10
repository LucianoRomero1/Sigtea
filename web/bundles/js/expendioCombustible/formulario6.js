function agregarFilaAgua(tipo){
    if(tipo == 'aguapublica'){
        $("#filas"+tipo).append(`
        <tr>
            <td><input type="text" name="AguaPublica[nombre][]" /></td>
            <td><input type="text" name="AguaPublica[consumo][]" /></td>
            <td>
                <select name="AguaPublica[unidad][]">
                    <option>litros</option>
                    <option>m3</option>
                </select>
            </td>
            <td>
                <select name="AguaPublica[tiempo][]">
                    <option>minuto</option>
                    <option>hora</option>
                    <option>día</option>
                    <option>mes</option>
                </select>
            </td>
            <a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a></td>        
        </tr>
        `
        );
    }else{
        $("#filas"+tipo).append(`
        <tr>
            <td><input type="number" name="AguaSubterranea[nroPerforacion][]" step="1" min="1"/></td>
            <td><input type="text" name="AguaSubterranea[ubicacion][]" /></td>
            <td><input type="text" name="AguaSubterranea[consumo][]" /></td>
            <td>
                <select name="AguaSubterranea[unidad][]">
                    <option>litros</option>
                    <option>m3</option>
                </select>
            </td>
            <td>
                <select name="AguaSubterranea[tiempo][]">
                    <option>minuto</option>
                    <option>hora</option>
                    <option>día</option>
                    <option>mes</option>
                </select>
            </td>
            <a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a></td>        
        </tr>
        `
        );
    }
    
}
function agregarFilaElectrica(tipo){
    if (tipo == 'electricapublica'){
        $("#filas"+tipo).append(`
        <tr>
            <td><input type="text" name="EnergiaAdquirida[nombre][]" /></td>
            <td><input type="text" name="EnergiaAdquirida[consumo][]" /></td>        
            <a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a></td>                                
        </tr>
        `
        );
    }else{
        $("#filas"+tipo).append(`
        <tr>
            <td><textarea name="OtroRecurso[tipo][]" cols="120" rows="3"></textarea></td>
            <a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a></td>        
        </tr>
        `
        );
    }
    
}

function eliminarFila(fila,id = null,entidad = null){
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