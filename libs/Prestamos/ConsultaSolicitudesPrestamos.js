$().ready(function(){
    
    $("#btnRegresar").click(function(){
        var url="PortalFinanzas.php";
        $(location).attr('href',url);
    });
    
    $("#btnDescargarXLS").click(function(e){
        //window.open('data:application/vnd.ms-excel,' + $("#tableBody").html());
        fnExcelReport();
    });
    
    $("#btnMostar").click(function(){
        //2015-12-24
        $("#tableBody").empty();
        $.ajax({
            url: 'libs/Prestamos/WSExportaSolicitudes.php',
            type: 'POST',
            dataType: 'json',
            data: {
                requestStatus : $("#slctStatus").val(),
                rangoInicial : $("#dateFechaInicial").val(),
                rangoFinal : $("#dateFechaFinal").val()
            },
            success:function(data){
                $.each(data, prepareData);
            },
            error: function(xhr, status, error){
                alert(xhr.responseText);
            }
        });
    });
});

function fnExcelReport()
{
    var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
    var j=0;
    tab = document.getElementById('tblExcel');

    for(j = 0 ; j < tab.rows.length ; j++) 
    {     
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
    }

    tab_text=tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE "); 

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus(); 
        sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
    }  
    else                 //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

    return (sa);
}

function prepareData(index, element){
    
    var auxSplit = element.comentarios.split('_');
    var monto = null;
    
    switch(auxSplit[0]){
        case 8000:
            monto = "$8,000.00";
            break;
        case 12000:
            monto = "$12,000.00";
            break;
        case 16000:
            monto = "$16,000.00";
            break;
        case 20000:
            monto = "$20,000.00";
            break;
        default:
            monto = "$" + auxSplit[0] + ".00";
    }
    
    var reqComments = auxSplit[2] == "" ? "N/A" : auxSplit[2];
    
    if(auxSplit.length > 3){
        var loansUser = auxSplit[3];
        var loansComments = auxSplit[4] == "" ? "N/A" : auxSplit[4];
    } else{
        var loansUser = 'N/A';
        var loansComments = 'N/A';
    }
    
    var registroNuevo = $('<tr></tr>');
    var cellFolio = $('<td></td>').text(element.folio);
    var cellPaterno = $('<td></td>').text(element.paterno);
    var cellMaterno = $('<td></td>').text(element.materno);
    var cellNombre = $('<td></td>').text(element.nombre);
    var cellRFC = $('<td></td>').text(element.rfc);
    var cellOficina = $('<td></td>').text(element.oficina);
    var cellFechaSolicitud = $('<td></td>').text(element.fechaSolicitud);
    var cellStatus = $('<td></td>').text(element.status);
    var cellMonto = $('<td></td>').text(monto);
    var cellReqUser = $('<td></td>').text(element.solicitante);
    var cellReqComments = $('<td></td>').text(reqComments);
    var cellLoansUser = $('<td></td>').text(loansUser);
    var cellLoansComments = $('<td></td>').text(loansComments);
    var cellEstado = $('<td></td>').text(element.estado);
    
    registroNuevo.append(cellFolio, cellPaterno, cellMaterno, cellNombre, cellRFC, cellOficina, cellFechaSolicitud, cellStatus, cellMonto, cellReqUser, cellReqComments, cellLoansUser, cellLoansComments, cellEstado);
    $("#tableBody").append(registroNuevo);
}
