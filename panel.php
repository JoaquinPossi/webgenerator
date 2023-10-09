<?php 
session_start();
if(!isset($_SESSION['Usuario'])){
	header("Location: login.php");
}else{
	include "TEMPLATES/credencial.php";
	$ssql__webs  = 'SELECT * FROM `webs`';
	$response__webs= $db ->query($ssql__webs);
	if (isset($_GET['btnSubmit'])) {
		$nombre_web = $_SESSION['Usuario']['idUsuario'] . $_GET['txtContenido'];
		$existe=false;
		while ($fila__webs = $response__webs->fetch_array(MYSQLI_ASSOC)) {
			if ($fila__webs["dominio"] == $nombre_web){
				$existe=true;
				break;
			}
		}
		if(!$existe){
			$idusuario=$_SESSION['Usuario']['idUsuario'];
			$fecha=date("Y-m-d H:i:s");
			$conn = mysqli_connect(HOST, USER, PASS, DB);
			$sql = "INSERT INTO `webs`(`idWeb`, `idUsuario`, `dominio`, `fechaCreacion`) VALUES (NULL,'$idusuario','$nombre_web','$fecha')";
			if (mysqli_query($conn, $sql)) {
			      echo "New record created successfully";
			} else { 
			      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
			mysqli_close($conn);
			shell_exec("./wix.sh ".$nombre_web);
			header("Location: http://mattprofe.com.ar:81/alumno/3856/ACTIVIDADES/CLASE_11/panel.php");
		}
	}
	if (isset($_GET['btnSubzip'])) {
		shell_exec('zip '.$_GET['btnSubzip']." webs/".$_GET['btnSubzip']);
		shell_exec('mv '.$_GET['btnSubzip'].".zip zips/".$_GET['btnSubzip']);
		header("Location: http://mattprofe.com.ar:81/alumno/3856/ACTIVIDADES/CLASE_11/zips/".$_GET['btnSubzip']);
	}
	if (isset($_GET['btnBorrar'])) {
		shell_exec('rm -r webs/'.$_GET['btnBorrar']);
		$conn = mysqli_connect(HOST, USER, PASS, DB);
		$aux=$_GET['idBorrar'];
		$sql = "DELETE FROM webs WHERE `webs`.`idWeb` = $aux";
		if (mysqli_query($conn, $sql)) {
		      echo "New record created successfully";
		} else { 
		      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		mysqli_close($conn);
		header("Location: http://mattprofe.com.ar:81/alumno/3856/ACTIVIDADES/CLASE_11/panel.php");
	}
}

 ?> 
<!DOCTYPE html> 
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Bienvenido a tu panel</title>
	<link rel="stylesheet" href="CSS/yoru-styles.css">
	<link rel="stylesheet" href="CSS/footer_style.css">
	<link rel="icon" href="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/6b116697-d7bd-48c1-996d-826f5e0e87b4/df9lw2z-3290d8b2-859b-41b0-a021-0deedf12e8e3.jpg?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcLzZiMTE2Njk3LWQ3YmQtNDhjMS05OTZkLTgyNmY1ZTBlODdiNFwvZGY5bHcyei0zMjkwZDhiMi04NTliLTQxYjAtYTAyMS0wZGVlZGYxMmU4ZTMuanBnIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.gMpMoaPiAQCkwRujuweti8o-PEAdPamwupbxEeph6nI">
</head>
<body >
	<div id="wrapper_panel">
		<div class="barramenu treinta" style="border-right: solid #033a42;">

			<a href="panel.php" class="Opciones_Menu">Inicio</a>
		 	<a href="#" class="Opciones_Menu">Priscila</a>
			<a href="logout.php" class="Opciones_Menu">Cerrar</a>
			<a href="logout.php" class="Opciones_Menu">Sesion</a>
		</div>
		<div class="body__centro" >
			<form class="evento">
				<div style="padding: 1.5vw; background: #080b12;">
					<div class="evento__header">
						<span style="color: white;    font-size: 2rem;    font-family: monospace;">
							Generar Web de:
						</span>
					</div>
					<div class="evento__contenido">
						<input class="input__contenido" type="text" name="txtContenido" placeholder="Ingresar nombre de la web" required>
					</div>
					<div class="evento__body" style="margin-top: 2vw;">
						
						<div class="evento__guardar">
							<label for="Crear_Web" >Crear web</label><input id="Crear_Web"  type="submit" name="btnSubmit" value="Agregar" style="display: none;">
						</div>
					</div>	
				</div>
			</form>
			<?php 
			while ($fila__webs = $response__webs->fetch_array(MYSQLI_ASSOC)) {
				if ($_SESSION['Usuario']['email'] == "admin@server.com" && $_SESSION['Usuario']['password'] == "serveradmin") {
					echo '
						<form class="evento">
							<div style="padding: 1.5vw; background: #080b12;">
								<div class="evento__header">
									<a href="webs/'.$fila__webs["dominio"].'" style="color: white;    font-size: 2rem;    font-family: monospace;">
										'.$fila__webs["dominio"].'
									</a>
								</div>
								<div class="evento__contenido">
									<label for="Agregar_link'.$fila__webs["idWeb"].'" >Descargar web</label><input id="Agregar_link'.$fila__webs["idWeb"].'"  type="submit" name="btnSubzip" value="'.$fila__webs["dominio"].'" style="display: none;">
								</div>
								<div class="evento__body" style="margin-top: 2vw;">
									<div class="evento__guardar">
										<label for="Borrar_link'.$fila__webs["idWeb"].'" >Borrar web</label><input id="Borrar_link'.$fila__webs["idWeb"].'"  type="submit" name="btnBorrar" value="'.$fila__webs["dominio"].'" style="display: none;">
										<input type="text" name="idBorrar" style="display:none;" value="'.$fila__webs["idWeb"].'">
									</div>
									
								</div>	
							</div>
						</form>';
				}else{
					if ($fila__webs["idUsuario"] == $_SESSION['Usuario']['idUsuario']){
						echo '
						<form class="evento">
							<div style="padding: 1.5vw; background: #080b12;">
								<div class="evento__header">
									<a href="webs/'.$fila__webs["dominio"].'" style="color: white;    font-size: 2rem;    font-family: monospace;">
										'.$fila__webs["dominio"].'
									</a>
								</div>
								<div class="evento__contenido">
									<label for="Agregar_link'.$fila__webs["idWeb"].'" >Descargar web</label><input id="Agregar_link'.$fila__webs["idWeb"].'"  type="submit" name="btnSubzip" value="'.$fila__webs["dominio"].'" style="display: none;">
								</div>
								<div class="evento__body" style="margin-top: 2vw;">
									<div class="evento__guardar">
										<label for="Borrar_link'.$fila__webs["idWeb"].'" >Borrar web</label><input id="Borrar_link'.$fila__webs["idWeb"].'"  type="submit" name="btnBorrar" value="'.$fila__webs["dominio"].'" style="display: none;">
										<input type="text" name="idBorrar" style="display:none;" value="'.$fila__webs["idWeb"].'">
									</div>
									
								</div>	
							</div>
						</form>';
					}
				}
			}
			 ?>
		</div>
		<div class="barramenu none" style="border-left: solid #033a42;">
			
		</div>
	</div>
<?php include "footer.html"; ?>