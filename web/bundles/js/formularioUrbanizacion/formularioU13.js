$( document ).ready(function() {
    //Estas 3 funciones son para los archivos del 1 al 13.
    var check = $('.check');
    check.on('click',function(){
        var cuadradoCheck = $(this);
        var i =  $(this)[0].attributes['data-number'].value;
        VarToCheck(i, cuadradoCheck) ;
    })

    //Esta funcion corrobora que check se tocó para asociar sus valores con su check
    function VarToCheck(i, cuadradoCheck){
        for(x=1;x<=i;x++){
            if(x == i){
                var cadena = i.valueOf();
                var file = $('#archivo' + cadena);
                var button = $('#button' + cadena);
                isChecked(file, button, cuadradoCheck);
            }
        }
    }
    
    function isChecked(file, button, cuadradoCheck){
        if(cuadradoCheck.prop('checked') == true){
            file.prop('disabled', false);
            //file.prop('required', true);
            button.css('display','inline');
        }
        else{
            file.prop('disabled', true);
            //file.prop('required', false);
            button.css('display','none');
        }
    }

    //Archivos del 14 al 19
    var facts = $('.factibilidades');
    facts.on('click',function(){
        var cuadradoCheck = $(this);
        var i =  $(this)[0].attributes['data-number'].value;
        CheckDiv(i, cuadradoCheck);
    })

    function CheckDiv(i,cuadradoCheck){
        for(x=1;x<=i;x++){
            if(x == i){
                var cadena = i.valueOf();
                var divArchivo = $('#divArchivo' + cadena);
                var file = $('#archivo' + cadena);
                DivChecked(divArchivo,file, cuadradoCheck);
            }
        }
    }

    function DivChecked(divArchivo,file, cuadradoCheck){
        if(cuadradoCheck.prop('checked') == true){
            divArchivo.css("display", "block");
            //file.prop('required', true);
        }
        else{
            divArchivo.css("display", "none");
           //file.prop('required', false);
        }
    }

    

});


function addFactibilidad(){
    $("#factibilidades").append(`
        <div class="input-group mt-3 divFactibilidad">
            <input type="text" name="Factibilidades[otras][]" class="form-control">
            <div class="input-group-append">
                <span class="input-group-text"><a onclick="deleteFactibilidad(this)" style="cursor:pointer" class="far fa-trash-alt text-danger"></a></span>
            </div>
        </div>`
    );
}

function deleteFactibilidad(div){
    div.closest('.divFactibilidad').remove();
}






    
