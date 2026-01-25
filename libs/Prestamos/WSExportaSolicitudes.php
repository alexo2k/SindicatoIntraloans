<?
    session_start();
    require_once '../OperacionesIntraloans.php';
    $auxOperacionesIntra = new OpIntraloans();
    
    $registros = $auxOperacionesIntra->recuperaSolStatusDate($_POST['requestStatus'], $_POST['rangoInicial'], $_POST['rangoFinal']);
    //$registros = $auxOperacionesIntra->recuperaSolStatusDate('ALL', '2015-01-01', '2015-12-12');

    echo json_encode($registros);
?>