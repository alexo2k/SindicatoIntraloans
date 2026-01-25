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
        <link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/IntraloansStyle.css" rel="stylesheet" type="text/css"/>
        <title>Status de Solicitudes</title>
    </head>
    <body>
        <div class="container-fluid">
            <div class="well text-center wellWhiteSmoke">
                <h4>Consultar el status de las solicitudes</h4>
            </div>
        </div>
        <div id="hidden">
            <input type="hidden" id="hiddenUsuario" name="hiddenUsuario" value="<? echo $usuario ?>"/>
        </div>
        <div class="container-fluid">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4>Solicitudes actuales:</h4>
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
                                    <!--th>Fecha Aprobacion / Rechazo</th-->
                                    <th>Razon Rechazo</th>
                                </tr>
                            </thead>
                            <tbody id="tableInfo">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-primary btn-lg" id="btnMuestraStatus">Mostrar Status</button>
                    <button type="button" class="btn btn-success btn-lg" id="btnRegresa">Regresar</button>
                </div>
            </div>
        </div>
        <script src="libs/jquery-1.11.1.js" type="text/javascript"></script>
        <script src="libs/Secretarios/StatusSolicitudSecretarios.js" type="text/javascript"></script>
        <script src="libs/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>
