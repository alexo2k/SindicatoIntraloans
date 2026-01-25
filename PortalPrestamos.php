<?php
session_start();
require_once 'libs/OperacionesIntraloans.php';

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    if($_GET['salir']=='true'){
            session_destroy();
    } else{
       if(isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn'] == "true")){
            if($_SESSION['AreaTrabajo'] == 'PRESTAMOS') {
                header('Location: PortalFinanzas.php');
            } else {
                header('Location: PortalSecretarios.php');
            }        
        }
    } 
}

/*
if(isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn'] == "true")){
    if($_SESSION['AreaTrabajo'] == 'PRESTAMOS') {
        header('Location: PortalFinanzas.php');
    } else {
        header('Location: PortalSecretarios.php');
    }    
}*/

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    try{
        $auxOperaciones = new OpIntraloans();
        $numeroEmpleado = $auxOperaciones->recuperaId($_POST['txtUsuario'], $_POST['txtPassword']);

        if ($numeroEmpleado > 0) {
            $_SESSION['idEmpleado'] = $numeroEmpleado;
            $_SESSION['loggedIn'] = "true";
            $_SESSION['timeOut'] = time();

            $numeroEmpleado = $auxOperaciones->recuperaInformacion($numeroEmpleado);

            if($numeroEmpleado > 0) {
                if($_SESSION['AreaTrabajo'] == 'PRESTAMOS') {
                    header('Location: PortalFinanzas.php');
                    } else {
                    header('Location: PortalSecretarios.php');
                    }
            } else {
                $mensaje = "El usuario no se encuentra en el sistema o bien, no tiene permisos de acceso";
            }

            die("No se pudo redirigir al portal.");

        } else {
            $mensaje = "La clave no es correcta";
        }
    } catch(Exception $ex){
        die("Ocurrio un error: " . $ex->getMessage());
    }
}

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Intraloans</title>
        <link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/IntraloansStyle.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <header class="container">
            <div class="jumbotron text-center fontColorLabel" style="background:rgb(133, 133, 136) !important">
                <h1>Intraloans</h1>
                <h2>Sistema de administración de préstamos</h2>
            </div>
            
        </header>
        <section>
            <div class="container">
                <form id="formularioLogin" action="PortalPrestamos.php" method="post">
                    <div class="form-group row">
                        <div class="col-md-offset-4 col-md-4 ">
                            <label for="txtUsuario" class="fontColorLabel"><span class="glyphicon glyphicon-user"></span> Usuario</label><br />
                            <input type="text" name="txtUsuario" id="txtUsuario" class="form-control" placeholder="Ingresa tu usuario" required="required" autocomplete="off" min="3" pattern="[a-zA-Z]+" /><br/>
                            <label for="txtPassword" class="fontColorLabel"><span class="glyphicon glyphicon-eye-open"></span> Password</label><br/>
                            <input type="password" name="txtPassword" id="txtPassword" class="form-control" placeholder="Ingresa tu contraseña" required="required" autocomplete="off" min="3" pattern="[a-zA-Z0-9]+" /><br />
                            <button type="submit" class="btn btn-success btn-lg"> <span class="glyphicon glyphicon-log-in"></span> Accesar</button>
                            <button type="button" id="btnCancelar" class="btn btn-danger btn-lg "> <span class="glyphicon glyphicon-remove"> </span> Salir</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="container">
                <p id="error" class="alert-danger"><? echo $mensaje ?></p>
            </div>
        </section>
        <script src="libs/jquery-1.11.1.js" type="text/javascript"></script>
        <script src="libs/PortalPrestamos.js"></script>
        <script src="libs/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>
