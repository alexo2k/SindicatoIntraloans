<?
    session_start();
    require_once 'libs/OperacionesIntraloans.php';
    
    if(!isset($_SESSION['loggedIn']) || ($_SESSION['loggedIn']!= "true") || ($_SESSION['timeOut'] + 10 * 60 < time())){
        session_destroy();
        header('Location: PortalPrestamos.php');  
    }
    
    $operacionesBD = new OpIntraloans();
    $varStatusBloqueo = $operacionesBD->recuperaStatusBloqueo();
    $statusBloqueo = ($varStatusBloqueo == "1") ? "Desbloqueado" : "Bloqueado";
?>
<html lan="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bloquear/Desbloquear Solicitudes Nuevas</title>
        <link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/IntraloansStyle.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <header class="container-fluid">
            <div class="well text-center wellWhiteSmoke">
                <h4>Bloquear / Desbloquear solicitudes nuevas</h4>
            </div>
        </header>
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4>Status Actual:</h4>
                </div>
                <div class="panel-body">              
                    <div class="col-xs-4 col-xs-offset-4">
                        <h4 id="statusBloqueoSol" class="alert"><? echo $statusBloqueo ?></h4>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="form-group row">
                        <button type="button" id="btnDesbloquear" class="btn btn-success">Desbloquear</button>
                        <button type="button" id="btnBloquear" class="btn btn-warning">Bloquear</button>
                        <button type="button" id="btnSalir" class="btn btn-danger">Salir</button>
                    </div>   
                </div>
            </div>
        </div>
        <script src="libs/jquery-1.11.1.js" type="text/javascript"></script>
        <script src="libs/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="libs/Prestamos/BloquearSolicitudes.js" type="text/javascript"></script>
    </body>
</html>
