<?php
session_start();
require_once 'OperacionesIntraloans.php';

    if((!empty($_FILES['requestFile'])) && (!empty($_FILES['ifeFile'])) && (!empty($_FILES['addressFile'])) && (!empty($_FILES['checkFile'])) && (!empty($_FILES['clabeFile']))){
 
        $rfcEmployee = $_POST['rFCEmpleado'];
        $folioNumber = $_POST['folioSolicitud'];
        
        $requestFileName = basename($_FILES['requestFile']['name']);
        $ifeFileName = basename($_FILES['ifeFile']['name']);
        $addressFileName = basename($_FILES['addressFile']['name']);
        $checkFileName = basename($_FILES['checkFile']['name']);
        $clabeFileName = basename($_FILES['clabeFile']['name']);
        
        $extRequestFileName = substr($requestFileName, strrpos($requestFileName, '.') + 1);
        $extIfeFileName = substr($ifeFileName, strrpos($ifeFileName, '.') + 1);
        $extAddressFileName =  substr($addressFileName, strrpos($addressFileName, '.') + 1);
        $extCheckFileName = substr($checkFileName, strrpos($checkFileName, '.') + 1);
        $extClabeFileName = substr($clabeFileName,  strrpos($clabeFileName, '.') + 1);
                
        $auxDirRepository = '../doctos/Exp_' . $rfcEmployee;
        $auxTimeStamp = date('Ymd_His');
        
        $finalRequestFileName = 'Solicitud_' . $rfcEmployee . '_' . $folioNumber . ('_') . $auxTimeStamp . '.' . $extRequestFileName;
        $finalIfeFileName = 'ImgIfe_' . $rfcEmployee . '_' . $folioNumber . ('_') . $auxTimeStamp . '.' . $extIfeFileName;
        $finalAddressFileName = 'ImgDireccion_' . $rfcEmployee . '_' . $folioNumber . ('_') . $auxTimeStamp . '.' . $extAddressFileName;
        $finalCheckFileName = 'ImgTalon_' . $rfcEmployee . '_' . $folioNumber . ('_') . $auxTimeStamp . '.' . $extCheckFileName;
        $finalClabeFileName = 'ImgClabe_' . $rfcEmployee . '_' . $folioNumber . ('_') . $auxTimeStamp . '.' . $extClabeFileName;
        
        if(!is_dir($auxDirRepository)){
            mkdir($auxDirRepository);
        }
        
        if($extRequestFileName == 'pdf'){
            if(!file_exists($auxDirRepository . '/' . $finalRequestFileName)){
                if($extIfeFileName == 'jpg'){
                    if(!file_exists($auxDirRepository . '/' . $finalIfeFileName)){
                        if($extAddressFileName == 'jpg'){
                            if(!file_exists($auxDirRepository . '/' . $finalAddressFileName)){
                                if($extCheckFileName == 'jpg'){
                                    if(!file_exists($auxDirRepository . '/' . $finalCheckFileName)){
                                        if($extClabeFileName == 'jpg'){
                                            if(!file_exists($auxDirRepository . '/' . $finalClabeFileName)){
                                                if(move_uploaded_file($_FILES['requestFile']['tmp_name'], $auxDirRepository . '/' . $finalRequestFileName)){
                                                    if(move_uploaded_file($_FILES['ifeFile']['tmp_name'], $auxDirRepository . '/' . $finalIfeFileName)){
                                                        if(move_uploaded_file($_FILES['addressFile']['tmp_name'], $auxDirRepository . '/' . $finalAddressFileName)){
                                                            if(move_uploaded_file($_FILES['checkFile']['tmp_name'], $auxDirRepository . '/' . $finalCheckFileName)){
                                                                if(move_uploaded_file($_FILES['clabeFile']['tmp_name'], $auxDirRepository . '/' . $finalClabeFileName)){
                                                                    
                                                                    $auxOperacionesBD = new OpIntraloans();
                                                                    $bufferJson = json_decode($_POST['jsonTest'], true);
                                                                    
                                                                    $formDatosPersonales = array(
                                                                        'ApPaterno' => $bufferJson['datosPersonales']['apPaterno'],
                                                                        'ApMaterno' => $bufferJson['datosPersonales']['apMaterno'],
                                                                        'Nombre' => $bufferJson['datosPersonales']['nombre'],
                                                                        'RFC' => $bufferJson['datosPersonales']['rFC']
                                                                    );
                                                                    
                                                                    try{
                                                                        $auxResponse = $auxOperaciones->insertaDatos('datospersonales',$formDatosPersonales);
                                                                        echo "Identificador=> " . $auxResponse;
                                                                    } catch(Exception $e){
                                                                        echo "Ocurrio un error=> " . $e->getMessage();
                                                                    }
                                          
                                                                }else{
                                                                    echo 'ERROR: No se pudo cargar la clave interbancaria ';
                                                                }
                                                            }else{
                                                                echo 'ERROR: No se pudo cargar el talon de pago.';
                                                            }
                                                        } else {
                                                            echo 'ERROR: No se pudo cargar el comprobante de domicilio';
                                                        }
                                                    } else {
                                                        echo 'ERROR: No se pudo cargar la credencial de elector';
                                                    }
                                                } else {
                                                    echo 'ERROR: No se pudo cargar el archivo de la solicitud';
                                                }
                                            } 
                                            else{
                                                echo 'ERROR: El comprobante de la clave interbancaria (CLABE) ya se encuentra en el sistema';
                                            }
                                        }else{
                                            echo 'ERROR: El archivo de la clave interbancaria no es una imagen';
                                        }
                                    } else {
                                        echo 'ERROR: El talón de pago ya se encuentra cargado en el sistema';
                                    }
                                } else {
                                    echo 'ERROR: El archivo del talón de pago no es una imagen.';
                                }
                            } else {
                                echo 'ERROR: El comprobante de domicilio ya se encuentra cargado en el sistema.';
                            }
                        } else {
                            echo 'ERROR: El archivo del comprobante de domicilio no es una imagen.';
                        }
                    } else {
                        echo 'ERROR : La imagen de la credencial de elector (IFE) ya se encuentra en el sistema.';
                    }
                } else {
                    echo 'ERROR: El archivo de la credencial de elector (IFE) no es una imagen.';
                }
            } else {
                echo 'ERROR: La solicitud ya se encuentra dentro del sistema.';
            }
        } else{
            echo 'ERROR: La solicitud enviada no es un archivo pdf.';
        }
    }
?>