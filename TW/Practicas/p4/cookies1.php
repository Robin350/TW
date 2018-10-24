<?php
	require_once 'funciones/validaciones.php';
	
	$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
	$prenda = isset($_POST['prenda']) ? $_POST['prenda'] : null;
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Valida que el campo nombre no esté vacío.
    if (!validarRequerido($nombre)) {
        $errores[] = 'El campo nombre es obligatorio.';
    }
    if (!validarRequerido($prenda)) {
        $errores[] = 'El campo prenda es obligatorio.';
    }
    if(!$errores){
		  
		  if(!validarTexto($nombre)){
		  		$errores[] = 'El campo nombre solo puede contener letras y espacios.';
		  }
		  //Verifica si ha encontrado errores y de no haber redirige a la página con el mensaje de que pasó la validación.
		  if(!$errores){
		  		setcookie('nombre',$_POST['nombre']);
					setcookie('prenda', $_POST['prenda']);
		      header('Location: cookies2.php');
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
		<form action="cookies1.php" method="post">
			<label>Nombre y apellidos</label>
			<input type="text" name="nombre" value="<?php echo $nombre ?>"/>
			<br/><br/>
			<label>Prenda a comprar</label>
			<input type="radio" name="prenda" value="camisa" <?php if(isset($_POST['prenda']) and 'camisa' == $_POST['prenda']) echo "checked"; ?>/>Camisa
			<input type="radio" name="prenda" value="pantalon" <?php if(isset($_POST['prenda']) and 'pantalon' == $_POST['prenda']) echo "checked"; ?>/>Pantalon
			<input type="radio" name="prenda" value="falda" <?php if(isset($_POST['prenda']) and 'falda' == $_POST['prenda']) echo "checked"; ?>/>Falda
			
			<br/><br/><input type="submit" value="Siguiente"/>
			<br/><input type="hidden" name="submitted" value="true"/>
		</form>
	</body>
</html>
