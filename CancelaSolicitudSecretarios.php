<?
    session_start();
    require_once 'libs/OperacionesIntraloans.php';
    
    if(!isset($_SESSION['loggedIn']) || ($_SESSION['loggedIn']!= "true") || ($_SESSION['timeOut'] + 10 * 60 < time())){
        session_destroy();
        header('Location: PortalPrestamos.php');  
    }
    
    $operacionesBD = new OpIntraloans();
    $usuario = $_SESSION['UserLogin'];
?>
<html lang="ES">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8">
        <title>Cancelar Solicitudes</title>
        <link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/IntraloansStyle.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="container-fluid">
            <div class="well text-center wellWhiteSmoke">
                <h4>Posibles solicitudes a cancelar:</h4>
            </div>
        </div>
        <input type="hidden" id="hiddenUsuario" value="<? echo $usuario?>" />
        <div class="container-fluid">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4>Selecciona la solicitud a cancelar:</h4>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="resultadoStatus" class="table table-bordered table-hover smallFont">
                            <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>Apellido Paterno</th>
                                    <th>Apellido Materno</th>
                                    <th>Nombre</th>
                                    <th>RFC</th>
                                    <th>Oficina</th>
                                    <th>Fecha Ingreso</th>
                                    <th>Fecha Solicitud</th>
                                    <th>Monto Solicitado</th>
                                    <th>Status de la Solicitud</th>
                                    <th>Comentarios</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody id="tableContent">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-primary btn-lg" id="btnMuestraSolicitud">Mostrar Solicitudes</button>
                    <button type="button" class="btn btn-success btn-lg" id="btnSalir">Regresar</button>
                </div>
            </div>
        </div>
        <script src="libs/jquery-1.11.1.js" type="text/javascript"></script>
        <script src="libs/Secretarios/CancelaSolicitudSecretarios.js" type="text/javascript"></script>
        <script src="libs/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>
