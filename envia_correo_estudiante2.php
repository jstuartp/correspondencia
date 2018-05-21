<?php require_once('Connections/conexion.php'); 
RestringirAcceso("0,1,2,3,4,5,6,7,8,9,10,11");
?> <!-- accesso -->

<?php 
$el_oficio = GetSQLValueString ($_POST['oficio_id'], "int");
$el_correo = GetSQLValueString ( $_POST['correo'], "text");
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $config['titulo_del_sitio']; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <?php include ("includes/el_logo.php"); ?>  <!-- llamado al logo o información para personalizar el nombre del sitio WCG-->
        
        <!-- Header Navbar: style can be found in header.less -->
        
        <?php include ("includes/menu_header.php");?> <!-- llamado al menu del header principal -->
       <!-- Header Navbar: style can be found in header.less -->

      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <?php include("includes/menu_izq.php"); ?>   <!-- LLAMADO DEL MENU IZQUIERDA WCG -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Oficios de Entrada
            <?php echo $config['nombre_institucion'];?>    <!-- LLAMADO DEL TITULO UNIDAD PEQUEÑO -->
          </h1>
          <ol class="breadcrumb">
            <li><a href="bien.php"><i class="fa fa-dashboard"></i> Principal</a></li>
        
            <li class="active">Envio de correo recibido por email</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span>
                  <h3 class="box-title">Resultado de Asignación de oficio y envío de correo a: <?php echo $el_correo; ?></h3>
                </div><!-- /.box-header -->

                <div class="box-body">
					<!-- CODIGO PHPMAILER PARA EL ENVIO DE LOS CORREO A LOS USUARIOS ASIGNADOS -->
					<?php
						require("plugins/PHPMailer/class.phpmailer.php");
						// Creamos una nueva instancia
						$mail = new PHPMailer();
						// Activamos el servicio SMTP
						$mail->isSMTP();
						// Activamos / Desactivamos el "debug" de SMTP
						// 0 = Apagado
						// 1 = Mensaje de Cliente
						// 2 = Mensaje de Cliente y Servidor
						$mail->SMTPDebug = 2;
						// Log del debug SMTP en formato HTML
						$mail->Debugoutput = 'html';
						// Servidor SMTP
						$mail->Host = "smtp.ucr.ac.cr";
						// Puerto SMTP
						$mail->Port = 25;
						// Tipo de encriptacion SSL ya no se utiliza se recomienda TLS
						$mail->SMTPSecure = 'tls';
						// Si necesitamos autentificarnos
						$mail->SMTPAuth = true;
						// Usuario del correo desde el cual queremos enviar, para ejemplo
						$mail->Username = $config['usuario_correo'];
						// Contraseña
						$mail->Password = $config['pass_usuario'];

						// Conectamos a la base de datos
						$db = new mysqli($config ['hostname_con'], $config['username_con'], $config['password_con'], $config ['database_con']);
						if ($db->connect_errno > 0) {
							die('Imposible conectar [' . $db->connect_error . ']');
						}
						// Creamos la sentencias SQL 
						$el_oficio = $_POST['oficio_id'];
						$result = $db->query("SELECT * FROM info_oficios WHERE info_oficios.oficio_id =  $el_oficio");

						// Iniciamos el "bucle" para enviar multiples correos.
						while($row = $result->fetch_assoc()) {
							//Añadimos la direccion de quien envia el corre, en este caso Codejobs, primero el correo, luego el nombre de quien lo envia.
							$mail->SetFrom($config['correo'], $config['remitente']);
							// $mail->addAddress($row['email'], $row['nombre']); 
							$el_correo = $_POST['correo'];
							$mail->AddAddress( $el_correo); 
							//La linea de asunto
							$mail->Subject = $config['asunto_correo2'];
							$mail->IsHTML(true);
							$mail->CharSet = "utf-8";
							//$body = "<b>Mensaje de prueba favor de hacer caso omiso  </b>";
							$body = "Por este medio confirmamos haber recibido de su parte el documento adjunto. Este será tramitado a la mayor brevedad posible.<br><br>Muchas Gracias.";
							$mail->AddAttachment("imagenes/oficios_in/". $row['imagen'], $row['imagen']);
							$mail->Body = $body;
							//$mail->msgHTML(file_get_contents('contenido.html'), dirname(__FILE__)); 
							// Enviamos el Mensaje 
							$mail->send();
							// Borramos el destinatario, de esta forma nuestros clientes no ven los correos de las otras personas y parece que fuera un único correo para ellos. 
							$mail->ClearAddresses(); 
						}
					?>
					<br>
					<form action="./listado_total_oficios_entrada_anno.php" method="post">
						<button type="submit" name="anno" value="<?php echo date("Y"); ?>" class="btn-link" style="font-size: 14pt; font-weight: bold;">Regresar</button>
					</form>
                </div><!-- /.box-body -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
    </div><!-- ./wrapper -->

	<!-- jQuery 2.1.4 -->
	<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<!-- Bootstrap 3.3.5 -->
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<!-- DataTables -->
	<script src="plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
	<!-- SlimScroll -->
	<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
	<!-- FastClick -->
	<script src="plugins/fastclick/fastclick.min.js"></script>
	<!-- AdminLTE App -->
	<script src="dist/js/app.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="dist/js/demo.js"></script>
	<!-- page script -->

  </body>
</html>

<?php
//AÑADIR AL FINAL DE LA PÁGINA
mysqli_free_result($result);
?>
