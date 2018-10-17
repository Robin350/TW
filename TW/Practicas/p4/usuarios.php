<?php
	require_once 'funciones/validaciones.php';
	
	$email = isset($_POST['email']) ? $_POST['email'] : null;
	$pass = isset($_POST['pass']) ? $_POST['pass'] : null;
	


?>

<!DOCTYPE>
<html>
	<head>
			<title> Inicio sesion </title>
		  <meta http-equiv="Content-Type" content="text/html"; charset=utf-8"/>
	</head>
	<body>
		<form action="usuarios.php" method="post">
			<label>Email: </label>
			<input type="email" name="email" value="<?php echo $email ?>"/>
			<br/><br/>
			<label>Contrasenia</label>
			<input type="password" name="pass" value="<?php echo $pass ?>"/>Camisa
			
			<br/><br/><input type="submit" value="Iniciar sesion"/>
			<br/><input type="hidden" name="submitted" value="true"/>
		</form>
	</body>
</html>
