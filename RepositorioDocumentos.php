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
        <title>Repositorio Intraloans</title>
        <link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/IntraloansStyle.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <header class="container-fluid">
            <div class="well text-center wellWhiteSmoke">
                <h4>Repositorio de Documentos</h4>
            </div>
        </header>
        <div class="container-fluid">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <input type="text" id="txtSearchRepos" name="txtSearchRepos" class="col-xs-4 form-control inputMedium" autocomplete="off" placeholder="Introduce el RFC del Trabajador"/>
                    <button type="button" id="btnSearchRepos" name="btnSearchRepos" class="btn btn-info" style="height: 34px; width: 34px;"><span class="glyphicon glyphicon-search"></span></button>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover smallFont">
                            <thead>
                                <tr>
                                    <th>Apellido Paterno</th>
                                    <th>Apellido Materno</th>
                                    <th>Nombre</th>
                                    <th>RFC</th>
                                    <th>Oficina</th>
                                    <th>Documentos</th>
                                </tr>
                            </thead>
                            <tbody id="tblRepos">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="button" id="btnReposBorrar" class="btn btn-primary btn-sm">Limpiar <p class="glyphicon glyphicon-erase"></p></button>
                    <button type="button" id="btnReposRegresar" class="btn btn-success btn-sm">Salir <p class="glyphicon glyphicon-log-out"></p></button>
                </div>
            </div>
        </div>        
    </body>
    <script src="libs/jquery-1.11.1.js" type="text/javascript"></script>
    <script src="libs/Prestamos/RepositorioDocumentos.js" type="text/javascript"></script>
    <script src="libs/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</html>
