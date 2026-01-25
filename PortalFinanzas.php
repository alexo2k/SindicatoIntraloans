<?php
    session_start();
    
    if(!isset($_SESSION['loggedIn']) || ($_SESSION['loggedIn']!= "true") || ($_SESSION['timeOut'] + 10 * 60 < time())){
        session_destroy();
        header('Location: PortalPrestamos.php');  
    }
?>

<html lang="ES">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Portal del personal de préstamos</title>
        <link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/IntraloansStyle.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <header class="container">
            <h2 class="text-center well">Bienvenido al portal del área de préstamos</h2>
            <h4 class="text-center well text-capitalize">Usuario: <? echo $_SESSION['ApPaterno'] . ' ' . $_SESSION['ApMaterno'] . ' ' . $_SESSION['Nombre'] . "<br/>"?> Rol: <? echo 'Administrador de Prestamos' ?></h4>
        </header>
        
        <div class="container-fluid col-xs-offset-2 col-xs-8">
            <fieldset class="panel panel-primary">
                <div class="panel-heading">
                    <h4>Selecciona una opción:</h4>
                </div>
                <div class="panel-body form-horizontal">
                    <div class="form-group row">
                        <label for="btnConsultaSol" class="col-xs-4 col-xs-offset-1 control-label">Mostrar nuevas solicitudes:</label>
                        <button type="button" id="btnConsultaSol" class="btn btn-primary col-xs-8 inputMedium" name="btnMostrar">Nuevas solicitudes</button><br/>
                    </div>
                    <div class="form-group row">
                        <label for="btnEstadisticas" class="col-xs-4 col-xs-offset-1 control-label">Estadísticas de solicitudes:</label>
                        <button type="button" id="btnEstadisticas" class="btn btn-primary col-xs-8 inputMedium"  name="btnEstadisticas">Mostrar Estadísticas</button><br/>
                    </div>
                    <div class="form-group row">
                        <label for="btnRepositorio" class="col-xs-4 col-xs-offset-1 control-label">Acceder al Repositorio:</label>
                        <button type="button" id="btnRepositorio"  class="btn btn-primary col-xs-8 inputMedium" name="btnRepositorio">Repositorio</button><br/>  
                    </div>
                    <div class="form-group row">
                        <label class="col-xs-4 col-xs-offset-1 control-label">Bloquear/Desbloquear solicitudes:</label>
                        <button type="button" id="btnBloquear" class="btn btn-primary col-xs-8 inputMedium" name="btnBloquear">Bloquear / Desbloquear</button><br/>
                    </div>
                    <div class="form-group row">
                        <label for="btnSalir" class="col-xs-4 col-xs-offset-1 control-label">Salir del sistema y cerrar sesión</label>
                        <button type="button" id="btnSalir" class="btn btn-danger col-xs-8 inputMedium" name="btnSalir">Salir</button>
                    </div>
                </div>
            </fieldset>
        </div>
        <script src="libs/jquery-1.11.1.js" type="text/javascript"></script>
        <script src="libs/Prestamos/PortalFinanzas.js" type="text/javascript"></script>
    </body>
</html>
