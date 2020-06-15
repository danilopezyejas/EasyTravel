function guardarPaquete(opcion) {
  $("#paquete-" + opcion).submit(function (e) {
    e.preventDefault();
    var datos = $(this).serializeArray();
    $.ajax({
      async: false,
      url: "/EasyTravel/public/guardarPaquete",
      type: "POST",
      data: datos,
      beforeSend: function () {
        $("#paquete-" + opcion + " .fas.fa-spinner.fa-spin").css(
          "display",
          "table"
        );
      }
    })
      .done(function () {
        $("#reservar-" + opcion).css("background-color", "rgb(145, 173, 3)");
        $("#reservar-" + opcion).css("border-color", "rgb(109, 130, 5)");
        $("#btnReserva-" + opcion).css("background-color", "rgb(145, 173, 3)");
        $("#btnReserva-" + opcion).css("border-color", "rgb(0,0,0,0)");
        $("#btnReserva-" + opcion).css("cursor", "no-drop");
        $("#btnReserva-" + opcion).attr("disabled", true);
        document.getElementById("btnReserva-" + opcion).value = "RESERVADO";
        Swal.fire({
          text:
            "Gracias por preferirnos. Se le ha enviado un correo con los detalles",
          backdrop: true,
          toast: true,
          position: "top",
          grow: false,
          showConfirmButton: true
        });
      })
      .fail(function () {
        document.getElementById("btnReserva-" + opcion).value = "RESERVAR";
        alert("A ocurrido un error");
      })
      .always(function () {
        $("#btnReserva-" + opcion).blur();
        $("#paquete-" + opcion + " .fas.fa-spinner.fa-spin").hide();
      });
  });
}

//Aca le establesco el atributo VALUE de los botones en RESERVAR
$(document).ready(function () {
  var paquetes = document.querySelectorAll(".btnReserva");
  for (var i = 1; i <= paquetes.length; i++) {
    $("#btnReserva-" + i).val("RESERVAR");
    $("#paquete-" + i + " .fas.fa-spinner.fa-spin").css("display", "none");
    $("#paquete-" + i).submit(function (e) {
      e.preventDefault();
    });
  }
});

function guardarResenia(id_paquete) {
  var datos = $(this).serializeArray();
  var parametros = { "comentario":comentario, "paquete": id_paquete };

  $.ajax({
    async: false,
    url: "/EasyTravel/public/resenia/guardar",
    type: "POST",
    data: datos
  });
}

// }
