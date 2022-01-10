function cambioEstado(idTramiet,idEstado){
    let title = '¿ Desea aprobar este trámite ?'
    let confirmButton = 'Aprobar'

    if(idEstado == 4){
        $.ajax({
            url: (idEstado>=4) ? '../cambioestado' : 'cambioestado',
            method: "POST",
            dataType: 'json',
            data: {idTramite : idTramiet, idEstado: idEstado},
            beforeSend: function(){
                Swal.fire({
                    position: 'center',
                    icon: 'info',
                    showConfirmButton: false,
                    backdrop: false,
                    title: 'Guardando...',
                })
            },
            success: function(data){                
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Se cambio el estado del Tramite',
                    showConfirmButton: false,
                    timer: 1500
                })
                .then((result) => {            
                    location.reload(true);
                })
            },
            error: function(data){
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error no se pudo actualizar el estado del tramite',
                })
            },
        });
    }else{
        Swal.fire({
            title: title,
            showCancelButton: true,
            confirmButtonText: confirmButton,
            cancelButtonText: `Cancelar`,
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: (idEstado>=4) ? '../cambioestado' : 'cambioestado',
                    method: "POST",
                    dataType: 'json',
                    data: {idTramite : idTramiet, idEstado: idEstado},
                    beforeSend: function(){
                        Swal.fire({
                            position: 'center',
                            icon: 'info',
                            showConfirmButton: false,
                            backdrop: false,
                            title: 'Guardando...',
                        })
                    },
                    success: function(data){                
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Se cambio el estado del Tramite',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        .then((result) => {            
                            location.reload(true);
                        })
                    },
                    error: function(data){
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error no se pudo actualizar el estado del tramite',
                        })
                    },
                });
            }
        })
    }
}