<?php
    session_start();
    
    class OpIntraloans{
        
        protected $servidor;
        protected $usuario;
        protected $contrasena;
        protected $baseDeDatos;
        
        public function __construct() 
        {
            //inicializamos propiedades
            //$this->servidor = '127.0.0.1';
            //$this->usuario = 'root';
            //$this->contrasena = 'eti11$$';
            //$this->baseDeDatos = 'interloansdev';
            
            //Base de datos original
            // $this->servidor = 'localhost';
            // $this->usuario = 'sntsep5_intraUsr';
            // $this->contrasena = 'intraloansUser2015';
            // $this->baseDeDatos = 'sntsep5_intraloansDB';

            //Base de datos clon
            $this->servidor = 'localhost';
            $this->usuario = 'prestUsr';
            $this->contrasena = 'prestamos2026';
            $this->baseDeDatos = 'sntsep5_prestamosDB_2025';
        }
        
        public function cadenaConexion(){
            return 'server=' . $this->servidor . ';User Id=' . $this->usuario . ';Password=\'' . $this->contrasena .'\';Database=' . $this->baseDeDatos . ';';
        }
        
        public function desbloqueaSolicitudes(){
            $streamBD = mysql_connect($this->servidor,$this->usuario,$this->contrasena);
            
            if(!$streamBD)
            {
                die('No pudo conectarse: ' . mysql_error());
            }
            
            try{
                 mysql_select_db($this->baseDeDatos, $streamBD) or die('No se pudo conectar a la base de Préstamos');
                 $resultado = mysql_query("UPDATE Credenciales SET Activo = 1 WHERE NOT AreaTrabajo = 'PRESTAMOS';");
                 mysql_close($streamBD);
                 return $resultado;
                 
            } catch(Exception $e){
                 mysql_close($streamBD);
                 throw new Exception('Ocurrio un error al desbloquear las solicitudes: ' + $e->getMessage());
            }
        }
        
        public function bloqueaSolicitudes(){
             $streamBD = mysql_connect($this->servidor,$this->usuario,$this->contrasena);
            
            if(!$streamBD)
            {
                die('No pudo conectarse: ' . mysql_error());
            }
            
            try{
                 mysql_select_db($this->baseDeDatos, $streamBD) or die('No se pudo conectar a la base de Préstamos');
                 $resultado = mysql_query("UPDATE Credenciales SET Activo = 0 WHERE NOT AreaTrabajo = 'PRESTAMOS';");
                 mysql_close($streamBD);
                 return $resultado;
                 
            } catch(Exception $e){
                 mysql_close($streamBD);
                 throw new Exception('Ocurrio un error al bloquear las solicitudes: ' + $e->getMessage());
            }
        }
        
        public function recuperaStatusBloqueo(){
            $streamBD = mysql_connect($this->servidor,$this->usuario,$this->contrasena);
            
            if(!$streamBD)
            {
                die('No pudo conectarse: ' . mysql_error());
            }
            
            try{
                 mysql_select_db($this->baseDeDatos, $streamBD) or die('No se pudo conectar a la base de Préstamos');
                 $resultado = mysql_query("Select Activo from Credenciales where Id_Credencial = 1");
                 $statusBloqueo = mysql_result($resultado, 0);
                 mysql_close($streamBD);
                 return $statusBloqueo;
                 
            } catch(Exception $e){
                 mysql_close($streamBD);
                 throw new Exception('Ocurrio un error al recuperar el status del bloqueo: ' + $e->getMessage());
            }
        }
        
        
        
        //public function cambiaStatusSolicitud($pOperacion, $pFolio, $pUsuario, $pRazonRechazo){
        public function cambiaStatusSolicitud($pOperacion, $pFolio, $pUsuario, $pRazonRechazo, $pFechaQuery){

            $streamBD = mysql_connect($this->servidor,$this->usuario,$this->contrasena);
            
            if(!$streamBD)
            {
                die('No pudo conectarse: ' . mysql_error());
            }
            
            try{   
                mysql_select_db($this->baseDeDatos, $streamBD) or die('No se pudo conectar a la base de Préstamos');
                //$resultado = mysql_query("UPDATE Solicitud SET StatusSolicitud = '$pOperacion', Comentarios = CONCAT(Comentarios, '_" . $pUsuario . "_" . "$pRazonRechazo') WHERE Folio = $pFolio;");
                
                if($pOperacion == "ACEPTADA"){
                    $sqlStatement = "UPDATE Solicitud SET StatusSolicitud = '$pOperacion', FechaAutorizacion = '$pFechaQuery', Comentarios = CONCAT(Comentarios, '_" . $pUsuario . "_" . "$pRazonRechazo') WHERE Folio = '$pFolio';";
                } else {
                    $sqlStatement = "UPDATE Solicitud SET StatusSolicitud = '$pOperacion', FechaRechazo = '$pFechaQuery', Comentarios = CONCAT(Comentarios, '_" . $pUsuario . "_" . "$pRazonRechazo') WHERE Folio = '$pFolio';";
                }
                
                $resultado = mysql_query($sqlStatement);
                mysql_close($streamBD);
                return $resultado;
                
            } catch(Exception $e){
                mysql_close($streamBD);
                 throw new Exception('Ocurrio un error al cambiar el status de la Solicitud: ' + $e->getMessage());
            }
        }
        
        public function recuperaRuta($pFolio, $pDocumento){
            $streamBD = mysql_connect($this->servidor,$this->usuario,$this->contrasena);
            
            $auxDocumento = '';
            
            switch($pDocumento){
                case 'IFE':
                    $auxDocumento = 'ArchivoIFE';
                    break;
                case 'Talon':
                    $auxDocumento = 'ArchivoTalonPago';
                    break;
                case 'CLABE' : 
                    $auxDocumento = 'ArchivoCLABE';
                    break;
                case 'Domicilio' :
                    $auxDocumento = 'ArchivoDomicilio';
                    break;
                case 'Request' :
                    $auxDomicilio = 'ArchivoFormato';
                    break;
                default:
                    $auxDomicilio = 'ArchivoFormato';
            }
            
            if(!$streamBD)
            {
                die('No pudo conectarse: ' . mysql_error());
            }
            
            try
            {
                mysql_select_db($this->baseDeDatos, $streamBD) or die('No se pudo conectar a la base de Préstamos');
           
                $resultado = mysql_query("Select rep.DirectorioRaiz AS 'RootDir', rep.$auxDocumento AS 'FileName' from Repositorio rep, Solicitud sol WHERE rep.Id_Repositorio = sol.Id_Repositorio and sol.Folio = $pFolio;");
                
                while($auxBuffer = mysql_fetch_array($resultado)){
                    $responseDir = $auxBuffer['RootDir'] . '/' . $auxBuffer['FileName'];
                }
                
                mysql_close($streamBD);
                return $responseDir;
            } 
            catch(Exception $e)
            {
                mysql_close($streamBD);
                throw new Exception('Ocurrio un error al intentar validar las credenciales: ' + $e->getMessage());
            }
        }
        
        public function eliminaSolicitud($userLoginID, $numFolio){
            
            $streamBD = mysql_connect($this->servidor,$this->usuario,$this->contrasena);
            
            if(!$streamBD)
            {
                die('No pudo conectarse: ' . mysql_error());
            }
            
            try
            {
                $baseseleccionada = mysql_select_db($this->baseDeDatos, $streamBD) or die('No se pudo conectar a la base de Préstamos');
           
                $resultado = mysql_query("SELECT EliminaSolicitud('$userLoginID','$numFolio') NumResultado");
                $registro = mysql_fetch_array($resultado);
                $queryResult = $registro['NumResultado'];
                mysql_close($streamBD);
                
                return $queryResult;
            } 
            catch(Exception $e)
            {
                mysql_close($streamBD);
                throw new Exception('Ocurrio un error al intentar validar las credenciales: ' + $e->getMessage());
            }
  
        }
        
        public function recuperaSolStatusDate($pStatus, $pInicialDate, $pFinalDate){
            $streamBD = mysql_connect($this->servidor, $this->usuario, $this->contrasena);
            $sqlStatement = "";
            if(!$streamBD){
                die('No se pudo realizar la conexion: ' . mysql_error());
            }
            
            try{
                mysql_select_db($this->baseDeDatos, $streamBD) or die('No se pudo conectar a la base de Préstamos');
                
                if($pStatus == 'ALL'){
                    $sqlStatement = "Select sol.Folio AS 'Folio', datPer.ApPaterno AS 'Paterno', datPer.ApMaterno AS 'Materno', datPer.Nombre AS 'Nombre', datPer.RFC AS 'RFC', sol.Oficina AS 'Oficina', DATE_FORMAT(sol.FechaSolicitud, '%d/%m/%Y') AS 'FechaSolicitud', sol.Comentarios AS 'Comentarios', sol.StatusSolicitud AS 'Status', sol.UsuarioSolicitante AS 'Solicitante', cred.AreaTrabajo AS 'Estado' FROM Solicitud sol, DatosPersonales datPer, Credenciales cred WHERE datPer.Id_DatosPersonales = sol.Id_DatosPersonales AND sol.UsuarioSolicitante = cred.UserLogin AND sol.FechaSolicitud BETWEEN '$pInicialDate' AND '$pFinalDate'";
                } else if($pStatus == 'RECHAZADA'){
                    $sqlStatement = "Select sol.Folio AS 'Folio', datPer.ApPaterno AS 'Paterno', datPer.ApMaterno AS 'Materno', datPer.Nombre AS 'Nombre', datPer.RFC AS 'RFC', sol.Oficina AS 'Oficina', DATE_FORMAT(sol.FechaSolicitud, '%d/%m/%Y') AS 'FechaSolicitud', sol.Comentarios AS 'Comentarios', sol.StatusSolicitud AS 'Status', sol.UsuarioSolicitante AS 'Solicitante', cred.AreaTrabajo AS 'Estado' FROM Solicitud sol, DatosPersonales datPer, Credenciales cred WHERE datPer.Id_DatosPersonales = sol.Id_DatosPersonales AND sol.UsuarioSolicitante = cred.UserLogin AND sol.StatusSolicitud = '$pStatus' AND sol.FechaSolicitud BETWEEN '$pInicialDate' AND '$pFinalDate'";
                } else if($pStatus == 'APROBADA') {
                    $sqlStatement = "Select sol.Folio AS 'Folio', datPer.ApPaterno AS 'Paterno', datPer.ApMaterno AS 'Materno', datPer.Nombre AS 'Nombre', datPer.RFC AS 'RFC', sol.Oficina AS 'Oficina', DATE_FORMAT(sol.FechaSolicitud, '%d/%m/%Y') AS 'FechaSolicitud', sol.Comentarios AS 'Comentarios', sol.StatusSolicitud AS 'Status', sol.UsuarioSolicitante AS 'Solicitante', cred.AreaTrabajo AS 'Estado' FROM Solicitud sol, DatosPersonales datPer, Credenciales cred WHERE datPer.Id_DatosPersonales = sol.Id_DatosPersonales AND sol.UsuarioSolicitante = cred.UserLogin AND sol.StatusSolicitud = '$pStatus' AND sol.FechaSolicitud BETWEEN '$pInicialDate' AND '$pFinalDate'"; 
                } else if($pStatus == 'ENVIADO'){
                    $sqlStatement = "Select sol.Folio AS 'Folio', datPer.ApPaterno AS 'Paterno', datPer.ApMaterno AS 'Materno', datPer.Nombre AS 'Nombre', datPer.RFC AS 'RFC', sol.Oficina AS 'Oficina', DATE_FORMAT(sol.FechaSolicitud, '%d/%m/%Y') AS 'FechaSolicitud', sol.Comentarios AS 'Comentarios', sol.StatusSolicitud AS 'Status', sol.UsuarioSolicitante AS 'Solicitante', cred.AreaTrabajo AS 'Estado' FROM Solicitud sol, DatosPersonales datPer, Credenciales cred WHERE datPer.Id_DatosPersonales = sol.Id_DatosPersonales AND sol.UsuarioSolicitante = cred.UserLogin AND sol.StatusSolicitud = '$pStatus' AND sol.FechaSolicitud BETWEEN '$pInicialDate' AND '$pFinalDate'";
                }
                
                $resultado = mysql_query($sqlStatement);
                $arrayData = array();
                
                while($row = mysql_fetch_array($resultado)){
                    $arrayData[] = array(
                        'folio' => $row['Folio'],
                        'paterno' => $row['Paterno'],
                        'materno' => $row['Materno'],
                        'nombre' => $row['Nombre'],
                        'rfc' => $row['RFC'],
                        'oficina' => $row['Oficina'],
                        'fechaSolicitud' => $row['FechaSolicitud'],
                        'comentarios' => $row['Comentarios'],
                        'status' => $row['Status'],
                        'solicitante' => $row['Solicitante'],
                        'estado' => $row['Estado']
                    );
                }
                
                mysql_close($streamBD);
                
                return $arrayData;
                
            } catch(Exception $e){
                mysql_close($streamBD);
                throw new Exception("Ocurrio un error al recuperar el listado del status de las solicitudes. " . $e->getMessage());
            }
        }
        
        public function recuperaSolStatus($status){
            $streamBD = mysql_connect($this->servidor, $this->usuario, $this->contrasena);
            
            if(!$streamBD){
                die('No se pudo realizar la conexion: ' . mysql_error());
            }
            
            try{
                mysql_select_db($this->baseDeDatos, $streamBD) or die('No se pudo conectar a la base de Préstamos');
                //$sqlStatement = "Select sol.folio AS 'Folio', datPer.apPaterno AS 'Paterno', datPer.apMaterno AS 'Materno', datPer.Nombre AS 'Nombre', datPer.RFC AS 'RFC', sol.Oficina AS 'Oficina', DATE_FORMAT(sol.fechaSolicitud, '%d/%m/%Y') AS 'FechaSolicitud', SUBSTRING_INDEX(sol.comentarios, '_', 1) AS 'Monto', sol.StatusSolicitud AS 'Status', sol.UsuarioSolicitante AS 'Solicitante' FROM Solicitud sol, DatosPersonales datPer WHERE datPer.Id_DatosPersonales = sol.Id_DatosPersonales AND StatusSolicitud = '$status'";
                $sqlStatement = "Select sol.Folio AS 'Folio', datPer.ApPaterno AS 'Paterno', datPer.ApMaterno AS 'Materno', datPer.Nombre AS 'Nombre', datPer.RFC AS 'RFC', sol.Oficina AS 'Oficina', DATE_FORMAT(sol.FechaSolicitud, '%d/%m/%Y') AS 'FechaSolicitud', sol.Comentarios AS 'Comentarios', sol.StatusSolicitud AS 'Status', sol.UsuarioSolicitante AS 'Solicitante', repos.DirectorioRaiz AS 'RootDir', repos.ArchivoFormato AS 'RequestFile', repos.ArchivoIfe AS 'IfeFile', repos.ArchivoDomicilio AS 'AddressFile', repos.ArchivoTalonPago AS 'PaymentFile', repos.ArchivoCLABE AS 'ClabeFile' FROM Solicitud sol, DatosPersonales datPer, Repositorio repos WHERE datPer.Id_DatosPersonales = sol.Id_DatosPersonales AND sol.Id_Repositorio = repos.Id_Repositorio AND StatusSolicitud = '$status';";
                $resultado = mysql_query($sqlStatement);
                $arrayData = array();
                
                while($row = mysql_fetch_array($resultado)){
                    $arrayData[] = array(
                        'folio' => $row['Folio'],
                        'paterno' => $row['Paterno'],
                        'materno' => $row['Materno'],
                        'nombre' => $row['Nombre'],
                        'rFC' => $row['RFC'],
                        'oficina' => $row['Oficina'],
                        'fechaSolicitud' => $row['FechaSolicitud'],
                        'comentarios' => $row['Comentarios'],
                        'status' => $row['Status'],
                        'solicitante' => $row['Solicitante'],
                        'RootDir' => $row['RootDir'],
                        'RequestFile' => $row['RequestFile'],
                        'IfeFile' => $row['IfeFile'],
                        'AddressFile' => $row['AddressFile'],
                        'PaymentFile' => $row['PaymentFile'],
                        'ClabeFile' => $row['ClabeFile']
                    );
                }
                
                mysql_close($streamBD);
                
                return $arrayData;
                
            }catch(Exception $e){
                mysql_close($streamBD);
                throw new Exception("Ocurrio un error al actualizar el registro del repositorio. " . $e->getMessage());
            }
        }
        
        public function recuperaStatusPendientes($userLoginID){
            $streamBD = mysql_connect($this->servidor, $this->usuario, $this->contrasena);
            
            if(!$streamBD){
                die('No se pudo realizar la conexion: ' . mysql_error());
            }
            
            try{
                mysql_select_db($this->baseDeDatos, $streamBD) or die('No se pudo conectar a la base de Préstamos');
                $sqlStatement = "SELECT sol.Folio AS 'Folio', datper.ApPaterno AS 'Paterno', datper.ApMaterno AS 'Materno', datper.Nombre AS 'Nombre', datper.RFC AS 'RFC', sol.Oficina AS 'Oficina', DATE_FORMAT(sol.FechaIngreso, '%d/%m/%Y') AS 'FechaIngreso', DATE_FORMAT(sol.FechaSolicitud, '%d/%m/%Y') AS 'FechaSolicitud', sol.Comentarios as 'Comentarios', sol.StatusSolicitud AS 'Status' FROM Solicitud sol, DatosPersonales datper WHERE datper.Id_DatosPersonales = sol.Id_DatosPersonales AND sol.UsuarioSolicitante = '$userLoginID' AND sol.StatusSolicitud='ENVIADO'";
                $resultado = mysql_query($sqlStatement);
                $arrayData = array();
                
                while($row = mysql_fetch_array($resultado)){
                    $arrayData[] = array(
                        'folio' => $row['Folio'],
                        'paterno' => $row['Paterno'],
                        'materno' => $row['Materno'],
                        'nombre' => $row['Nombre'],
                        'rFC' => $row['RFC'],
                        'oficina' => $row['Oficina'],
                        'fechaIngreso' => $row['FechaIngreso'],
                        'fechaSolicitud' => $row['FechaSolicitud'],
                        'comentarios' => $row['Comentarios'],
                        'status' => $row['Status']
                    );
                }
                
                mysql_close($streamBD);
                return $arrayData;
                
            }catch(Exception $e){
                mysql_close($streamBD);
                throw new Exception("Ocurrio un error al actualizar el registro del repositorio. " . $e->getMessage());
            }
        }
        
        public function recuperaStatusSolicitud($userLoginID){
            $streamBD = mysql_connect($this->servidor, $this->usuario, $this->contrasena);
            
            if(!$streamBD){
                die('No se pudo realizar la conexion: ' . mysql_error());
            }
            
            try{
                mysql_select_db($this->baseDeDatos, $streamBD) or die('No se pudo conectar a la base de Préstamos');
                $sqlStatement = "SELECT sol.Folio AS 'Folio', datper.ApPaterno AS 'Paterno', datper.ApMaterno AS 'Materno', datper.Nombre AS 'Nombre', datper.RFC AS 'RFC', sol.Oficina AS 'Oficina', DATE_FORMAT(sol.FechaIngreso, '%d/%m/%Y') AS 'FechaIngreso', DATE_FORMAT(sol.FechaSolicitud, '%d/%m/%Y') AS 'FechaSolicitud', IF(sol.FechaAutorizacion > '0000-00-00', DATE_FORMAT(sol.FechaAutorizacion, '%d/%m/%Y'), DATE_FORMAT(sol.FechaRechazo, '%d/%m/%Y')) AS 'FechaMovimiento', sol.Comentarios as 'Comentarios', sol.StatusSolicitud AS 'Status' FROM Solicitud sol, DatosPersonales datper WHERE datper.Id_DatosPersonales = sol.Id_DatosPersonales AND sol.UsuarioSolicitante = '$userLoginID'";
                $resultado = mysql_query($sqlStatement);
                $arrayData = array();
                
                while($row = mysql_fetch_array($resultado)){
                    $arrayData[] = array(
                        'folio' => $row['Folio'],
                        'paterno' => $row['Paterno'],
                        'materno' => $row['Materno'],
                        'nombre' => $row['Nombre'],
                        'rFC' => $row['RFC'],
                        'oficina' => $row['Oficina'],
                        'fechaIngreso' => $row['FechaIngreso'],
                        'fechaSolicitud' => $row['FechaSolicitud'],
                        'fechaMovimiento' => $row['FechaMovimiento'],
                        'comentarios' => $row['Comentarios'],
                        'status' => $row['Status']
                    );
                }
                
                mysql_close($streamBD);
                return $arrayData;
                
            }catch(Exception $e){
                mysql_close($streamBD);
                throw new Exception("Ocurrio un error al actualizar el registro del repositorio. " . $e->getMessage());
            }
        }
        
        public function actualizaRepositorio($idRepositorio, $nombreSolicitud, $nombreIfe, $nombreDomicilio, $nombreTalon, $nombreClabe){
            $streamBD = mysql_connect($this->servidor, $this->usuario, $this->contrasena);
            
            if(!$streamBD){
                die('No se pudo realizar la conexion: ' . mysql_error());
            }
            
            try{
                mysql_select_db($this->baseDeDatos, $streamBD) or die('No se pudo conectar a la base de Préstamos');
                $sqlStatement = "UPDATE Repositorio SET ArchivoIFE = '" . $nombreIfe . "', ArchivoTalonPago = '" . $nombreTalon . "', ArchivoCLABE = '" . $nombreClabe . "', ArchivoDomicilio = '" . $nombreDomicilio . "', ArchivoFormato = '" . $nombreSolicitud . "' WHERE Id_Repositorio = " . $idRepositorio . ";";
                $resultado = mysql_query($sqlStatement);
                 mysql_close($streamBD);
                return $resultado;
                
            }catch(Exception $e){
                mysql_close($streamBD);
                throw new Exception("Ocurrio un error al actualizar el registro del repositorio. " . $e->getMessage());
            }
        }
        
        public function verificaExistenciaRutas($dirRaiz){
            $streamBD = mysql_connect($this->servidor, $this->usuario, $this->contrasena);
            
            if(!$streamBD){
                die('No se pudo realizar la conexion: ' . mysql_error());
            }
            
            try{
                mysql_select_db($this->baseDeDatos, $streamBD) or die('No se pudo conectar a la base de Préstamos');
                $sqlStatement = "SELECT Id_Repositorio FROM Repositorio where DirectorioRaiz = '" . $dirRaiz . "';";
                $resultado = mysql_query($sqlStatement);
                $auxNumRows = mysql_num_rows($resultado);
                if($auxNumRows > 0){
                    $auxBuffer = mysql_fetch_array($resultado);
                    mysql_close($streamBD);
                    return $auxBuffer['Id_Repositorio'];
                } else {
                    mysql_close($streamBD);
                    return 0;
                }
                
            } catch(Exception $e) {
                mysql_close($streamBD);
                throw new Exception("Ocurrio un error al verificar la existencia del directorio en la BD. " . $e->getMessage());
            }
        }
        
        public function verificaExistenciaDatosPersonales($rfcEmpleado){
            $streamBD = mysql_connect($this->servidor, $this->usuario, $this->contrasena);
            
            if(!$streamBD){
                die('No se pudo realizar la conexion: ' . mysql_error());
            }
            
            try{
                $baseseleccionada = mysql_select_db($this->baseDeDatos, $streamBD) or die('No se pudo conectar a la base de Préstamos');
                $sqlStatement = "SELECT Id_DatosPersonales FROM DatosPersonales WHERE RFC = '" . $rfcEmpleado . "';";
                $resultado = mysql_query($sqlStatement);
                $numeroRegistro = mysql_num_rows($resultado);
                
                if($numeroRegistro > 0){
                    $auxBuffer = mysql_fetch_array($resultado);
                    mysql_close($streamBD);
                    return $auxBuffer['Id_DatosPersonales'];
                } else {
                    mysql_close($streamBD);
                    return 0;
                }
                
            } catch(Exception $e){
                mysql_close($streamBD);
                throw new Exception("Ocurrio un error al acceder a la Base de Datos. ERR: " . $e->getMessage());
            }
        }
        
        public function actualizaFolio($estado){
            $nuevoFolio = 0;
            $streamBD = mysql_connect($this->servidor, $this->usuario, $this->contrasena);
             
             if(!streamBD){
                die('No se pudo realizar la conexion: ' . mysql_errno());
             }
             
             try {
                mysql_select_db($this->baseDeDatos, $streamBD) or die('No se pudo conectar a la base de Préstamos');
                $sqlStatement = "SELECT actualizaFolio('$estado') NuevoFolio;";
                $resultado = mysql_query($sqlStatement);
                $numeroRows = mysql_num_rows($resultado);
                
                if($numeroRows > 0){
                    
                    while($registro = mysql_fetch_array($resultado)){
                        $nuevoFolio = $registro['NuevoFolio'];
                    }
                    
                    mysql_close($streamBD);
                    return $nuevoFolio;
                    
                } else {
                    mysql_close($streamBD);
                    throw new Exception("Ya no hay folios disponibles. Consulta al administrador");
                }
                
             } catch(Exception $e){
                mysql_close($streamBD);
                throw new Exception('Ocurrio un error al recuperar el folio ' + $e->getMessage());
             }   
        }
        
        /*
        public function actualizaFolio($usuarioFolio){
            $nuevoFolio = 0;
            $streamBD = mysql_connect($this->servidor, $this->usuario, $this->contrasena);
             
             if(!streamBD){
                die('No se pudo realizar la conexion: ' . mysql_errno());
             }
             
             try {
                mysql_select_db($this->baseDeDatos, $streamBD) or die('No se pudo conectar a la base de Préstamos');
                $sqlStatement = "SELECT recuperaFolio('" . $usuarioFolio . "') NuevoFolio;";
                $resultado = mysql_query($sqlStatement);
                $numeroRows = mysql_num_rows($resultado);
                
                if($numeroRows > 0){
                    
                    while($registro = mysql_fetch_array($resultado)){
                        $nuevoFolio = $registro['NuevoFolio'];
                    }
                    
                    mysql_close($streamBD);
                    return $nuevoFolio;
                    
                } else {
                    mysql_close($streamBD);
                    throw new Exception("Ya no hay folios disponibles. Consulta al administrador");
                }
                
             } catch(Exception $e){
                mysql_close($streamBD);
                throw new Exception('Ocurrio un error al recuperar el folio ' + $e->getMessage());
             }   
        }*/
        
        public function cambiaFolio($usuarioFolio, $nuevoFolio){
            
            $streamBD = mysql_connect($this->servidor, $this->usuario, $this->contrasena);
            
            if(!$streamBD){
                die('No se pudo realizar la conexion: ' . mysql_error());
            }
            
            try{
                mysql_select_db($this->baseDeDatos, $streamBD) or die('No se pudo conectar a la base de Préstamos');
                $sqlStatement = "UPDATE Credenciales SET FolioInicial = $nuevoFolio WHERE UserLogin = '$usuarioFolio'";
                $resultado = mysql_query($sqlStatement);
                return $resultado;
                
            } catch(Exception $e){
                mysql_close($streamBD);
                throw new Exception('Ocurrio un error al actualizar el siguiente folio a asignar: ' + $e->getMessage());
            }
        }
        
        // alexo -> Obtener aqui el folio con el Edo
        public function obtenFolioEspecifico($areaTrabajo){
            
            $streamBD = mysql_connect($this->servidor, $this->usuario, $this->contrasena);
            
            if(!$streamBD){
                die('No se pudo realizar la conexion: ' . mysql_error());
            }
            
             try{
                mysql_select_db($this->baseDeDatos, $streamBD) or die('No se pudo conectar a la base de Préstamos');
                $sqlStatement = "SELECT FolioInicial FROM Credenciales WHERE AreaTrabajo = '$areaTrabajo'";
                $resultado = mysql_query($sqlStatement);
                $numeroRegistro = mysql_num_rows($resultado);
                
                if($numeroRegistro > 0){    
                    while($registro = mysql_fetch_array($resultado)){
                       $auxFolio = $registro['FolioInicial'];
                    }
                }
                
                mysql_close($streamBD);   
                
                return $auxFolio + 1;
                
            } catch(Exception $e){
                 mysql_close($streamBD);
                 throw new Exception('Ocurrio un error al recuperar el siguiente folio a asignar: ' + $e->getMessage());
            }
        }
        
        public function obtenFolioGeneral(){
            
            $streamBD = mysql_connect($this->servidor, $this->usuario, $this->contrasena);
            
            if(!$streamBD){
                die('No se pudo realizar la conexion: ' . mysql_error());
            }
            
             try{
                mysql_select_db($this->baseDeDatos, $streamBD) or die('No se pudo conectar a la base de Préstamos');
                $sqlStatement = "SELECT MAX(Folio) AS 'Folio' FROM Solicitud";
                $resultado = mysql_query($sqlStatement);
                $numeroRegistro = mysql_num_rows($resultado);
                
                if($numeroRegistro > 0){    
                    while($registro = mysql_fetch_array($resultado)){
                       $auxFolio = $registro['Folio'];
                    }
                }
                
                mysql_close($streamBD);   
                
                return $auxFolio + 1;
                
            } catch(Exception $e){
                 mysql_close($streamBD);
                 throw new Exception('Ocurrio un error al recuperar el siguiente folio a asignar: ' + $e->getMessage());
            }
        }
        
        public function obtenFolio($usuarioFolio){
            $auxFolio = 0;
            $auxFolioMaximo = 0;
            $streamBD = mysql_connect($this->servidor, $this->usuario, $this->contrasena);
            
            if(!$streamBD){
                die('No se pudo realizar la conexion: ' . mysql_error());
            }
            
            try{
                mysql_select_db($this->baseDeDatos, $streamBD) or die('No se pudo conectar a la base de Préstamos');
                $sqlStatement = "SELECT FolioInicial, FolioFinal FROM Credenciales WHERE UserLogin = '" . $usuarioFolio . "';";
                $resultado = mysql_query($sqlStatement);
                $numeroRegistro = mysql_num_rows($resultado);
                
                if($numeroRegistro > 0){
                    
                    while($registro = mysql_fetch_array($resultado)){
                       $auxFolio = $registro['FolioInicial'];
                       $auxFolioMaximo = $registro['FolioFinal'];
                    }
                    
                    mysql_close($streamBD);
                    
                    if($auxFolio < $auxFolioMaximo){
                        return $auxFolio + 1;
                    } else {
                        throw new Exception("Ya no hay folio disponibles, favor de contactar al area de sistemas.");
                    }
                    
                } else {
                    mysql_close($streamBD);
                    return $auxFolio;
                }
                
            } catch(Exception $e){
                 mysql_close($streamBD);
                 throw new Exception('Ocurrio un error al recuperar el siguiente folio a asignar: ' + $e->getMessage());
            }
        }
           
        public function insertaDatos($nombreTabla, $datosFormulario){
            $streamBD = mysql_connect($this->servidor, $this->usuario, $this->contrasena);
            
            if(!$streamBD){
                die('No se pudo realizar la conexion: ' . mysql_error());
            }
            
            try {
                $baseseleccionada = mysql_select_db($this->baseDeDatos, $streamBD) or die('No se pudo conectar a la base de Préstamos');
                $camposTabla = array_keys($datosFormulario);
                $sqlStatement = "INSERT INTO " . $nombreTabla . " (" . implode(',', $camposTabla) . ") VALUES ('" . implode("','", $datosFormulario) . "');";
                mysql_query($sqlStatement);
                $auxId = mysql_insert_id();
                mysql_close($streamBD);
                return $auxId;
                
            } catch(Exception $e) {
                mysql_close($streamBD);
                throw new Exception('Ocurrio un error al recuperar la informacion del usuario: ' + $e->getMessage());
            }
        }
        
        public function recuperaInformacion($IdEmpleado){
            $streamBD = mysql_connect($this->servidor,$this->usuario,$this->contrasena);
        
            if(!$streamBD){
                die('No pudo conectarse: ' . mysql_error());
            }
            
            try
            {
                $baseseleccionada = mysql_select_db($this->baseDeDatos, $streamBD) or die('No se pudo conectar a la base de Préstamos');
            
                $resultado = mysql_query('SELECT datPer.Nombre, datPer.ApPaterno, datPer.ApMaterno, cred.UserLogin, cred.AreaTrabajo FROM DatosPersonales datPer, Credenciales cred WHERE cred.Activo = true AND cred.Id_DatosPersonales = datPer.Id_DatosPersonales AND cred.Id_Credencial = ' . $IdEmpleado);
                
                $numeroRegistro = mysql_num_rows($resultado);
                
                if($numeroRegistro > 0) {
                    
                    while($registro = mysql_fetch_array($resultado))
                    {
                        $_SESSION['IdEmpleado'] = $IdEmpleado;
                        $_SESSION['ApPaterno'] = $registro{'ApPaterno'};
                        $_SESSION['ApMaterno'] = $registro{'ApMaterno'};
                        $_SESSION['Nombre'] = $registro{'Nombre'};
                        $_SESSION['UserLogin'] = $registro{'UserLogin'};
                        $_SESSION['AreaTrabajo'] = $registro{'AreaTrabajo'};
                    }
                    
                } else {
                    $IdEmpleado = 0;
                }
                
            } catch (Exception $e)
            {
               mysql_close($streamBD);
               throw new Exception('Ocurrio un error al recuperar la informacion del usuario: ' + $e->getMessage());
            }
            
            mysql_close($streamBD);
            
            return $IdEmpleado;
        }
        
        public function accesaRepositorio($rfcRepos){
            $streamBD = mysql_connect($this->servidor,$this->usuario,$this->contrasena);
            
            if(!$streamBD){
                die('No fue posible conectarse: ' . mysql_error());
            }
            
            try{
                mysql_select_db($this->baseDeDatos, $streamBD) or die('No fue posible conectar a la base de Prestamos');
            
                $sqlStatement = "SELECT dper.ApPaterno AS 'Paterno', dper.ApMaterno AS 'Materno', dper.Nombre AS 'Nombre', dper.RFC as 'RFC', sol.Oficina 'Oficina', repos.DirectorioRaiz AS 'RootDir', repos.ArchivoFormato AS 'RequestFile', repos.ArchivoIfe AS 'IfeFile', repos.ArchivoDomicilio AS 'AddressFile', repos.ArchivoTalonPago AS 'PaymentFile', repos.ArchivoCLABE AS 'ClabeFile' FROM Repositorio repos, Solicitud sol, DatosPersonales dper WHERE sol.Id_DatosPersonales = dper.Id_DatosPersonales AND sol.Id_Repositorio = repos.Id_Repositorio AND dper.RFC = '$rfcRepos'";
                $resultado = mysql_query($sqlStatement);
                $arrayData = array();
                
                while($row = mysql_fetch_array($resultado)){
                    $arrayData[] = array(
                        'paterno' => $row['Paterno'],
                        'materno' => $row['Materno'],
                        'nombre' => $row['Nombre'],
                        'rFC' => $row['RFC'],
                        'oficina' => $row['Oficina'],
                        'RootDir' => $row['RootDir'],
                        'RequestFile' => $row['RequestFile'],
                        'IfeFile' => $row['IfeFile'],
                        'AddressFile' => $row['AddressFile'],
                        'PaymentFile' => $row['PaymentFile'],
                        'ClabeFile' => $row['ClabeFile']
                    );
                }
                
                mysql_close($streamBD);
                return $arrayData;
                
            }catch(Exception $ex){
                mysql_close($streamBD);
                throw new Exception('Ocurrio un error al recuperar las rutas del repositorio. ERR:' . $ex->getMessage());
            }
        }
        
        public function recuperaID($passUsuario, $passContra) {
            $streamBD = mysql_connect($this->servidor,$this->usuario,$this->contrasena);
            
            if(!$streamBD)
            {
                die('No pudo conectarse: ' . mysql_error());
            }
            
            try
            {
                $baseseleccionada = mysql_select_db($this->baseDeDatos, $streamBD) or die('No se pudo conectar a la base de Préstamos');
           
                $resultado = mysql_query('SELECT ValidaCredencial(\'' . $passUsuario . '\',\'' . $passContra . '\') Id_Empleado');
                
                $numeroRegistro = mysql_num_rows($resultado);
                
                if($numeroRegistro > 0)
                {
                    while($registro = mysql_fetch_array($resultado))
                    {
                        $idEmpleado = $registro{'Id_Empleado'};                    
                    }
                }
                else 
                {
                    $idEmpleado = 0;
                }
            } 
            catch(Exception $e)
            {
                mysql_close($streamBD);
                throw new Exception('Ocurrio un error al intentar validar las credenciales: ' + $e->getMessage());
            }
            
            mysql_close($streamBD);
            
            return $idEmpleado;
        }
    }
?>
