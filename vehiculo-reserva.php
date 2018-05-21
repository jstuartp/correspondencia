<?php require_once('Connections/conexion.php'); 
RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10,11") ?>
<?php


$el_usuario = obtenerNombre($_SESSION ['reservas_UserId']);

$resultado=ComprobarFechasLibresPista($_GET["id"], $_GET["FDesde"], $_GET["FHasta"], $_GET["direccion"], $_GET['fecha_reserva']);

$horastotales=CalcularHorasDiferencia(DateToQuotedMySQLDate($_GET["FDesde"]), DateToQuotedMySQLDate($_GET["FHasta"]));
$horasdereserva = $horastotales/60/60;
//EVITAMOS QUE EL USUARIO INTENTE CONTRATAR ALGO QUE YA ESTÁ RESERVADO
if ($resultado!="1") {

  header("Location: error-acceso.php");

} else {


$insertSQL = sprintf("INSERT INTO tblreservapista(refUsuario, refPropietario, refPropiedad, fchFechaDesde, fchFechaFin, intEstado, dblTotal, direccion) VALUES (%s, %s,%s, %s, %s, 1, %s, %s)",
                       GetSQLValueString($_SESSION['reservas_UserId'], "int"),
                       GetSQLValueString($_GET["FPropietario"], "int"),
                       GetSQLValueString($_GET["id"], "int"),
                       GetSQLValueString(DateToQuotedMySQLDate($_GET["FDesde"]).":00", "date"),
                       GetSQLValueString(DateToQuotedMySQLDate($_GET["FHasta"]).":00", "date"),
             GetSQLValueString($_GET["FPrecio"]*$horasdereserva, "double"),
              GetSQLValueString($_GET["direccion"], "text"));

//echo $insertSQL;  
  $Result1 = mysqli_query($con,  $insertSQL) or die(mysqli_error($con));
$id_reserva = mysqli_insert_id($con);
  ?>
  <form name="_xclick" action="<?php echo $config['direccion_server']?>/reservacion_calendario.php?id=<?php echo GetSQLValueString($_GET["id"], "int")?>" method="post"  role="form" > <!-- MODO DESARROLLO -->
   
   
   <?php
        
    
        
        
        
        require("plugins/PHPMailer/class.phpmailer.php");
        $mail = new PHPMailer();
        $mail->IsSMTP(); 
        $mail->Host = "smtp.ucr.ac.cr";
        $mail->SMTPAuth   = true;                  // enable SMTP authentication
        $mail->Port       = 25;                    // set the SMTP port for the GMAIL server
        $mail->Username   = $config['usuario_correo']; // SMTP account username ejemplo      odi.secretaria"
        $mail->Password   = $config['pass_usuario'];       // 
        $mail->SetLanguage("es", "utiles/PHPMailer/language/");
        $mail->From = $config['correo'];
        $mail->SetFrom($config['correo'], "Universidad de Costa Rica");
        $mail->FromName = "Universidad de Costa Rica";
      
        
        $mail->Subject = $config['asunto_reservacion'];  
        
        
        $mail->AddAddress( ObtieneCorreoParaEnvio(GetSQLValueString($_GET["FPropietario"], "int")), ObtieneCorreoParaEnvio(GetSQLValueString($_GET["FPropietario"], "int")));         
      
        $mail->IsHTML(true);
    
        $mail->CharSet = "utf-8";   
        
                
        // WCG PASAMOS A UNA VARIABLE LA SESION PARA OBTENER MEDIANTE FUNCION EL NOMBRE DEL USUARIO /////
        //$numero_usuario= obtenerNombre($_SESSION['reservas_UserId'], "int"); 
        //$el_usuario = obtenerNombre($_SESSION ['reservas_UserId']);
        
        $body =isset($_REQUEST['body']);

        if (!empty($el_usuario)){
        $body .= "<font color='green' size='+2'>Usted fue asignado por el usuario: " . $el_usuario. "</font><br>"; }
        $body .= "<font color='red' size='+3'>Para la siguiente actividad: " .GetSQLValueString($_GET["direccion"], "text"). "</font><br>";
        $body .= "<font color='red'>Desde las: " . GetSQLValueString(DateToQuotedMySQLDate($_GET["FDesde"]).":00", "date"). "</font><br>";
        $body .= "<font color='orange'>Hasta las: " . GetSQLValueString(DateToQuotedMySQLDate($_GET["FHasta"]).":00", "date"). "</font><br>";
        
        $fecha_de_la_reserva = ObtieneNumeroReserva($id_reserva); 
        $body .= "<font color='red'>Insertado en sistema el día: " . $fecha_de_la_reserva. "</font><br>";
        
                   
        $mail->Body = $body;
        //$mail->AltBody = "Hola amigo\nprobando PHPMailer\n\nSaludos";
                          
        $mail->Send();
        
        }
        ?>
            

            
            
<script>
  document._xclick.submit();
</script>
      

</form>