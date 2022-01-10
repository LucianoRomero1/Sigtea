var divJuridica = document.getElementById('divJuridica');


var inputJuridica = document.getElementById('inputJuridica');

function showInput(){
    divJuridica.style.display = "block";
    inputJuridica.setAttribute('required', 'true');
}
function hideInput(){
    divJuridica.style.display = "none";
    inputJuridica.removeAttribute('required', 'false');
}

