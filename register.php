<?php 
session_start();
if(isset($_SESSION['Usuario'])){
	header("Location: panel.php");
}
?>

<!DOCTYPE html> 
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registrarte es simple.</title>
	<link rel="stylesheet" href="CSS/yoru-styles.css">
	<link rel="stylesheet" href="CSS/footer_style.css">
	<link rel="icon" href="https://64.media.tumblr.com/fadcf421df5d75b7daf165f327de42c4/bf28b0f7ae74ef7b-f2/s540x810/b0b071f8e92f4c0e9a82b9daa5ef70124efb3700.jpg">
</head>
<body >
	<div id="wrapper" class="flex-direction">
		<div id="landing">
			<div id="logo">
				<a href="" style="font-size: 5rem;    color: #d7f0f7;    text-decoration: none;    font-family: monospace;">CAT>WEB</a>
			</div>

			<div id="control">
				<a href=".." class="btn_index">Volver</a>
				<a href="login.php" class="btn_index">Ingresar</a>
			</div>
			<div id="texto_landing">
				<form action="" method="GET" class="login_form">
					<input class="txt" type="text" name="txtMail" placeholder="Ingrese un email o correo electronico" required="">
					<input class="txt" type="password" name="txtContra" placeholder="Ingrese su contraseña" required="">
					<input class="txt" type="password" name="txtContra2" placeholder="Confirme su contraseña" required="">
					<input type="submit" name="btnSubmit" value="Registrarme" class="boton_iniciar">
			<?php 
				if (isset($_GET['btnSubmit'])) {
					$pass = $_GET['txtContra'];
					$pas = $_GET['txtContra2'];
					$mai = $_GET['txtMail'];
					$date = date("Y-m-d H:i:s");
					if ($pas != $pass) {
						echo '<h1 style="position: absolute; top: 0; font-size: 30px; left: 10px;">Las contraseñas deben ser iguales!</h1>';
					}else{
						$servername = "mattprofe.com.ar";
						$database = "3856";
						$username = "3856";
						$password = "gallo.alamo.puerta";
						$conn = mysqli_connect($servername, $username, $password, $database);
						include "TEMPLATES/credencial.php";
						$ssql__usuarios  = 'SELECT * FROM `usuarios`';
						$response__usuarios= $db ->query($ssql__usuarios);
						$existe = false;
						while ($fila__usuarios = $response__usuarios->fetch_array(MYSQLI_ASSOC)) {
							if ($fila__usuarios["email"] == $_GET['txtMail']){
								$existe = true;
								break;
							}
						}
						if ($existe) {
							echo "Ese mail ya esta en uso";
						}else{
							if (!$conn) {
								die("Connection failed: " . mysqli_connect_error());
							}
							echo "Connected successfully";
							$sql = "INSERT INTO `usuarios`(`idUsuario`, `email`, `password`, `fechaRegistro`) VALUES (NULL,'$mai','$pas','$date')";
							if (mysqli_query($conn, $sql)) {
							      echo "New record created successfully";
							} else { 
							      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
							}
							mysqli_close($conn);
							header("Location: login.php");
						}
					}

				}

				?>
				</form>
			</div>
		</div>
		<div id="foto">
			<img src="IMG/fondo.jpg" id="imagen__index">
		</div>
	</div>
			
<?php include "footer.html"; ?>