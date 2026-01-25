$().ready(function(){
    $("#btnNuevasSol").click(nuevaSolicitud);
    $("#btnStatusSol").click(revisaStatusSolicitud);
    $("#btnCancelar").click(cancelaSolicitud);
    $("#btnSalir").click(salirSolicitud);
});

function nuevaSolicitud(){
    var url="SolicitarNuevoPrestamo.php";
    $(location).attr('href',url);
}

function revisaStatusSolicitud(){
    var url="StatusSolicitudSecretarios.php";
    $(location).attr('href',url);
}

function cancelaSolicitud(){
    var url="CancelaSolicitudSecretarios.php";
    $(location).attr('href',url);
}

function salirSolicitud(){
     //var url="PortalPrestamos.php?salir=true";
     //$(location).attr('href',url);
     document.location = "PortalPrestamos.php?salir=true"
}