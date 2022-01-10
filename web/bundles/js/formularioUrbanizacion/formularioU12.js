$( document ).ready(function() {
    $('#todos').on('click',function(){
        isChecked();   
    })
});

//Probar la funcion adentro del document.ready
var i = 0;
function isChecked(){
    
    if(i == 0){
        $('.servicios').prop('disabled', true);
        $('.servicios').prop('checked', false);
    }
    if(i == 1){
        $('.servicios').prop('disabled', false);
    }
    i++;
    if(i == 2){
        i = 0;
    }
    
}