<?
    require_once '../OperacionesIntraloans.php';
    $auxOperacionesIntra = new OpIntraloans();
    $registros = $auxOperacionesIntra->recuperaStatusSolicitud($_POST['hiddenUsuario']);
    echo json_encode($registros);
?>