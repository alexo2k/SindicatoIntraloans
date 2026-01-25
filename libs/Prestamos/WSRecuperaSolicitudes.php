<?
    session_start();
    require_once '../OperacionesIntraloans.php';
    $operacionesBD = new OpIntraloans();
    $timeStampDate = date("d-m-Y",time());
    
    if($_POST['requestType'] == 'retrieveAll'){
        $registros = $operacionesBD->recuperaSolStatus('ENVIADO');
        echo json_encode($registros);
    } else if ($_POST['requestType'] == 'acceptRequest') {
        //$resultado = $operacionesBD->cambiaStatusSolicitud("ACEPTADA", $_POST['requestNumber'], $_POST['hiddenUsuario'], '');
        $resultado = $operacionesBD->cambiaStatusSolicitud("ACEPTADA", $_POST['requestNumber'], $_POST['hiddenUsuario'], '', $timeStampDate);
        echo $resultado;
    } else if($_POST['requestType'] == 'downloadRequest'){
        $rutaArchivo = $operacionesBD->recuperaRuta($_POST['requestNumber'], $_POST['requestFile']);
        echo $rutaArchivo;
    } else if($_POST['requestType'] == 'rejectRequest'){
        //$resultado = $operacionesBD->cambiaStatusSolicitud("RECHAZADA", $_POST['requestNumber'], $_POST['hiddenUsuario'], $_POST['rejectReason']);
        $resultado = $operacionesBD->cambiaStatusSolicitud("RECHAZADA", $_POST['requestNumber'], $_POST['hiddenUsuario'], $_POST['rejectReason'], $timeStampDate);
        echo $resultado;
    } else if ($_POST['requestType'] == 'getRepository'){
        $resultado = $operacionesBD->accesaRepositorio($_POST['rfcRequest']);
        echo json_encode($resultado);
    }
    
?>