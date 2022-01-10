$(document).ready( function(){
    let tramites = $('.tramites');
    let buscador = $("#buscarTramite");
    let tramiteNoEncontrado = $(".tramiteNoEncontrado")[0];
    let contenedor = $('.row.pad')[0];
    tramiteNoEncontrado.style.display = 'none';
    buscador.keydown( function () {
        filtrarTramite(buscador);
    })

    buscador.keydown( function (e) {
        // Cuando vas borrando la palabras tambien filtra
        if(e.keyCode == 8) {
            filtrarTramite(buscador);
        }
    })

    function filtrarTramite(buscador){
        setTimeout( function(){
            if(buscador.val() != ""){
                let tramitesEncontrados = buscarTramite(tramites, buscador.val());
                contenedor.style.display = 'flex';
                if(tramitesEncontrados.length>0){
                    tramiteNoEncontrado.style.display = 'none';
                    $.each(tramitesEncontrados[0], function mostrarTramites(key, value){
                        value.style.display = 'none';
                    })
                    $.each(tramitesEncontrados[1], function mostrarTramites(key, value){
                        value.style.display = 'block';
                    })
                    if(tramitesEncontrados[1].length == 0){
                        tramiteNoEncontrado.style.display = 'block';
                    }
                }
            }else{
                contenedor.style.display = 'none';
                $.each(tramites, function mostrarTramites(key, value){
                    value.style.display = 'block';
                })
                tramiteNoEncontrado.style.display = 'none';
            }
        },100)
    }

    function buscarTramite(array, tramite){
        let ocultar = [];
        let mostarar = [];
        let listaTramites = [ocultar,mostarar];
        $.each(array, function buscarTexto(key, value) {
            let titulos = value.innerText.toLowerCase();
            if(titulos.indexOf(tramite.toLowerCase()) == -1){
                ocultar.push(value);
            }else{
                mostarar.push(value);
            }
        });
        return listaTramites;
    }
});