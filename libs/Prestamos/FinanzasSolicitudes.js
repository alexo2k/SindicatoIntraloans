$().ready(function(){
    
    $("#btnSalir").click(function(){
        var url="PortalFinanzas.php";
        $(location).attr('href',url);
    });
    
    $("#btnMostrar").click(function(){
        $("#tblSolicitudes").empty();
        $.ajax({
            url: 'libs/Prestamos/WSRecuperaSolicitudes.php',
            dataType: 'json',
            type: 'post',
            data: {
                requestType : 'retrieveAll'
            },
            success: function(data){
                $.each(data, prepareData);
            },
            error: function(xhr, status, error){
                
            }
        });
    });
    
    function prepareData(index, element){
        var auxSplit = element.comentarios.split('_');
        var auxMonto = "";
        var auxPreFolio = auxSplit[1];
        var auxComment = auxSplit[2];
        
        switch(auxSplit[0]){
            case '8000':
                auxMonto = "$8,000.00";
            break;
            case '12000':
                auxMonto = "$12,000.00";
                break;
            case '15000':
                auxMonto = "$15,000.00";
            break;
            case '16000':
                auxMonto = "$16,000.00";
            break;
            case '20000' :
                auxMonto = "$20,000.00";
            break;
            default: 
                auxMonto = "$" + auxSplit[0] + ".00";
        }
        
        var registroNuevo = $('<tr></tr>');
        //var cellFolio = $('<td></td>').text(auxPreFolio + pad(element.folio, 3));
        var cellFolio = $('<td></td>').text(element.folio);
        var cellPaterno = $('<td></td>').text(element.paterno);
        var cellMaterno = $('<td></td>').text(element.materno);
        var cellNombre = $('<td></td>').text(element.nombre);
        var cellRFC = $('<td></td>').text(element.rFC);
        var cellOficina = $('<td></td>').text(element.oficina);
        var cellFechaSolicitud = $('<td></td>').text(element.fechaSolicitud);
        var cellMonto = $('<td></td>').text(auxMonto);
        var cellStatus = $('<td></td>').attr('id','tdStatus' + element.folio).text(element.status);
        var cellSolicitante = $('<td></td>').text(element.solicitante);
        var cellComentarios = $('<td></td>').text(auxComment != "" ? auxComment : "N/A");
        
        var btnAprobarSol = $('<button></button>').attr({        
            type : 'button',
            id : 'btnAprobarSol' + element.folio,
            value : element.folio,
            class: 'btn btn-success btn-xs'
        }).html('Aprobar').bind('click', approveRequest);
                
        var btnRechazarSol = $('<button></button>').attr({        
            type : 'button',
            id : 'btnRechazarSol' + element.folio,
            value : element.folio,
            class: 'btn btn-danger btn-xs'
        }).html('Rechazar').bind('click', rejectRequest);
           
        var optionLegend = $("<option selected='selected' disabled='disabled'>Selecciona un documento</option>");   
        var optionDescargaSol = $('<option>Solicitud PDF</option>').attr('value',element.RootDir + '/' + element.RequestFile);
        var optionDescargaIfe = $('<option>Comprobante IFE</option>').attr('value',element.RootDir + '/' + element.IfeFile);
        var optionDescargaDomi = $('<option>Comprobante Domicilio</option>').attr('value', element.RootDir + '/' + element.AddressFile);
        var optionDescargaTalon = $('<option>Ultimo Talon Pago</option>').attr('value', element.RootDir + '/' + element.PaymentFile);
        var optionDescargaCLABE = $('<option>Comprobante CLABE</option>').attr('value', element.RootDir + '/' + element.ClabeFile);
        var slctDescargaDocto = $('<select></select>').append(optionLegend, optionDescargaSol, optionDescargaIfe, optionDescargaDomi, optionDescargaTalon, optionDescargaCLABE).on('change',function(){window.open(this.value)}).attr({class:'form-control inputSmall'});
        
        /*
        
        var btnDescargaSol = $('<button></button>').attr({
            'type' : 'button',
            'id' : 'btnDescargaSol' + element.folio,
            'value' : element.RootDir + '/' + element.RequestFile
        }).html('Descargar Solicitud').bind('click', downloadRequest);
        
        var btnDescargaIfe = $('<button></button>').attr({
            type : 'button',
            id : 'btnDescargaIfe' + element.folio,
            value : element.RootDir + '/' + element.IfeFile
        }).html('Descargar Comprobante IFE').bind('click', downloadRequest);
        
        var btnDescargaDomi = $('<button></button>').attr({
            type : 'button',
            id : 'btnDescargaDomi' + element.folio,
            value : element.RootDir + '/' + element.AddressFile
        }).html('Descargar Comprobante Domicilio').bind('click', downloadRequest);
        
        var btnDescargaTalon = $('<button></button>').attr({
            type : 'button',
            id : 'btnDescargaTalon' + element.folio,
            value : element.RootDir + '/' + element.PaymentFile
        }).html('Descargar Talon Pago').bind('click', downloadRequest);
        
        var btnDescargaCLABE = $('<button></button>').attr({
            type : 'button',
            id : 'btnDescargaCLABE' + element.folio,
            value : element.RootDir + '/' + element.ClabeFile
        }).html('Descargar CLABE').bind('click', downloadRequest);
        */
       
        var cellAprobarSol = $('<td></td>').append(btnAprobarSol);
        var cellRechazarSol = $('<td></td>').append(btnRechazarSol);
//        var cellDescargaSol = $('<td></td>').append(btnDescargaSol);
//       var cellDescargaIfe = $('<td></td>').append(btnDescargaIfe);
//        var cellDescargaDomi = $('<td></td>').append(btnDescargaDomi);
//        var cellDescargaTalon = $('<td></td>').append(btnDescargaTalon);
//        var cellDescargaCLABE = $('<td></td>').append(btnDescargaCLABE);
        var cellDescargaDocto = $('<td></td>').append(slctDescargaDocto);
        
        //registroNuevo.append(cellFolio, cellPaterno, cellMaterno, cellNombre, cellRFC, cellOficina, cellFechaSolicitud, cellMonto, cellStatus, cellSolicitante, cellComentarios, cellAprobarSol, cellRechazarSol, cellDescargaSol, cellDescargaIfe, cellDescargaDomi, cellDescargaTalon, cellDescargaCLABE);
        registroNuevo.append(cellFolio, cellPaterno, cellMaterno, cellNombre, cellRFC, cellOficina, cellFechaSolicitud, cellMonto, cellStatus, cellSolicitante, cellComentarios, cellAprobarSol, cellRechazarSol, cellDescargaDocto);

        registroNuevo.attr('id','registro' + element.folio);
        $("#tblSolicitudes").append(registroNuevo);
    }
    
    function approveRequest(){
        var folioNumberRequest = $(this).val();
        if(confirm('¿Aceptar la solicitud ' + folioNumberRequest + '?')){
            $.ajax({
                url: 'libs/Prestamos/WSRecuperaSolicitudes.php',
                dataType : 'text',
                type: 'post',
                data: {
                    requestType : 'acceptRequest',
                    requestNumber : folioNumberRequest,
                    hiddenUsuario : $("#hiddenUsuario").val()
                },
                success: function(data){
                    if(data > 0){
                        alert('La solicitud con folio ' + folioNumberRequest + ' ha sido aprobada.');
                        $("#tdStatus" + folioNumberRequest).text("APROBADA");
                        $("#btnAprobarSol" + folioNumberRequest).prop('disabled', true);
                        $("#btnRechazarSol" + folioNumberRequest).prop('disabled', true);
                    } else {
                        alert("Ha ocurrido un error, no se ha podido aceptar la solicitud.");
                    }
                },
                error: function(xhr, status, error){
                    alert("Ocurrio un error al aprobar la solicitud " + folioNumberRequest + ". ERR: " + xhr.responseText);
                }
            });
        }
    }
    
    function rejectRequest(){
         var folioNumberRequest = $(this).val();
         if(confirm("¿Rechazar la solicitud con folio " + folioNumberRequest + "?")){
             var razonRechazo = prompt('¿Existe alguna razón para rechazar la solicitud ' + folioNumberRequest + '?');
             $.ajax({
                url: 'libs/Prestamos/WSRecuperaSolicitudes.php',
                dataType : 'text',
                type: 'post',
                data: {
                    requestType : 'rejectRequest',
                    requestNumber : folioNumberRequest,
                    hiddenUsuario : $("#hiddenUsuario").val(),
                    rejectReason : razonRechazo
                },
                success: function(data){
                    //alert(data);
                    if(data > 0){
                        alert('La solicitud con folio ' + folioNumberRequest + ' ha sido rechazada.');
                        $("#tdStatus" + folioNumberRequest).text("RECHAZADA");
                        $("#btnAprobarSol" + folioNumberRequest).prop('disabled', true);
                        $("#btnRechazarSol" + folioNumberRequest).prop('disabled', true);
                    } else{
                        alert("Ha ocurrido un error, no se ha podido rechazar la solicitud con folio " + folioNumberRequest);
                    }
                }, 
                error: function(xhr, status, error){
                    alert("Ocurrio un error al rechazar la solicitud " + folioNumberRequest + ". ERR: " + xhr.responseText);    
                }
             });
         }
    }
    
    function downloadRequest(){
        window.open($(this).val()); 
        /*
        $.ajax({
            url: 'libs/Prestamos/WSRecuperaSolicitudes.php',
            dataType: 'text',
            type: 'post',
            data: {
                requestType : 'downloadRequest',
                requestNumber : $(this).val(),
                requestFile: 'IFE'
            },
            success: function(data){
                //alert(data);
                //window.open('/' + data);
                //var urlDocumento = 'intraloans' + data;
                window.open(data);
                //window.location.href = urlDocumento;
                //$(location).attr('href',data);
            },
            error: function(xhr, status, error){
                alert(xhr.responseText);
            }
        });*/
    }
    
});

function pad (str, max) {
  str = str.toString();
  return str.length < max ? pad("0" + str, max) : str;
}