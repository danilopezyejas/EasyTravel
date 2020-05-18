function guardarPaquete(opcion){
$('#paquete-'+opcion).submit(function(e){
  e.preventDefault();
  var datos = $(this).serializeArray();
  $.ajax({
         url: "/EasyTravel/public/guardarPaquete",
         type: "POST",
         data: datos,
         beforeSend: function(){
           $('#paquete-'+opcion+' .fas.fa-spinner.fa-spin').css('display','table');
         }
       })
       .done(function(){
         $('#reservar-'+opcion).css('background-color','rgb(145, 173, 3)');
         $('#reservar-'+opcion).css('border-color','rgb(109, 130, 5)');
         $('#btnReserva-'+opcion).css('background-color','rgb(145, 173, 3)');
         $('#btnReserva-'+opcion).css('border-color','rgb(0,0,0,0)');
         $('#btnReserva-'+opcion).css('cursor','no-drop');
         $('#btnReserva-'+opcion).attr("disabled", true);
         document.getElementById("btnReserva-"+opcion).value = "RESERVADO";
         alert("Gracias por preferirnos. Se le ha enviado un correo con los detalles del paquete.");
       })
       .fail(function(){
         document.getElementById("btnReserva-"+opcion).value = "RESERVAR";
         alert("A ocurrido un error");
       })
       .always(function(){
         $('#btnReserva-'+opcion).blur();
         $('#paquete-'+opcion+' .fas.fa-spinner.fa-spin').hide();
       })
});
}

//Aca le establesco el atributo VALUE de los botones en RESERVAR
$(document).ready(function(){
  var paquetes = document.querySelectorAll('.btnReserva');
  for (var i = 1; i <= paquetes.length; i++) {
    $('#btnReserva-' + i).val("RESERVAR");
    $('#paquete-'+i+' .fas.fa-spinner.fa-spin').css('display','none');
    $('#paquete-'+i).submit(function(e){
      e.preventDefault();
      });
    }
});