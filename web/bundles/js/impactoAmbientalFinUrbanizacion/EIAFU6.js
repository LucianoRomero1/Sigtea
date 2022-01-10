function cambiarOtros(idCheck, idInput){
    if ($("#" + idCheck).prop('checked')){

        $("#" + idInput).attr("readonly", false);
        $("#" + idInput).attr("required", false);

    }else{
        
        $("#" + idInput).attr("readonly", true);
        $("#" + idInput).attr("required", true);
    }
}