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
	<title>APP-Webgenerator Joaquin Possi</title>
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
				<a href="register.php" class="btn_index">Registrarme</a>
			</div>
			<div id="texto_landing">
				<form action="" method="GET" class="login_form">
					<input class="txt" type="text" name="txtMail" placeholder="Ingrese un email o correo electronico" required="">
					<input class="txt" type="password" name="txtContra" placeholder="Ingrese su contraseña" required="">
					<input type="submit" name="btnSubmit" value="Iniciar Sesion" class="boton_iniciar">
				</form>
				<?php 
				if (isset($_GET['btnSubmit'])) {
					include "TEMPLATES/credencial.php";
					$ssql__usuarios  = 'SELECT * FROM `usuarios`';
					$response__usuarios= $db ->query($ssql__usuarios);
					$mensaje = "Usuario no encontrado";
					while ($fila__usuarios = $response__usuarios->fetch_array(MYSQLI_ASSOC)) {
						if ($fila__usuarios["email"] == $_GET['txtMail']){
							if ($fila__usuarios["password"] == $_GET['txtContra']) {
								$_SESSION['Usuario'] = $fila__usuarios;
								header("Location: panel.php");
							}else{
								$mensaje = "Contraseña Incorrecta";
								break;
							}
						}
					}
					echo '<h1 style="position: absolute; top: 0; font-size: 30px; left: 10px;">'.$mensaje.'</h1>';
				} 
				?>
			</div>
		</div>
		<div id="foto">
			<img src="IMG/fondo.jpg" id="imagen__index">
		</div>
	</div>
			
<?php include "footer.html"; ?>