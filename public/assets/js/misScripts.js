$('#paquete').submit(function(e){
  e.preventDefault();
  var datos = $(this).serializeArray();
  $.ajax({
         url: "/EasyTravel/public/guardarPaquete",
         type: "POST",
         data: datos,
         beforeSend: function(){
           $('.fas.fa-spinner.fa-spin').css('display','table');
         }
       })
       .done(function(){
         $('.reservar').css('background-color','rgb(145, 173, 3)');
         $('.reservar').css('border-color','rgb(109, 130, 5)');
         $('#btnReserva').css('background-color','rgb(145, 173, 3)');
         $('#btnReserva').css('border-color','rgb(0,0,0,0)');
         $('#btnReserva').attr("disabled", true);
         document.getElementById("btnReserva").value = "RESERVADO";
         alert("Gracias por preferirnos. Se le ha enviado un correo con los detalles del paquete.");
       })
       .fail(function(){
         document.getElementById("btnReserva").value = "RESERVAR";
         alert("A ocurrido un error");
       })
       .always(function(){
         $('#btnReserva').blur();
         $('.fas.fa-spinner.fa-spin').hide();
       })
});

document.getElementById("btnReserva").value = "RESERVAR";
