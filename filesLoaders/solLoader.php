<?php
    if((!empty($_FILES['file'])) && ($_FILES['file']['error']==0)){
        
        $filename = basename($_FILES['file']['name']);
        $ext = substr($filename, strrpos($filename, '.') + 1);
        $auxDirectory = '../doctos/Exp_' . $_POST['rFCEmpleado'];
        $newName = $_POST['formType'] . "_" . $_POST['rFCEmpleado'] . "_" . $_POST['folioSolicitud'] . "." . $ext;
        $fullNameDir = $auxDirectory . '/' . $newName;
        
        if(!is_dir($auxDirectory)){
            mkdir($auxDirectory);
        }
        
        switch($_POST['formType']){
            case 'Solicitud':
                 if($ext == "pdf"){
                    if(!file_exists($fullNameDir)) { 
                        if((move_uploaded_file($_FILES['file']['tmp_name'], $fullNameDir))){
                            //echo "Carga Completa!!";
                            echo $fullNameDir;
                        } else {
                            echo "Error: No se pudo cargar el archivo.";
                        }
                    } else {
                        echo "Error: El archivo ya se encuentra cargado en el sistema";
                    }
                } else {          
                    echo "Error: El archivo seleccionado no es valido. Verifica que sea un archivo con extension 'pdf'";
                }
            break;
            case 'ImgIFE':
            case 'ImgDomicilio':
            case 'ImgTalon':
            case 'ImgCLABE':
                if($ext == "jpg"){
                    if(!file_exists($fullNameDir)) { 
                        if((move_uploaded_file($_FILES['file']['tmp_name'], $fullNameDir))){
                            echo $fullNameDir;
                        } else {
                            echo "Error: No se pudo cargar el archivo.";
                        }
                    } else {
                        echo "Error: El archivo ya se encuentra cargado en el sistema";
                    }
                } else {          
                    echo "Error: El archivo seleccionado no es valido. Verifica que sea un archivo con extension 'jpg'";
                }
            break;
            default:
                echo "Ha ocurrido un error, no se identifica la accion seleccionada";
        }   
    } else {
        echo "Error: No seleccionaste un archivo.";
    }
?>

