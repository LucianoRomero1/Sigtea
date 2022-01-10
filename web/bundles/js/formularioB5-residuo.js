var contadorResiduoNoPeligroso = 1;

function agregarResiduoNoPeligroso(i = null){
    if (i != null || contadorResiduoNoPeligroso == 1 ){
        contadorResiduoNoPeligroso = i;
    }
    $("#residuosNoPeligrosos").append(`
    <div id="residuoNoPeligroso`+ contadorResiduoNoPeligroso +`">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>                        
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width:20%">RESIDUO</td>
                            <td style="width:80%"><textarea rows="3" cols="100" class="form-control" name="ResiduosSolidos[pendiente][]"></textarea></td>
                        </tr>
                        <tr>
                            <td style="width:20%">CANTIDAD</td>
                            <td style="width:80%">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Valor</label>
                                            <input type="text" class="form-control" name="ResiduosSolidos[cantidad][]">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Unidad</label>
                                            <input type="text" class="form-control" name="ResiduosSolidos[unidad][]">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Período</label>
                                            <input type="text" class="form-control" name="ResiduosSolidos[periodoTiempo][]">
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:20%">PROCESO QUE LO GENERA</td>
                            <td style="width:80%"><textarea class="form-control" rows="3" cols="100" name="ResiduosSolidos[proceso][]"></textarea></td>
                        </tr>
                        <tr>
                            <td style="width:20%">GESTIÓN</td>
                            <td style="width:80%"><textarea rows="3" class="form-control" cols="100" name="ResiduosSolidos[gestion][]"></textarea></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="text-center">
            <a onClick="eliminarDiv('residuoNoPeligroso` + contadorResiduoNoPeligroso +`')" class="btn text-danger"><i class="far fa-trash-alt"></i></a>
        </div>
        
    </div>
    `);
    contadorResiduoNoPeligroso += 1;
    $( "#buttonResiduoNoPeligroso" ).prop( "disabled", false );
}

function eliminarResiduosNoPeligrosos(){

    for (var i=1; i<=contadorResiduoNoPeligroso; i++){
        eliminarDiv("residuoNoPeligroso" + i);
    }
    $( "#buttonResiduoNoPeligroso" ).prop( "disabled", true );
}

// Residuos peligrosos

var contadorResiduoPeligroso = 1;

function agregarResiduoPeligroso(i = null){
    if (i != null || contadorResiduoPeligroso == 1){
        contadorResiduoPeligroso = 1;
    }
    $("#residuosPeligrosos").append(`
    <div id="residuoPeligroso`+ contadorResiduoPeligroso +`">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>                        
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width:20%">RESIDUO</td>
                            <td style="width:80%"><textarea rows="3" cols="100" class="form-control"></textarea></td>
                        </tr>
                        <tr>
                            <td style="width:20%">CANTIDAD</td>
                            <td style="width:80%">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Valor</label>
                                            <input type="text" class="form-control" name="ResiduosPeligrosos[cantidad][]">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Unidad</label>
                                            <input type="text" class="form-control" name="ResiduosPeligrosos[unidad][]">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Período</label>
                                            <input type="text" class="form-control" name="ResiduosPeligrosos[periodoTiempo][]">
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:20%">PROCESO QUE LO GENERA</td>
                            <td style="width:80%"><textarea rows="3" cols="100" class="form-control" name="ResiduosPeligrosos[proceso][]"></textarea></td>
                        </tr>
                        <tr>
                            <td style="width:20%">GESTIÓN</td>
                            <td style="width:80%"><textarea rows="3" cols="100" class="form-control" name="ResiduosPeligrosos[gestion][]"></textarea></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="text-center">
            <a onClick="eliminarDiv('residuoPeligroso` + contadorResiduoPeligroso +`')" class="btn text-danger"><i class="far fa-trash-alt"></i></a>
        </div>
        
    </div>
    `);
    contadorResiduoPeligroso += 1;
    $( "#buttonResiduoPeligroso" ).prop( "disabled", false );
}

function eliminarResiduosPeligrosos(){

    for (var i=1; i<=contadorResiduoPeligroso; i++){
        eliminarDiv("residuoPeligroso" + i);
    }
    $( "#buttonResiduoPeligroso" ).prop( "disabled", true );
}