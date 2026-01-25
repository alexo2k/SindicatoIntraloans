$().ready(function(){
   
    $("#btnConsultaSol").click(function(){
        var url="FinanzasSolicitudes.php";
        $(location).attr('href',url);
    });
    
    $("#btnEstadisticas").click(function(){
        var url="ConsultaSolicitudesPrestamos.php";
        $(location).attr('href',url);
    });
    
    $("#btnBloquear").click(function(){
        var url="BloquearSolicitudes.php";
        $(location).attr('href',url);
    });
    
    $("#btnRepositorio").click(function(){
        var url="RepositorioDocumentos.php"
        $(location).attr('href',url);
    });
    
    $("#btnSalir").click(function(){
        //var url="PortalPrestamos.php";
        //$(location).attr('href',url);
        window.location = "PortalPrestamos.php?salir=true"
    });
});


