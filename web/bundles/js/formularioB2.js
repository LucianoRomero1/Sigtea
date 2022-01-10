// Javascript
var numeroProducto = 1;
var numeroSubProducto = 1;
var numeroMateriaPrima = 1;
var numeroInsumo = 1;
var habilitar = true;

$(document).ready(function () {
    validarRadios();
});

function validarRadios(item){
    if(item !=0 ){
        mostrarDiv("SustanciaAuxiliar");
        if (habilitar){
            if ($('#filasSustanciaAuxiliar >tr').length == 0){
                agregarFilaSustanciaAuxiliar();
            }
            habilitar = false;
        }
    }else{
        ocultarTabla("SustanciaAuxiliar");
        //vaciarTabla("SustanciaAuxiliar");
        habilitar = true;
    }
    
}

function agregarFilaProducto(){
    $("#filasProducto").append(`
    <tr>
        <td>` + numeroProducto + `<input type="hidden" name="Producto[numero][]"></td>
        <td><input type="text" name="Producto[nombre][]"></td>
        <td>
            <select name="Producto[estado][]">
                <option>Gaseoso</option>
                <option>Líquido</option>
                <option>Semisólido</option>
                <option>Sólido</option>
            </select>
        </td>
        <td><input type="text" name="Producto[produccion][]"></td>
        <td>
            <select name="Producto[unidad][]">
                <option>kg</option>
                <option>lt</option>
                <option>m3</option>
                <option>tn</option>
                <option>unidades</option>
            </select>
        </td>
        <td>
            <input type="text" name="Producto[almacenamiento][]">
            <a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a>
        </td>
    </tr> 
    `
    );
    numeroProducto +=1;
}

function agregarFilaSubProducto(){
    $("#filasSubProducto").append(`
    <tr>
        <td>` + numeroSubProducto + `<input type="hidden" name="SubProducto[numero][]"></td>
        <td><input type="text" name="SubProducto[nombre][]"></td>
        <td>
            <select name="SubProducto[estado][]">
                <option>Gaseoso</option>
                <option>Líquido</option>
                <option>Semisólido</option>
                <option>Sólido</option>
            </select>
        </td>
        <td><input type="text" name="SubProducto[produccion][]"></td>
        <td>
            <select name="SubProducto[unidad][]">
                <option>kg</option>
                <option>lt</option>
                <option>m3</option>
                <option>tn</option>
                <option>unidades</option>
            </select>
        </td>
        <td>
            <input type="text" name="SubProducto[almacenamiento][]">
            <a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a>
        </td>
    </tr>       
    `);
    numeroSubProducto +=1;
}

function agregarFilaMateriaPrima(){
    $("#filasMateriaPrima").append(`
    <tr>
        <td>` + numeroMateriaPrima + `<input type="hidden" name="MateriaPrima[numero][]"></td>
        <td><input type="text" name="MateriaPrima[nombre][]"></td>
        <td>
            <select name="MateriaPrima[estado][]">
                <option>Gaseoso</option>
                <option>Líquido</option>
                <option>Semisólido</option>
                <option>Sólido</option>
            </select>
        </td>
        <td><input type="text" name="MateriaPrima[produccion][]"></td>
        <td>
            <select name="MateriaPrima[unidad][]">
                <option>kg</option>
                <option>lt</option>
                <option>m3</option>
                <option>tn</option>
                <option>unidades</option>
            </select>
        </td>
        <td>
            <input type="text" name="MateriaPrima[almacenamiento][]">
            <a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a>
        </td>
    </tr>   
    `);
    numeroMateriaPrima += 1;
}

function agregarFilaInsumo(){
    $("#filasInsumo").append(`
    <tr>
        <td>` + numeroInsumo + `<input type="hidden" name="Insumo[numero][]"></td>
        <td><input type="text" name="Insumo[nombre][]"></td>
        <td>
            <select name="Insumo[estado][]">
                <option>Gaseoso</option>
                <option>Líquido</option>
                <option>Semisólido</option>
                <option>Sólido</option>
            </select>
        </td>
        <td><input type="text" name="Insumo[produccion][]"></td>
        <td>
            <select name="Insumo[unidad][]">
                <option>kg</option>
                <option>lt</option>
                <option>m3</option>
                <option>tn</option>
                <option>unidades</option>
            </select>
        </td>
        <td>
            <input type="text" name="Insumo[almacenamiento][]">
            <a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a>
        </td>
    </tr>  
    `);
    numeroInsumo += 1;
}

function agregarFilaSustanciaAuxiliar(){
    $("#filasSustanciaAuxiliar").append(`
    <tr>
        <td><input type="text" name="SustanciaAuxiliar[nombre][]"></td>
        <td><input type="text" name="SustanciaAuxiliar[produccion][]"></td>
        <td name="SustanciaAuxiliar[unidad][]">
            <select>
                <option>kg</option>
                <option>lt</option>
                <option>m3</option>
                <option>tn</option>
                <option>unidades</option>
            </select>
        </td>
        <td>
            <input type="text" name="SustanciaAuxiliar[almacenamiento][]">
            <a onClick="eliminarFila(this)" class="btn text-danger"><i class="far fa-trash-alt"></i></a>
        </td>
    </tr>    
    `);
}

function eliminarFila(fila){
    fila.closest('tr').remove();
}

function ocultarTabla(nombreDiv){
    $("#tabla" + nombreDiv).hide(50);
}

function mostrarDiv(nombreDiv){
    $("#tabla" + nombreDiv).show(100);
}