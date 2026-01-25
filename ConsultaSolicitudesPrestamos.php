<?
session_start();

if(!isset($_SESSION['loggedIn']) || ($_SESSION['loggedIn']!= "true") || ($_SESSION['timeOut'] + 10 * 60 < time())){
        session_destroy();
        header('Location: PortalPrestamos.php');  
}

?>
<html lang="ES">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8">
        <title>Estadísticas de solicitudes</title>
        <link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/IntraloansStyle.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <header class="container-fluid">
            <div class="well text-center wellWhiteSmoke">
                <h4>Consulta las estadísticas de solicitudes</h4>
            </div>
        </header>
        <div class="container-fluid">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4>Selecciona las solicitudes a mostrar</h4>
                </div>
                <div class="panel-body">
                    <div class="row form-horizontal">
                        <div class="col-xs-2 text-right control-label">
                            <label for="slctStatus">Status de la solicitud</label>
                        </div>
                        <div class="col-xs-2">
                            <select id="slctStatus" name="slctStatus" class="form-control">
                                <option value="ALL" selected="selected">Todas las solicitudes</option>
                                <option value="RECHAZADA">Solicitudes Rechazadas</option>
                                <option value="APROBADA">Solicitudes Aceptadas</option>
                                <option value="ENVIADO">Solicitudes Enviadas</option>
                            </select>
                        </div>
                        <div class="col-xs-2 text-right control-label">
                            <label for="dateFechaInicial">Fecha Inicial</label>
                        </div>
                        <div class="col-xs-2">
                            <input type="date" id="dateFechaInicial" class="form-control"/>
                        </div>                        
                        <div class="col-xs-2 text-right control-label">
                            <label for="dateFechaFinal">Fecha Final</label>
                        </div>
                        <div class="col-xs-2">
                            <input type="date" id="dateFechaFinal" class="form-control" />   
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id='tblExcel' class="table table-bordered table-hover smallFont">
                            <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>Apellido Paterno</th>
                                    <th>Apellido Materno</th>
                                    <th>Nombre</th>
                                    <th>RFC</th>
                                    <th>Oficina</th>
                                    <th>Fecha Solicitud</th>
                                    <th>Status</th>
                                    <th>Monto</th>
                                    <th>Usuario Solicitante</th>
                                    <th>Comentarios Solicitante</th>
                                    <th>Usuario Prestamos</th>
                                    <th>Comentario Prestamos</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="button" id="btnMostar" name="btnMostrar" class="btn btn-primary">Mostrar</button>
                    <button type="button" id="btnDescargarXLS" name="btnDescargarXLS" class="btn btn-success"><span class="glyphicon glyphicon-save-file"></span> Descargar en hoja cálculo</button>
                    <button type="button" id="btnRegresar" name="btnRegresar" class="btn btn-danger">Cancelar</button>
                </div>
            </div>
        </div>
        <iframe id="txtArea1" style="display:none"></iframe>
        <script src="libs/jquery-1.11.1.js" type="text/javascript"></script>
        <script src="libs/Prestamos/ConsultaSolicitudesPrestamos.js" type="text/javascript"></script>
        <script src="libs/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>
