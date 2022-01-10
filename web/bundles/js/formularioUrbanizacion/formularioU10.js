var divEtapas = document.getElementById('divEtapas');
var explicacionEtapas = document.getElementById('explicacionEtapas');

function showInput(){
    divEtapas.style.display = "block";
    explicacionEtapas.setAttribute('required', 'true');
}
function hideInput(){
    divEtapas.style.display = "none";
    explicacionEtapas.removeAttribute('required', 'false');
}
