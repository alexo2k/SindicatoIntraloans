$().ready(function(){
    
    $("#btnMuestraSolicitud").click(function(){
        try{
            $("#tableContent").empty();
            $.ajax({
                url: 'libs/Secretarios/CancelSecSol.php',
                dataType: 'json',
                data: {
                    hiddenUsuario: $("#hiddenUsuario").val(),
                    operacionBD : 'recuperaInfo'
                },
                type: 'POST',
                success: function(data){
                   $.each(data, prepareData);
                },
                error: function(xhr, status, error){
                    alert("Error: " + xhr.responseText);
                }
            });
        } catch(ex){
            alert("Ocurrio un error: " + ex.message);
        }
    });
    
    $("#btnSalir").click(function(){
        var url = "PortalSecretarios.php";
        $(location).attr('href', url);
    });
    
    function prepareData(index, element){
        
        var auxSplit = element.comentarios.split('_');
        var auxMonto = 0;
        var auxPreFolio = auxSplit[1];
        var auxComentarios = auxSplit[2];
        
        switch(auxSplit[0]){
            case "8000":
                auxMonto = "$8,000.00";
                break;
            case "12000":
                auxMonto = "$12,000.00";
                break;
            case "16000":
                auxMonto = "$16,000.00";
                break;
            case "20000":
                auxMonto = "$20,000.00";
                break;
            default:
                auxMonto = "$" + element.monto + ".00";
        }
        
        var registroNuevo = $('<tr></tr>');
        //var cellFolio = $('<td></td>').text(auxPreFolio + pad(element.folio,3));
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
        var cellComentario = $('<td></td>').text(auxComentarios != "" ? auxComentarios : "N/A");
        var inputDelete = $('<button></button>').attr({
            type : 'button',
            id : 'btnDelete' + index,
            value: element.folio,
            class : 'btn btn-danger btn-sm'
        }).html('Eliminar Solicitud').bind('click',deleteRequest);
        
        registroNuevo.append(cellFolio, cellPaterno, cellMaterno, cellNombre, cellRfc, cellOficina, cellFechaIngreso, cellFechaSolicitud, cellMonto, cellStatus, cellComentario, inputDelete);
        registroNuevo.attr('id','registro' + element.folio);
        $("#tableContent").append(registroNuevo);
        
        
    }
    
    function deleteRequest(){
        var pAuxFolio = $(this).val();
        var response = confirm("¿Eliminar la solicitud con folio: " + pAuxFolio + "?");
        
        if(response){
            try{
                $.ajax({
                    url: 'libs/Secretarios/CancelSecSol.php',
                    dataType: 'text',
                    data: {
                        hiddenUsuario: $("#hiddenUsuario").val(),
                        folioSolicitud: pAuxFolio,
                        operacionBD : 'eliminaSolicitud'
                    },
                    type: 'POST',
                    success: function(data){
                        alert(data);
                        $("#registro" + pAuxFolio).remove();
                    },
                    error: function(xhr, status, error){
                        alert("Ocurrio un error " + xhr.responseText);
                    }
                });
            } catch(ex){
                alert('Ocurrio un error: ' + ex.message);
            }
        }
    }
});

function pad (str, max) {
  str = str.toString();
  return str.length < max ? pad("0" + str, max) : str;
}