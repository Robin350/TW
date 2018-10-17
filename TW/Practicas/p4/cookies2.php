<?php
	require_once 'funciones/validaciones.php';

	$talla = isset($_POST['talla']) ? $_POST['talla'] : null;
	$color = isset($_POST['color']) ? $_POST['color'] : null;
	if($_COOKIE['nombre']===null){
		header('Location: cookies1.php');
	}
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Valida que el campo nombre no esté vacío.
    if (!validarRequerido($talla)) {
        $errores[] = 'El campo talla es obligatorio.';
    }
    if (!validarRequerido($color)) {
        $errores[] = 'El campo color es obligatorio.';
    }
    if(!$errores){
		  
		  if(!validarEntero($talla)){
		  		$errores[] = 'El campo nombre solo puede contener letras y espacios.';
		  }
		  //Verifica si ha encontrado errores y de no haber redirige a la página con el mensaje de que pasó la validación.
		  if(!$errores){
		  		setcookie('talla',$_POST['talla']);
					setcookie('color', $_POST['color']);
		      header('Location: cookies3.php');
		      die();
		  }
		}
	}

?>
<!DOCTYPE>
<html>
	<head>
			<title> Comprar ropa </title>
		  <meta http-equiv="Content-Type" content="text/html"; charset=utf-8"/>
	</head>
	<body>
		<?php if ($errores): ?>
      <ul style="color: #f00;">
          <?php foreach ($errores as $error): ?>
              <li> <?php echo $error ?> </li>
          <?php endforeach; ?>
      </ul>
		<?php endif; ?>
		<form action="cookies2.php" method="post">
			<label>Talla</label>
			<input type="number" name="talla" value="<?php echo $talla ?>"/>
			<br/><br/>
			<label>Color</label>
			<input type="radio" name="color" value="rojo" <?php if(isset($_POST['color']) and 'rojo' == $_POST['color']) echo "checked"; ?>/>Rojo
			<input type="radio" name="color" value="verde" <?php if(isset($_POST['color']) and 'verde' == $_POST['color']) echo "checked"; ?>/>Verde
			<input type="radio" name="color" value="azul" <?php if(isset($_POST['color']) and 'azul' == $_POST['color']) echo "checked"; ?>/>Azul
			
			<br/><br/><input type="submit" value="Finalizar"/>
			<br/><input type="hidden" name="submitted" value="true"/>
		</form>
	</body>
</html>
