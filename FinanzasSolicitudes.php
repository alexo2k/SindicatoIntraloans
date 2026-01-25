<?
    session_start();
    
    if(!isset($_SESSION['loggedIn']) || ($_SESSION['loggedIn']!= "true") || ($_SESSION['timeOut'] + 10 * 60 < time())){
        session_destroy();
        header('Location: PortalPrestamos.php');  
    }
    
    $usuario = $_SESSION['UserLogin'];
?>
<html lang="ES">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8">
        <title>Nuevas solicitudes de préstamo</title>
        <link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/IntraloansStyle.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <header class="container-fluid">
            <div class="well text-center wellWhiteSmoke">
                <h4>Solicitudes Pendientes</h4>
            </div>
        </header>
        <input type="hidden" id="hiddenUsuario" value="<? echo $usuario ?> "/>
        <div class="container-fluid">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4>Solicitudes nuevas pendientes:</h4>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover smallFont">
                            <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>Apellido Paterno</th>
                                    <th>Apellido Materno</th>
                                    <th>Nombre</th>
                                    <th>RFC</th>
                                    <th>Oficina</th>
                                    <th>Fecha Solicitud</th>
                                    <th>Monto Solicitado</th>
                                    <th>Status de la Solicitud</th>
                                    <th>Secretario Solicitante</th>
                                    <th>Comentarios</th>
                                    <th>Aceptar Solicitud</th>
                                    <th>Rechazar Solicitud</th>
                                    <th>Descargar</th>
                                </tr>
                            </thead>
                            <tbody id="tblSolicitudes">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-primary btn-lg" id="btnMostrar">Mostrar Solicitudes</button>
                    <button type="button" class="btn btn-success btn-lg" id="btnSalir">Salir</button>
                </div>
            </div>
        </div>
        <script src="libs/jquery-1.11.1.js" type="text/javascript"></script>
        <script src="libs/Prestamos/FinanzasSolicitudes.js" type="text/javascript"></script>
        <script src="libs/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>
