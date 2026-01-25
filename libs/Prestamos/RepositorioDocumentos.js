$().ready(function(){
    
    $("#btnSearchRepos").click(function(){
        $("#tblRepos").empty();
        
        if(validaRFC($("#txtSearchRepos").val())){
            $.ajax({
                url: "libs/Prestamos/WSRecuperaSolicitudes.php",
                type: 'post',
                dataType: 'json',
                data:{
                    requestType: 'getRepository',
                    rfcRequest: $("#txtSearchRepos").val().trim()
                },
                success:function(data){
                    if(data.length == 0){
                        alert("No se encontraron documentos en el repositorio asociados al RFC.");
                    } 
                    else {
                        $.each(data, showData);
                    }
                },
                error:function(xhr, status, errno){
                    alert(xhr.responseText);
                }
            });
        } else {
            alert("El RFC introducido no es válido.");
            $("#txtSearchRepos").val("");
        }
        
    });
    
    $("#btnReposBorrar").click(function(){
        $("#tblRepos").empty();
        $("#txtSearchRepos").val("");
    });
    
    $("#btnReposRegresar").click(function(){
        var url="PortalFinanzas.php";
        $(location).attr('href',url);
    });
});

function showData(index, element){
    
    var registroNuevo = $('<tr></tr>');
    
    var cellPaterno = $("<td></td>").text(element.paterno);
    var cellMaterno = $("<td></td>").text(element.materno);
    var cellNombre = $("<td></td>").text(element.nombre);
    var cellRFC = $("<td></td>").text(element.rFC);
    var cellOficina = $("<td></td>").text(element.oficina);

    var optionLegend = $("<option selected='selected disabled='disabled'>Selecciona un documento</option>");
    var optionDescargaSol = $('<option>Solicitud PDF</option>').attr('value',element.RootDir + '/' + element.RequestFile);
    var optionDescargaIfe = $('<option>Comprobante IFE</option>').attr('value',element.RootDir + '/' + element.IfeFile);
    var optionDescargaDomi = $('<option>Comprobante Domicilio</option>').attr('value', element.RootDir + '/' + element.AddressFile);
    var optionDescargaTalon = $('<option>Ultimo Talon Pago</option>').attr('value', element.RootDir + '/' + element.PaymentFile);
    var optionDescargaCLABE = $('<option>Comprobante CLABE</option>').attr('value', element.RootDir + '/' + element.ClabeFile);
    var slctDescargaDocto = $('<select></select>').append(optionLegend, optionDescargaSol, optionDescargaIfe, optionDescargaDomi, optionDescargaTalon, optionDescargaCLABE).on('change',function(){window.open(this.value)}).attr({class:'form-control inputSmall'});
    
    registroNuevo.append(cellPaterno, cellMaterno, cellNombre, cellRFC, cellOficina, slctDescargaDocto);
    $("#tblRepos").append(registroNuevo);
}

function validaRFC(textValue){
    var regex = new RegExp(/^[0-9A-Za-zñÑ]+$/);
    
    if(textValue === "" ){
        return false;
    } else if(regex.test(textValue)){
        return true;
    } else {
        return false;
    }
}