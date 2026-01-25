<?
    require_once '../OperacionesIntraloans.php';
    $auxOperacionesIntra = new OpIntraloans();
    
    if($_POST['operacionBD'] == 'recuperaInfo') {
        $registros = $auxOperacionesIntra->recuperaStatusPendientes($_POST['hiddenUsuario']);
        echo json_encode($registros);
    } else if($_POST['operacionBD'] == 'eliminaSolicitud'){
        $resultado = $auxOperacionesIntra->eliminaSolicitud($_POST['hiddenUsuario'], $_POST['folioSolicitud']);
        if($resultado == '0' || $resultado == 0){
            echo "La solicitud con folio " + $_POST['folioSolicitud'] + " ha sido eliminada con éxito.";
        } else {
            echo "No se ha podido eliminar el registro. Favor de contactar al área de sistemas.";
        }
    }
?>
