<?
session_start();
require_once 'libs/OperacionesIntraloans.php';

if(!isset($_SESSION['loggedIn']) || ($_SESSION['loggedIn']!= "true") || ($_SESSION['timeOut'] + 10 * 60 < time())){
    session_destroy();
    header('Location: PortalPrestamos.php');  
}

$auxOperacionesBD = new OpIntraloans();
$estado = $_SESSION['AreaTrabajo'];
$zonaTrabajo = ucwords($estado);
// alexo Cambiar aqui el folioGeneral enviando el Edo
$numeroFolio = $auxOperacionesBD->obtenFolioEspecifico($zonaTrabajo);
$codigoSeccion = $auxOperacionesBD->obtenCodigoSeccion($zonaTrabajo);
?>

<html lang="ES">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8">
        <link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/IntraloansStyle.css" rel="stylesheet" type="text/css"/>
        <title>Solicitud de Préstamo</title>
    </head>
    <body>
        <form id="formSolicitud" enctype="multipart/form-data" autocomplete="off" >
            <fieldset class="container">
                <legend class="well text-center wellWhiteSmoke">Crear la solicitud de préstamo</legend>
                <div class="panel panel-primary">
                    <div class="panel-heading">Datos del Préstamo</div>
                    <div class="panel-body form-horizontal">
                        <input type="hidden" id="hiddenFolio" value="<? echo $numeroFolio ?>"/>
                        <input type="hidden" id="hiddenCodigoSeccion" value="<? echo $codigoSeccion ?>"/>
                        <input type="hidden" id="hiddenZonaTrabajo" value="<? echo $zonaTrabajo ?>"/>
                        <div class="form-group row">
                            <label for="slctEntFederativa" class="col-xs-2 control-label">Entidad Federativa</label>
                            <select id="slctEntFederativa" class="col-xs-4 form-control inputMedium" name="slctEntFederativa" disabled>
                                <option value="AGS">Aguascalientes</option>
                                <option value="BCN">Baja California Norte</option>
                                <option value="BCS">Baja California Sur</option>
                                <option value="CAM">Campeche</option>
                                <option value="CHIS">Chiapas</option>
                                <option value="CHIH">Chihuahua</option>
                                <option value="COAH">Coahuila</option>
                                <option value="COL">Colima</option>
                                <option value="DF">Distrito Federal</option>
                                <option value="DGO">Durango</option>
                                <option value="GTO">Guanajuato</option>
                                <option value="GRO">Guerrero</option>
                                <option value="HGO">Hidalgo</option>
                                <option value="JAL">Jalisco</option>
                                <option value="MEX">Mexico</option>
                                <option value="MICH">Michoacan</option>
                                <option value="MOR">Morelos</option>
                                <option value="NAY">Nayarit</option>
                                <option value="NL">Nuevo Leon</option>
                                <option value="OAX">Oaxaca</option>
                                <option value="PBA">Puebla</option>
                                <option value="QRO">Queretaro</option>
                                <option value="QROO">Quintana Roo</option>
                                <option value="SLP">San Luis Potosi</option>
                                <option value="SIN">Sinaloa</option>
                                <option value="SON">Sonora</option>
                                <option value="TAB">Tabasco</option>
                                <option value="TAM">Tamaulipas</option>
                                <option value="TLX">Tlaxcala</option>
                                <option value="VER">Veracruz</option>
                                <option value="YUC">Yucatan</option>
                                <option value="ZAC">Zacatecas</option>
                                <option value="TIJ">Tijuana</option>
                                <option value="TRC">Torreon</option>
                                <option value="TAP">Tapachula</option>
                                <option value="CJZ">CD Juarez</option>
                                <option value="MZT">Mazatlan</option>
                                <option value="CON">CD Obregon</option>
                                <option value="NLD">Nuevo Laredo</option>
                                <option value="CTZ">Coatzacoalcos</option>
                                <option value="CUN">Cancun</option>
                                <option value="ZCO">Zona Conurbada Oriente</option>
                                <option value="ZCP">Zona Conurbada Poniente</option>
                                <option value="XAL">Xalapa</option>
                            </select>
                            <label for="fechaSolicitud" class="col-xs-2 control-label">Fecha de solicitud</label>
                            <input type="date" id="fechaSolicitud" class="col-xs-4 form-control inputMedium" name="fechaSolicitud" required="required" min="2015-01-01" max="2050-12-31"/>
                        </div>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">Datos Personales y Laborales</div>
                    <div class="panel-body form-group container">
                        <div class="row form-horizontal">
                            <label for="txtNombreEmp" class="col-xs-2 control-label">Nombre:</label>
                            <input type="text" id="txtNombreEmp" class="col-xs-4 form-control inputMedium" name="txtNombreEmp" placeholder="Nombre del empleado" pattern="[A-Za-zñÑ.,áéíóúÁÉÍÓÚ ]+" required="required"/>
                            <label for="txtApPatEmp" class="col-xs-2 control-label">Apellido Paterno:</label>
                            <input type="text" id="txtApPatEmp" class="col-xs-4 form-control inputMedium" name="txtApPatEmp" placeholder="Apellido paterno del empleado" pattern="[A-Za-zñÑ.,áéíóúÁÉÍÓÚ ]+" required="required"/>
                        </div>
                        <div class="row form-horizontal">
                            <label for="txtApMatEmp" class="col-xs-2 control-label">Apellido Materno:</label>
                            <input type="text" id="txtApMatEmp" class="col-xs-4 form-control inputMedium" name="txtApMatEmp" placeholder="Apellido Materno del empleado" pattern="[A-Za-zñÑ.,áéíóúÁÉÍÓÚ ]+" required="required"/>
                            <label for="txtRfcEmp" class="col-xs-2 control-label">RFC:</label>
                            <input type="text" id="txtRfcEmp" class="col-xs-4 form-control inputMedium" name="txtRfcEmp" placeholder="RFC del empleado" pattern="[A-Za-z0-9]+" required="required">
                        </div>
                        <div class="row form-horizontal">
                            <label for="fechaIngreso" class="col-xs-2 control-label">Fecha de ingreso:</label>
                            <input type="date" id="fechaIngreso" class="col-xs-4 form-control inputMedium" name="fechaIngreso" required="required" min="1900-01-01" max="2050-12-31" value="1970-01-01" />
                            <label for="txtPuesto" class="col-xs-2 control-label">Puesto:</label>
                            <input type="text" id="txtPuesto" class="col-xs-4 form-control inputMedium" name="txtPuesto" required="required" placeholder="Ingresa el puesto del empleado" />
                        </div>
                        <div class="row form-horizontal">
                            <label for="txtCodigNum" class="col-xs-2 control-label">Código Analítico:</label>
                            <input type="text" id="txtCodigNum" class="col-xs-4 form-control inputMedium" name="txtCodigNum" required="required" placeholder="Código y Número Analítico"/>
                            <label for="txtOficina" class="col-xs-2 control-label">Oficina:</label>
                            <input type="text" id="txtOficina" class="col-xs-4 form-control inputMedium" name="txtOficina" required="required" placeholder="Oficina del empleado" />
                        </div>
                        <div class="row form-horizontal">
                            <label for="txtEstadoEmp" class="col-xs-2 control-label">Ciudad/Entidad Fed:</label>
                            <input type="text" id="txtEstadoEmp" class="col-xs-4 form-control inputMedium" name="txtEstadoEmp" placeholder="Ciudad y Entidad Federativa de la Oficina"/>
                        </div>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">Datos Domiciliarios</div>
                    <div class="panel-body form-group container">
                        <div class="row form-horizontal">
                            <label for="txtCalle" class="col-xs-1 control-label">Calle:</label>
                            <input type="text" id="txtCalle" class="col-xs-3 form-control inputMedium" name="txtCalle" required="required" placeholder="Calle del domicilio" />
                            <label for="txtNumExt" class="col-xs-1 control-label">Núm Ext:</label>
                            <input type="text" id="txtNumExt" class="col-xs-3 form-control inputSmall" name="txtNumExt" required="required" placeholder="Número Exterior" maxlengt="10"/>
                            <label for="txtNumInt" class="col-xs-1 control-label">Núm Int:</label>
                            <input type="text" id="txtNumInt" class="col-xs-3 form-control inputSmall" name="txtNumInt" placeholder="Número Interior" maxlength="10"/>
                        </div>
                        <div class="row form-horizontal">
                            <label for="txtTelefono" class="col-xs-1 control-label">Teléfono:</label> 
                            <input type="tel" id="txtTelefono" class="col-xs-3 form-control inputSmall" name="txtTelefono" placeholder="Número Teléfonico" required="required"/>
                            <label for="txtColonia" class="col-xs-1 control-label">Colonia:</label>
                            <input type="text" id="txtColonia" class="col-xs-3 form-control inputMedium" name="txtColonia" placeholder="Colonia" required="required">
                            <label for="txtCodPostal" class="col-xs-1 control-label">C.P:</label>
                            <input type="text" id="txtCodPostal" class="col-xs-3 form-control inputSmall" name="txtCodPostal" placeholder="Código Postal" pattern="[0-9]+" required="required" maxlength="7"/>
                        </div>
                        <div class="row form-horizontal">
                            <label for="txtDelMun" class="col-xs-2 control-label">Delegación/Municipio:</label>
                            <input type="text" id="txtDelMun" class="col-xs-4 form-control inputMedium" name="txtDelMun" required="required" placeholder="Delegación o Municipio del domicilio"/>
                            <label for="txtEntFed" class="col-xs-2 control-label">Entidad Federativa:</label>
                            <input type="text" id="txtEntFed" class="col-xs-4 form-control inputMedium" name="txtEntFed" required="required" placeholder="Entidad federativa del domicilio"/>
                        </div>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">Datos Bancarios</div>
                    <div class="panel-body form-group container form-horizontal row">
                        <label for="txtClabe" class="col-xs-2 control-label">Clave Interbancaria:</label>
                        <input type="text" id="txtClabe" class="col-xs-4 form-control inputMedium" name="txtClabe" required="required" placeholder="Introduce la clave interbancaria (CLABE)" maxlength="20" pattern="[0-9]+"/>
                        <label for="txtBanco" class="col-xs-2 control-label">Institución Bancaria:</label>
                        <input type="text" id="txtBanco" class="col-xs-4 form-control inputMedium" name="txtBanco" required="required" placeholder="Nombre del Banco" pattern="[A-Za-zñÑ.,áéíóúÁÉÍÓÚ ]+"/>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">Monto a solicitar</div>
                    <div class="panel-body form-group">
                        <div class="form-group row col-xs-9 col-xs-offset-4">
                            <!-- <label class="radio-inline"><input type="radio" id="rBtnMontoOcho" name="rBtnMonto" value="15000" checked="checked" />$15,000</label> -->
                            <label class="radio-inline"><input type="radio" id="rBtnMontoDoce" name="rBtnMonto" value="10000" checked="checked" />$10,000</label>
                            <label class="radio-inline"><input type="radio" id="rBtnMontoQuince" name="rBtnMonto" value="15000" />$15,000</label>
                            <label class="radio-inline"><input type="radio" id="rBtnMontoDieciocho" name="rBtnMonto" value="18000" />$18,000</label>
                            <!-- <label class="radio-inline"><input type="radio" id="rBtnMontoDoce" name="rBtnMonto" value="12000" />$12,000</label> -->
                            <!-- <label class="radio-inline"><input type="radio" id="rBtnMontoDieciseis" name="rBtnMonto" value="16000" />$16,000</label> -->
                            <label class="radio-inline"><input type="radio" id="rBtnMontoVeinte" name="rBtnMonto" value="20000" />$20,000</label>
                        </div>
                        <div class="form-group row">
                            <label for="txtArComentarios" class="control-label col-xs-6">Comentarios:</label>
                            <textarea id="txtArComentarios" class="col-xs-6 form-control" placeholder="Escribe algun comentario si es necesario" rows="4" cols="30"></textarea>
                        </div>
                    </div>
                    <div class="panel-footer form-group">
                        <!--button type="button" id="btnGeneraSolicitud" class="" formnovalidate="formnovalidate">Crear Solicitud</button-->
                        <button type="button" id="btnGeneraSolicitud" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Crear Solicitud</button>
                        <button type="button" id="btnCancelar" class="btn btn-danger" formnovalidate="formnovalidate"><span class="glyphicon glyphicon-remove-circle"></span> Cancelar</button> 
                    </div>
                </div>
            </fieldset>
        </form>
        
        <div class="container">
            <span id="resDatos" class="alert-danger">*</span>
        </div>
        
        <form id="formEnviarSolicitud" class="container" enctype="multipart/form-data">
            <div class="panel panel-primary">
                <div class="panel-heading">Cargar solicitud</div>
                <div class="panel-body form-group row">
                    <label for="fileSelSolicitud" class="col-xs-4 control-label">Selecciona la solicitud que generaste.</label>
                    <input type="file" id="fileSelSolicitud" class="col-xs-8 form-control" name="fileSelSolicitud" accept=".pdf" />
                </div>
            </div>
        </form>
        
        <form id="formCargarIFE" class="container" enctype="multipart/form-data">
            <div class="panel panel-primary">
                <div class="panel-heading">Cargar IFE</div>
                <div class="panel-body form-group row">
                    <label for="rfcImageFile" class="col-xs-4 control-label">Selecciona la imagen.</label>
                    <input type="file" id="rfcImageFile" class="col-xs-8 form-control" name="rfcImageFile" accept=".jpg"/>
                </div>
            </div>
        </form>
        
        <form id="formCargarDomicilio" class="container" enctype="multipart/form-data">
            <div class="panel panel-primary">
                <div class="panel-heading">Cargar comprobante de domicilio</div>
                <div class="panel-body form-group row">
                    <label for="domicilioFile" class="col-xs-4 control-label">Selecciona el comprobante de domicilio.</label>
                    <input type="file" id="domicilioFile" class="col-xs-8 form-control" name="domicilioFile" accept=".jpg" />
                </div>
            </div>
        </form>
        
        <form id="formCargarTalonPago" class="container" enctype="multipart/form-data">
            <div class="panel panel-primary">
                <div class="panel-heading">Cargar último talón de pago</div>
                <div class="panel-body form-group row">
                    <label for="talonFile" class="col-xs-4 control-label">Selecciona el comprobante de pago.</label>
                    <input type="file" id="talonFile" class="col-xs-8 form-control" name="talonFile" accept=".jpg"/>
                </div>
            </div>
        </form>
        
        <form id="formCargarClabe" class="container" encytype="multipart/form-data">
            <div class="panel panel-primary">
                <div class="panel-heading">Cargar clave interbancaria (CLABE)</div>
                <div class="panel-body form-group row">
                    <label for="clabeFile" class="col-xs-4 control-label">Selecciona la clave interbancaria (CLABE)</label>
                    <input type="file" id="clabeFile" class="col-xs-8 form-control" name="clabeFile" accept=".jpg" />
                </div>
            </div>
        </form>
        
        <br/>
        <div id="EnviarSolicitud" class="container">
            <button type="button" class="btn btn-lg" id="BtnEnviarSolicitudPrestamos">Enviar Solicitud al área de préstamos</button>
        </div>
        
        <div class="modal fade" id="modalCarga" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">ERROR: No se han seleccionado los documentos.</h4>
                    </div>
                    <div class="modal-body">
                        <p>Verifica que todos los documentos han sido correctamente seleccionados.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="modalExito" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Expediente enviado con éxito.</h4>
                    </div>
                    <div class="modal-body">
                        <p>El expediente ha sido enviado con éxito al área de préstamos para su revisión.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="libs/jquery-1.11.1.js" type="text/javascript"></script>
        <script src="libs/jspdf.min.js" type="text/javascript"></script>
        <script src="classess/Solicitud.js" type="text/javascript"></script>
        <script src="libs/SolicitarNuevoPrestamo.js" type="text/javascript"></script>
        <script src="libs/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>
