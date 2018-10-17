<?php
session_start();
?>

<?php

$host_db = "localhost";
$user_db = "robinloja971718";
$pass_db = "yFAxVJLS";
$db_name = "robinloja971718";
$tbl_name = "Usuarios";

if(!isset($_POST['email'])){
	header("Location: login.html");
}


$conexion = new mysqli($host_db, $user_db, $pass_db, $db_name);

if ($conexion->connect_error) {
 die("La conexion falló: " . $conexion->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];
 
$sql = "SELECT * FROM $tbl_name WHERE Email = '$email'";

$result = $conexion->query($sql);


if ($result->num_rows > 0) {     
 }
 $row = $result->fetch_array(MYSQLI_ASSOC);
 if ($password == $row['Contrasenia']) { 
 
    $_SESSION['loggedin'] = true;
    $_SESSION['email'] = $email;
    $_SESSION['start'] = time();
    $_SESSION['expire'] = $_SESSION['start'] + (5 * 60);
    $_SESSION['tipo'] = $row['Tipo'];

		if($row['Tipo'] == "admin"){
		  echo "Bienvenido! " . $_SESSION['email'];
		  echo "<br><br><a href=panel-control.php>Panel de Control</a>";
		}
		else{
			echo "Bienvenido usuario normal";
		}

 } else { 
   echo "Username o Password estan incorrectos.";

   echo "<br><a href='login.html'>Volver a Intentarlo</a>";
 }
 mysqli_close($conexion); 
 ?>
