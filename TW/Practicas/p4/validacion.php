<?php

//Definimos la codificación de la cabecera.
header('Content-Type: text/html; charset=utf-8');

//Importamos el archivo con las validaciones.
require_once 'funciones/validaciones.php';
//Guarda los valores de los campos en variables, siempre y cuando se haya enviado el formulario, sino se guardará null.
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
$nacimiento = isset($_POST['nacimiento']) ? $_POST['nacimiento'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : null;
$telefono = isset($_POST['telefono']) ? $_POST['telefono'] : null;
$dirpost = isset($_POST['dirpost']) ? $_POST['dirpost'] : null;
$area = isset($_POST['area']) ? $_POST['area'] : null;

//Este array guardará los errores de validación que surjan.
$errores = array();


//Pregunta si está llegando una petición por POST, lo que significa que el usuario envió el formulario.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Valida que el campo nombre no esté vacío.
    if (!validarRequerido($nombre)) {
        $errores[] = 'El campo nombre es obligatorio.';
    }
        if (!validarRequerido($apellidos)) {
        $errores[] = 'El campo apellidos es obligatorio.';
    }
        if (!validarRequerido($email)) {
        $errores[] = 'El campo email es obligatorio.';
    }
    
    if(!$errores){
		  //Valida que el campo email sea correcto.
		  if (!validarEmail($email)) {
		      $errores[] = 'El campo email es incorrecto.';
		  }
		  
		  if(!validarTexto($nombre)){
		  		$errores[] = 'El campo nombre solo puede contener letras y espacios.';
		  }
		  
		  if(!validarTexto($apellidos)){
		  		$errores[] = 'El campo apellidos solo puede contener letras y espacios.';
		  }
		  
		  if(!validarPostal($dirpost)){
		  		$errores[] = 'El campo direccion postal debe de ser un codigo postal nacional.';
		  }
		  //Verifica si ha encontrado errores y de no haber redirige a la página con el mensaje de que pasó la validación.
		  if(!$errores){
		      header('Location: validado.php');
		      die();
		  }
		}
}
?>
<!DOCTYPE>
<html>
    <head>
        <title> Formulario </title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
    		<form method="post" action="validacion.php">
    			<select name=area>
    				<option value="1" <?php if ($area==1) echo 'selected="selected"';?>>Divulgacion</options>
						<option value="2" <?php if ($area==2) echo 'selected="selected"';?>>Motor</options>
						<option value="3" <?php if ($area==3) echo 'selected="selected"';?>>Viajes</options>
					</select>
    			<input type="submit" value="Enviar" />
    		</form>
    		<?php if($area !== null): ?>
		      <?php if ($errores): ?>
		          <ul style="color: #f00;">
		              <?php foreach ($errores as $error): ?>
		                  <li> <?php echo $error ?> </li>
		              <?php endforeach; ?>
		          </ul>
		      <?php endif; ?>
		      <form method="post" action="validacion.php">
		      	<fieldset>
		      		<legend>Informacion personal:</legend>
				        <label> Nombre </label>
				        <br />
				        <input type="text" name="nombre" value="<?php echo $nombre ?>" />
				        <br />
				        
				        <label> Apellidos </label>
				        <br />
				        <input type="text" name="apellidos" value="<?php echo $apellidos ?>" />
				        <br />
				        
				        <label> Direccion Postal </label>
				        <br />
				        <input type="text" name="dirpost" value="<?php echo $dirpost ?>" />
				        <br />
				        
				        <label> Fecha de nacimiento </label>
				        <br />
				        <input type="date" name="nacimiento" value="<?php echo $nacimiento ?>" />
				        <br />      
				        
				        <label> E-mail </label>
				        <br />
				        <input type="text" name="email" value="<?php echo $email ?>" />
				        <br />
				        
				        <label> Telefono </label>
				        <br />
				        <input type="number" name="telefono" value="<?php echo $telefono ?>" />
				        <br />
				      </fielset>  
				      
				      <fieldset>
				      	<legend>Informacion sobre la suscripcion: </legend>
				      		Revista seleccionada:<br>
				      		<?php if ($area==1): ?>
										<input type="radio" name="Revista" value="Sabelotodo" <?php if(isset($_POST['Revista']) and 'Sabelotodo' == $_POST['Revista']) echo "checked"; ?> > Sabelotodo<br>
										<input type="radio" name="Revista" value="Solo se que no se nada" <?php if(isset($_POST['Revista']) and 'Solo se que no se nada'==$_POST['Revista']) echo "checked"; ?> > Sólo sé que no sé nada<br>
										<input type="radio" name="Revista" value="Muy interesado" <?php if(isset($_POST['Revista']) and 'Muy interesado'==$_POST['Revista']) echo "checked"; ?> > Muy interesado<br>
										<input type="radio" name="Revista" value="Ciencia con sabor" <?php if(isset($_POST['Revista']) and 'Ciencia con sabor'==$_POST['Revista']) echo "checked"; ?> > Ciencia con sabor<br>
									<?php endif; ?>
									<?php if ($area==2): ?>
										<input type="radio" name="Revista" value="Supercoches" <?php if(isset($_POST['Revista']) and 'Supercoches' == $_POST['Revista']) echo "checked"; ?> > Supercoches<br>
										<input type="radio" name="Revista" value="Corre que te pilllo" <?php if(isset($_POST['Revista']) and 'Corre que te pilllo'==$_POST['Revista']) echo "checked"; ?> > Corre que te pilllo<br>
										<input type="radio" name="Revista" value="El mas lento de la carretera" <?php if(isset($_POST['Revista']) and 'El mas lento de la carretera'==$_POST['Revista']) echo "checked"; ?> > El mas lento de la carretera<br>
									<?php endif; ?>
									<?php if ($area==3): ?>
										<input type="radio" name="Revista" value="Paraisos del mundo" <?php if(isset($_POST['Revista']) and 'Paraisos del mundo' == $_POST['Revista']) echo "checked"; ?> > Paraisos del mundo<br>
										<input type="radio" name="Revista" value="Conoce tu ciudad" <?php if(isset($_POST['Revista']) and 'Conoce tu ciudad'==$_POST['Revista']) echo "checked"; ?> > Conoce tu ciudad<br>
										<input type="radio" name="Revista" value="La casa de tu vecino: rincones inhospitos" <?php if(isset($_POST['Revista']) and 'La casa de tu vecino: rincones inhospitos'==$_POST['Revista']) echo "checked"; ?> > La casa de tu vecino: rincones inhospitos<br>
									<?php endif; ?>
									
									Tipo de suscripción:<br>
										<input type="radio" name="Tipo" value="Anual" <?php if(isset($_POST['Tipo']) and 'Anual' == $_POST['Tipo']) echo "checked"; ?>> Anual<br>
										<input type="radio" name="Tipo" value="Bianual" <?php if(isset($_POST['Tipo']) and 'Bianual' == $_POST['Tipo']) echo "checked"; ?>> Bianual<br>
													        
				      	<fieldset>
				      		<legend>Modo de pago: </legend>
				      			<input type="radio" name="Pago" value="Paypal" <?php if(isset($_POST['Pago']) and 'Paypal' == $_POST['Pago']) echo "checked"; ?>> Paypal<br>
										<input type="radio" name="Pago" value="VISA" <?php if(isset($_POST['Pago']) and 'VISA' == $_POST['Pago']) echo "checked"; ?>> VISA <br>
										<input type="radio" name="Pago" value="Reembolso" <?php if(isset($_POST['Pago']) and 'Reembolso' == $_POST['Pago']) echo "checked"; ?>> Reembolso <br>

				      </fieldset>
				      
		          <input type="submit" value="Enviar" />

		      </form>
		   <?php endif; ?>
    </body>
</html>
