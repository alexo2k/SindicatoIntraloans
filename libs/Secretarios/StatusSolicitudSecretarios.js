$().ready(function(){
    
    $("#btnRegresa").click(function(){
        var url = "PortalSecretarios.php";
        $(location).attr('href',url);
    });
    
    $("#btnMuestraStatus").click(function(){
        $("#tableInfo").empty();
        
        try{
            $.ajax({
                url: 'libs/Secretarios/requestSecStatus.php',
                dataType: 'json',
                data: $("#hiddenUsuario").serialize(),
                type: 'post',
                success: function(data){
                    $.each(data, displayData);  
                },
                error: function(xhr, status, error){
                    alert("error " + xhr.responseText);
                }
            });
        } catch(err){
            alert('Ocurrio un error: ' + err.message);
        }
        
    });
    
    function displayData(index, element){
        
        var splitComment = element.comentarios.split('_');
        var splitMonto = splitComment[0];
        var preFolio = splitComment[1];
        var secComment = splitComment[2];
        var loanUser = "";
        var loanComment = "";
        
        if(splitComment.length == 5){
            var loanUser = splitComment[3];
            var loanComment = splitComment[4];
        }

        switch(splitMonto){
            case "10000":
                auxMonto = "$10,000.00";
                break;
            case "15000":
                auxMonto = "$15,000.00";
                break;
            case "18000":
                auxMonto = "$18,000.00";
                break;
            case "20000":
                auxMonto = "$20,000.00";
                break;
            default:
                auxMonto = "$" + element.monto + ".00";
        }
        
        var registroNuevo = $('<tr></tr>');
        //var cellFolio = $('<td></td>').text(preFolio + pad(element.folio,3));
        var cellFolio = $('<td></td>').text(element.folio);
        var cellPaterno = $('<td></td>').text(element.paterno);
        var cellMaterno = $('<td></td>').text(element.materno);
        var cellNombre = $('<td></td>').text(element.nombre);
        var cellRfc = $('<td></td>').text(element.rFC);
        var cellOficina = $('<td></td>').text(element.oficina);
        var cellFechaIngreso = $('<td></td>').text(element.fechaIngreso);
        var cellFechaSolicitud = $('<td></td>').text(element.fechaSolicitud);
        var cellMonto = $('<td></td>').text(auxMonto);
        var cellStatus = $('<td></td>').text(element.status);
        var cellFechaMov = $('<td></td>').text((element.fechaMovimiento != "00/00/0000" ? element.fechaMovimiento : 'N/A'));
        var cellLoanComment = $('<td></td>').text((loanComment != "" ? loanComment : "N/A"));

        //registroNuevo.append(cellFolio, cellPaterno, cellMaterno, cellNombre, cellRfc, cellOficina, cellFechaIngreso, cellFechaSolicitud, cellMonto, cellStatus, cellFechaMov, cellLoanComment);
        registroNuevo.append(cellFolio, cellPaterno, cellMaterno, cellNombre, cellRfc, cellOficina, cellFechaIngreso, cellFechaSolicitud, cellMonto, cellStatus, cellLoanComment);

        $("#tableInfo").append(registroNuevo);
    }
    
});

function pad (str, max) {
  str = str.toString();
  return str.length < max ? pad("0" + str, max) : str;
}