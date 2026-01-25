<?php
    session_start();
    
    require_once 'libs/OperacionesIntraloans.php';
    
    if(!isset($_SESSION['loggedIn']) || ($_SESSION['loggedIn']!= "true") || ($_SESSION['timeOut'] + 10 * 60 < time())){
        session_destroy();
        header('Location: PortalPrestamos.php');  
    }
    
    $usuario = $_SESSION['ApPaterno'] . ' ' . $_SESSION['ApMaterno'] . ' ' . $_SESSION['Nombre'];
    $zonaTrabajo = $_SESSION['AreaTrabajo'];
    $usuario = strtolower($usuario);
    $usuario = ucwords($usuario);
    $zonaTrabajo = strtolower($zonaTrabajo);
    $zonaTrabajo = ucwords($zonaTrabajo);
?>

<html lang="ES">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Portal Secretarios</title>
        <link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/IntraloansStyle.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
       <header class="container">
            <h2 class="text-center well">Bienvenido al portal de Préstamos</h2>
            <h3 class="text-center text-capitalize well">USUARIO: <? echo $usuario . "</br>"?>ESTADO: <? echo $zonaTrabajo ?></h3>
        </header>
        <article class="container col-xs-offset-2 col-xs-8">
            <fieldset class="panel panel-primary">
                <legend class="panel-heading">Selecciona una opción:</legend>
                <div class="panel-body form-horizontal">
                    <div class="form-group row">
                        <label for="btnNuevaSol" class="col-xs-4 col-xs-offset-2 control-label">Crear una nueva solicitud:</label>
                        <button type="button" id="btnNuevasSol" class="btn btn-primary col-xs-8 inputMedium" name="btnNuevaSol">Nueva Solicitud</button><br/>
                    </div>
                    <div class="form-group row">
                        <label for="btnStatusSol" class="control-label col-xs-4 col-xs-offset-2" >Consultar status de solicitudes:</label>
                        <button type="button" class="btn btn-primary col-xs-8 inputMedium" id="btnStatusSol" name="btnStatusSol">Consultar Solicitudes</button><br/>
                    </div>
                    <div class="form-group row">
                        <label for="btnCancelarSol" class="control-label col-xs-4 col-xs-offset-2" >Cancelar solicitudes:</label>
                        <button type="button" id="btnCancelar" class="btn btn-primary col-xs-8 inputMedium" name="btnCancelar">Cancelar solicitud</button><br/>
                    </div>
                    <div class="form-group row">
                        <label for="btnSalir" class="control-label col-xs-4 col-xs-offset-2" >Salir del sistema y cerrar sesión</label>
                        <button type="button" id="btnSalir" class="btn btn-danger col-xs-8 inputMedium" name="btnSalir">Salir</button><br/>
                    </div>
                </div>
            </fieldset>
        </article>
        <script src="libs/jquery-1.11.1.js"></script>
        <script src="libs/PortalSecretarios.js"></script>
        <script src="libs/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>
