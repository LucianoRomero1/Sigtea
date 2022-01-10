$(document).ready(function () {

});

$("#formArchivos").on("submit", function(e){

    $("#success").html(""); 
    $("#spinner").show();

    e.preventDefault();
    var form = $('#formArchivos')[0];
    var fd = new FormData();
    var string = "";

    for (var i = 0; i<=6; i++){
        
        if (form[i].files == undefined){
            break;
        }
        string += "<h6>" + form[i].getAttribute('name') + ": " + "</h6>";

        if (form[i].files.length != 0){

            string += "<h6 class='text-success'>" + form[i].files[0].name + " <i class='fas fa-check'></i></h6>"
            var files = form[i].files;        
            
            fd.append('files[]' ,files[0]);
        }else{
            string += "<i class='far fa-times-circle text-danger'></i>"
        }
        $('#archivos').html(string);
    }
    
    $.ajax
    ({
        method: 'POST',
        url: 'archivo',
        data: fd,
        processData: false,
        contentType: false,
        
        success: function (res)
        {
            $("#success").html(res.res); 
            $("#spinner").hide();
        },
        error : function(respuesta) 
        {
            $("#spinner").hide();
            $("#success").html(res.res); 
        }

    });
})