<?php

session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
$usuario = $_SESSION['UserLogin'];
$estadoUsuario = $_SESSION['AreaTrabajo'];
require_once 'OperacionesIntraloans.php';

    if((!empty($_FILES['requestFile'])) && (!empty($_FILES['ifeFile'])) && (!empty($_FILES['addressFile'])) && (!empty($_FILES['checkFile'])) && (!empty($_FILES['clabeFile']))){
        
        $auxOperacionesBD = new OpIntraloans();
        $rfcEmployee = $_POST['rFCEmpleado'];
        // $folioNumber = $_POST['folioSolicitud'];

        $folioDisplay = $_POST['folioSolicitud'];
        $folioFs = isset($_POST['folioFs']) ? $_POST['folioFs'] : $folioDisplay;
        $folioPart = substr($folioDisplay, strrpos($folioDisplay, '/') + 1);
        $folioDb = (string) intval($folioPart);

        
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
        $auxTimestampFile = date('Ymd_His');
        
        $finalRequestFileName = 'Solicitud_' . $rfcEmployee . '_' . $folioFs . '_' . $auxTimestampFile . '.'  . $extRequestFileName;
        $finalIfeFileName = 'ImgIfe_' . $rfcEmployee . '_' . $folioFs . '_' . $auxTimestampFile . '.' . $extIfeFileName;
        $finalAddressFileName = 'ImgDireccion_' . $rfcEmployee . '_' . $folioFs . '_' . $auxTimestampFile . '.' . $extAddressFileName;
        $finalCheckFileName = 'ImgTalon_' . $rfcEmployee . '_' . $folioFs . '_' . $auxTimestampFile . '.' . $extCheckFileName;
        $finalClabeFileName = 'ImgClabe_' . $rfcEmployee . '_' . $folioFs . '_' . $auxTimestampFile . '.' . $extClabeFileName;
        
        // Previous code
        // $finalRequestFileName = 'Solicitud_' . $rfcEmployee . '_' . $folioNumber . '_' . $auxTimestampFile . '.'  . $extRequestFileName;
        // $finalIfeFileName = 'ImgIfe_' . $rfcEmployee . '_' . $folioNumber . '_' . $auxTimestampFile . '.' . $extIfeFileName;
        // $finalAddressFileName = 'ImgDireccion_' . $rfcEmployee . '_' . $folioNumber . '_' . $auxTimestampFile . '.' . $extAddressFileName;
        // $finalCheckFileName = 'ImgTalon_' . $rfcEmployee . '_' . $folioNumber . '_' . $auxTimestampFile . '.' . $extCheckFileName;
        // $finalClabeFileName = 'ImgClabe_' . $rfcEmployee . '_' . $folioNumber . '_' . $auxTimestampFile . '.' . $extClabeFileName;

        /*
        $finalRequestFileName = 'Solicitud_' . $rfcEmployee . '_' . $folioNumber . '.' . $extRequestFileName;
        $finalIfeFileName = 'ImgIfe_' . $rfcEmployee . '_' . $folioNumber . '.' . $extIfeFileName;
        $finalAddressFileName = 'ImgDireccion_' . $rfcEmployee . '_' . $folioNumber . '.' . $extAddressFileName;
        $finalCheckFileName = 'ImgTalon_' . $rfcEmployee . '_' . $folioNumber . '.' . $extCheckFileName;
        $finalClabeFileName = 'ImgClabe_' . $rfcEmployee . '_' . $folioNumber . '.' . $extClabeFileName; */
        
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
                                                                    
                                                                    $idDatosPersonales = null;
                                                                    $idDomicilio = null;
                                                                    $idRepositorio = null;
                                                                    $idSolicitudCompleta = null;
                                                                    
                                                                    $bufferJson = json_decode($_POST['jsonTest'], true);
                                                                    
                                                                    $formDatosPersonales = array(                                                
                                                                        'ApPaterno' => $bufferJson['datosPersonales']['apPaterno'],
                                                                        'ApMaterno' => $bufferJson['datosPersonales']['apMaterno'],
                                                                        'Nombre' => $bufferJson['datosPersonales']['nombre'],
                                                                        'RFC' => $bufferJson['datosPersonales']['rFC']
                                                                    );
                                                                    
                                                                    $formDomicilio = array(
                                                                        'Estado' => $bufferJson['datosDomiciliarios']['EntidadFederativa'],
                                                                        'Ciudad' => $bufferJson['datosDomiciliarios']['delMun'],
                                                                        'Colonia' => $bufferJson['datosDomiciliarios']['colonia'],
                                                                        'Calle' => $bufferJson['datosDomiciliarios']['calle'],
                                                                        'NumExterior' => $bufferJson['datosDomiciliarios']['numExt'],
                                                                        'NumInterior' => $bufferJson['datosDomiciliarios']['numInt'],
                                                                        'NumTelefono' => $bufferJson['datosDomiciliarios']['telefono'],
                                                                        'CodigoPostal' => $bufferJson['datosDomiciliarios']['codigoPostal'],
                                                                        'DelMunicipio' => $bufferJson['datosDomiciliarios']['delMun']
                                                                    );
                                                                    
                                                                    $formRepositorio = array(
                                                                        //'DirectorioRaiz' => $auxDirRepository,
                                                                        'DirectorioRaiz' => '/intraloans/doctos/Exp_' . $rfcEmployee,
                                                                        //'DirectorioRaiz' => 'www.sntsepomex/'
                                                                        'ArchivoIfe' => $finalIfeFileName,
                                                                        'ArchivoTalonPago' => $finalCheckFileName,
                                                                        'ArchivoCLABE' => $finalClabeFileName,
                                                                        'ArchivoDomicilio' => $finalAddressFileName,
                                                                        'ArchivoFormato' => $finalRequestFileName
                                                                    );
                                                                    
                                                                    try{
                                                                        //Insertar o recuperar Datos Personales
                                                                        $idDatosPersonales = $auxOperacionesBD->verificaExistenciaDatosPersonales($bufferJson['datosPersonales']['rFC']);
                                                                        
                                                                        if($idDatosPersonales == 0){
                                                                            $idDatosPersonales = $auxOperacionesBD->insertaDatos('DatosPersonales',$formDatosPersonales);
                                                                        }
                                                                        
                                                                        //Insertar Domicilio
                                                                        
                                                                        $idDomicilio = $auxOperacionesBD->insertaDatos('Domicilio', $formDomicilio);
                                                                        
                                                                        //Verificar si existe directorio e insertar rutas
                                                                        
                                                                        $idRepositorio = $auxOperacionesBD->verificaExistenciaRutas($auxDirRepository);
                                                                        
                                                                        if($idRepositorio > 0) {
                                                                            $auxResultado = $auxOperacionesBD->actualizaRepositorio($idRepositorio, $formRepositorio['ArchivoFormato'], $formRepositorio['ArchivoIfe'], $formRepositorio['ArchivoDomicilio'], $formRepositorio['ArchivoTalonPago'], $formRepositorio['ArchivoCLABE']);
                                                                        } else {
                                                                            $idRepositorio = $auxOperacionesBD->insertaDatos('Repositorio', $formRepositorio);
                                                                        }
                                                                        
                                                                        //Generar solicitud y cargar
                                                                        
                                                                        $formSolicitudCompleta = array(
                                                                            'Id_DatosPersonales' => $idDatosPersonales,
                                                                            'Id_Domicilio' => $idDomicilio,
                                                                            'Id_Repositorio' => $idRepositorio,
                                                                            'UsuarioSolicitante' => $usuario,
                                                                            'Puesto' => $bufferJson['datosLaborales']['puesto'],
                                                                            'Oficina' => $bufferJson['datosLaborales']['oficina'],
                                                                            'Folio' => $folioDb,
                                                                            //'Folio' => $_POST['folioSolicitud'],
                                                                            // 'Folio' => $bufferJson['folio'],
                                                                            //'Folio' => substr($bufferJson['folio'], -3),
                                                                            'CodigoNumero' => $bufferJson['datosLaborales']['codNumAnalitico'],
                                                                            'Clabe' => $bufferJson['clabe'],
                                                                            'Banco' => $bufferJson['banco'],
                                                                            'FechaIngreso' => $bufferJson['datosLaborales']['fechaIngreso'],
                                                                            'FechaSolicitud' => $bufferJson['fechaSolicitud'],
                                                                            'FechaAutorizacion' => 'null',
                                                                            'FechaRechazo' => 'null',
                                                                            'StatusSolicitud' => 'ENVIADO',
                                                                            'Comentarios' => $bufferJson['comentarios']
                                                                        );
                                                                        
                                                                        $idSolicitudCompleta = $auxOperacionesBD->insertaDatos('Solicitud', $formSolicitudCompleta);
                                                                        //$auxOperacionesBD->cambiaFolio($usuario, ltrim($folioNumber,'0'));
                                                                        $nuevoFolio = $auxOperacionesBD->actualizaFolio($estadoUsuario);
                                                                        //Insertar aqui el cambio de folio
                                                                        
                                                                        echo "Solicitud almacenada con exito => $idSolicitudCompleta";
                                                                       
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