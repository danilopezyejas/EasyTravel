function comprobarClave(){

    clave1 = document.registro.re-password.value
    clave2 = document.registro.password.value
    alerta = document.getElementById("re-password-check")

    if (clave1 === clave2){
       alerta.innerHTML = "bien"
    }
    else{
    	//document.getElementById("re-password-check").innerHTML = "mal"
    	alerta.innerHTML ="mal"
    }
}

function ver(n) {
  $('#myPopup'+n).css('visibility','visible');
}

function ocultar(n) {
  $('#myPopup'+n).css('visibility','hidden');
}
