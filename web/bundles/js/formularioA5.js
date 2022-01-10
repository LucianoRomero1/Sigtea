// Javascript

function agregarFila(){
    $("#filas").append(`
    <tr>
        <td><input type="text" name="Persona[razonSocial][]" required ></td>
        <td><input type="number" name="Persona[cuit][]" required max="99999999999" min="10000000000" step="1"></td>
        <td>
            <input type="text" name="Representante[cargo][]" required">
            <a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a>
        </td>
    </tr> `
    );
}

function eliminarFila(fila){
    fila.closest('tr').remove();
}