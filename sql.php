<?php
include("conexion.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'librerias/phpmailer/Exception.php';
require 'librerias/phpmailer/PHPMailer.php';
require 'librerias/phpmailer/SMTP.php';

$configuracion = mysql_fetch_array(mysql_query("SELECT * FROM configuracion WHERE conf_id=1", $conexion));

//RESPONDER ENCUESTA DE SATISFACCIÓN
if ($_POST["idSql"] == 1) {
	if ($_POST["p1"] == "" or $_POST["p2"] == "" or $_POST["p3"] == "" or $_POST["p4"] == "" or $_POST["p5"] == "") {
?>
		<span style='font-family:Arial; color:black; text-align:center;'>
			Debes esoger una opci&oacute;n para cada pregunta.<br>
			<a href="javascript:history.go(-1);">[Regresar]</a>
			</samp>
		<?php
		exit();
	}
	mysql_query("UPDATE encuesta_satisfaccion SET encs_p1='" . $_POST["p1"] . "', encs_p2='" . $_POST["p2"] . "', encs_p3='" . $_POST["p3"] . "', encs_p4='" . $_POST["p4"] . "', encs_p5='" . $_POST["p5"] . "', encs_observaciones='" . $_POST["observaciones"] . "' WHERE encs_id='" . $_POST["id"] . "'", $conexion);
	if (mysql_errno() != 0) {
		echo mysql_error();
		exit();
	}
		?>

		<span style='font-family:Arial; color:black; text-align:center;'>MUCHAS GRACIAS POR TOMARSE EL TIEMPO PARA RESPONDER ESTA BREVE ENCUESTA.</samp>
			<script type="text/javascript">
				function sacar() {
					window.close();
				}
				setInterval('sacar()', 5000);
			</script>
		<?php
		exit();
	}

	//RECUPERAR LA CLAVE
	if ($_POST["idSql"] == 2) {
		$emailD = mysql_fetch_array(mysql_query("SELECT * FROM usuarios WHERE usr_email='" . $_POST["email"] . "'", $conexion));
		if ($emailD[0] != "") {

			$nuevaClave = rand(10000, 99999);

			mysql_query("UPDATE usuarios SET  usr_clave=SHA1('" . $nuevaClave . "') WHERE usr_id='" . $emailD['usr_id'] . "'", $conexion);
			if (mysql_errno() != 0) {
				echo mysql_error();
				exit();
			}

			$fin =  '<html><body style="background-color:#E6E6E6;">';
			$fin .= '
					<center>
						<div style="font-family:arial; background:#FFF; width:600px; color:#000; text-align:justify; padding:15px; border-radius:10px;">
							Hola!<br>
							' . strtoupper($emailD['usr_nombre']) . ', a continuación sus datos de acceso son los siguientes:<br>
							<b>Usuario:</b> ' . $emailD['usr_login'] . '<br>
							<b>Contraseña:</b> ' . $nuevaClave . '<br>

							Recomendamos cambiar la clave asignada automáticamente por una que usted recuerde más fácilmente.<br><br>
							
							Muchas gracias por utilizar nuestra plataforma!.
							<p align="center" style="color:#399;">
								¡Que tengas un excelente d&iacute;a!
							</p>
						</div>
					</center>
					<p>&nbsp;</p>
				';
			$fin .= '';
			$fin .=  '<html><body>';


			// Instantiation and passing `true` enables exceptions
			$mail = new PHPMailer(true);
			echo '<div style="display:none;">';
			try {
				$mail->SMTPDebug = 2;                                       // Enable verbose debug output
				$mail->isSMTP();                                            // Set mailer to use SMTP
				$mail->Host       = 'mail.orioncrm.com.co';  // Specify main and backup SMTP servers
				$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
				$mail->Username   = $configuracion['conf_email'];                     // SMTP username
				$mail->Password   = $configuracion['conf_clave_correo'];                              // SMTP password
				$mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
				$mail->Port       = 465;                                    // TCP port to connect to

				//Recipients
				$mail->setFrom($configuracion['conf_email'], 'JMEQUIPOS');
				$mail->addAddress($emailD['usr_email'], $emailD['usr_nombre']);     // Add a recipient


				// Content
				$mail->isHTML(true);                                  // Set email format to HTML
				$mail->Subject = 'CRM ORIÓN - Credenciales de acceso';
				$mail->Body = $fin;
				$mail->CharSet = 'UTF-8';

				$mail->send();
			} catch (Exception $e) {
				echo "Error: {$mail->ErrorInfo}";
			}
			echo '</div>';

			echo '<script type="text/javascript">window.location.href="recuperar-clave.php?msg=1";</script>';
			exit();
		} else {
			echo '<script type="text/javascript">window.location.href="recuperar-clave.php?msg=2";</script>';
			exit();
		}
	}

		?>