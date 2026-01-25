<?
    session_start();
    require_once '../OperacionesIntraloans.php';
    $auxOperacionesIntra = new OpIntraloans();
    
    if($_POST['requestOption'] == 'bloquear'){
        $resultado = $auxOperacionesIntra->bloqueaSolicitudes();
    } else if($_POST['requestOption'] == 'desbloquear') {
        $resultado = $auxOperacionesIntra->desbloqueaSolicitudes();
    }
?>