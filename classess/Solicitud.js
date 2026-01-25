function Solicitud(folio, fechaSolicitud, entidadFedeSol, datosPersonales, datosLaborales, datosDomiciliarios, clabe, banco, comentarios){
    this.folio = folio;
    this.fechaSolicitud = fechaSolicitud;
    this.entidadFedeSol = entidadFedeSol;
    this.datosPersonales = datosPersonales;
    this.datosLaborales = datosLaborales;
    this.datosDomiciliarios = datosDomiciliarios;
    this.clabe = clabe;
    this.banco = banco;
    this.comentarios = comentarios;
    
    this.getDiaSolicitud = function(){
        var auxArray = fechaSolicitud.split("-");
        return auxArray[2];
    }
    
    this.getMesSolicitud = function(){
        var auxArray = fechaSolicitud.split("-");
        return auxArray[1];
    }

    this.getAnioSolicitud = function(){
        var auxArray = fechaSolicitud.split("-");
        return auxArray[0];
    }
}

function DatosPersonales(apPaterno, apMaterno, nombre, rFC){
    this.apPaterno = apPaterno;
    this.apMaterno = apMaterno;
    this.nombre = nombre;
    this.rFC = rFC;
}

function DatosLaborales(fechaIngreso, puesto, codNumAnalitico, oficina, ciudadEntidad){
    this.fechaIngreso = fechaIngreso;
    this.puesto = puesto;
    this.codNumAnalitico = codNumAnalitico;
    this.oficina = oficina;
    this.ciudadEntidad = ciudadEntidad;
    
    this.getDiaIngreso = function(){
         var auxArray = fechaIngreso.split("-");
        return auxArray[2];
    }
    
    this.getMesIngreso = function(){
        var auxArray = fechaIngreso.split("-");
        return auxArray[1];
    }

    this.getAnioIngreso = function(){
        var auxArray = fechaIngreso.split("-");
        return auxArray[0];
    }  
}

function DatosDomiciliarios(pCalle, pNumExt, pNumInt, pTelefono, pColonia, pCodigoPostal, pDelMun, pEntidadFede){
    this.calle = pCalle;
    this.numExt = pNumExt;
    if(pNumInt === null){
        this.numInt = "";
    }
    else {
        this.numInt = pNumInt;
    }
    this.telefono = pTelefono;
    this.colonia = pColonia;
    this.codigoPostal = pCodigoPostal;
    this.delMun = pDelMun;
    this.EntidadFederativa = pEntidadFede;
}