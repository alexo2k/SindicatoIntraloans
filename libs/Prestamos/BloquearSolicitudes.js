$().ready(function(){
   
    $("#btnDesbloquear").click(function(){
       $.ajax({
           url:'libs/Prestamos/WSBloquearSolicitudes.php',
           type: 'POST',
           dataType: 'text',
           data: {
               requestOption : 'desbloquear'
           },
           success: function(data){
               $("#statusBloqueoSol").text("Desbloqueado");
               $("#statusBloqueoSol").removeClass("alert-danger");
               $("#statusBloqueoSol").addClass("alert-success");
           },
           error: function(xhr, status, error){
               alert("Ocurrio un error: " + xhr.responseText);
           }
       });
   });
   
   $("#btnBloquear").click(function(){
       $.ajax({
           url:'libs/Prestamos/WSBloquearSolicitudes.php',
           type: 'POST',
           dataType: 'text',
           data: {
               requestOption : 'bloquear'
           },
           success: function(data){
               $("#statusBloqueoSol").text("Bloqueado");
               $("#statusBloqueoSol").removeClass("alert-success");
               $("#statusBloqueoSol").addClass("alert-danger");
           },
           error: function(xhr, status, error){
               alert("Ocurrio un error: " + xhr.responseText);
           }
       });
   });
   
   $("#btnSalir").click(function(){
       var url = 'PortalFinanzas.php';
       $(location).attr('href',url);
   });
});
