<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

} else {
   echo "Esta pagina es solo para usuarios administradores.<br>";
   echo "<br><a href='login.html'>Login</a>";
   echo "<br><br><a href='index.html'>Registrarme</a>";

exit;
}
if($_SESSION['tipo'] == "normal"){
	echo "Se requieren privilegios de administrador para acceder a esta pagina";
	exit;
}


$now = time();

if($now > $_SESSION['expire']) {
session_destroy();

echo "Su sesion a terminado,
<a href='login.html'>Necesita Hacer Login</a>";
exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<title>Panel de Control</title>
</head>

<body>
<h1>Panel de Control</h1>
<h2>Usuarios del sistema: </h2>
<?php
	$host_db = "localhost";
	$user_db = "robinloja971718";
	$pass_db = "yFAxVJLS";
	$db_name = "robinloja971718";
	$tbl_name = "Usuarios";
	$contador = 0;

	$conn = new mysqli($host_db, $user_db, $pass_db, $db_name);

	if ($conn->connect_error) {
	 die("La conexion falló: " . $conexion->connect_error);
	}
	
	if (isset($_POST['accion']) && isset($_POST['id'])) {
			switch ($_POST['accion']) {
			case 'Borrar':

					// Presentar formulario y pedir confirmación

					$accion = 'Borrar';
					$id = $_POST['id'];
						echo "Valor de accion: $accion $id";
					break;
					
			case 'Confirmar Borrado':

					// Borrado confirmado

					$accion = 'BorrarOK';
					$id = $_POST['id'];
					break;

			case 'Modificar':

					// Modificación confirmada

					$accion = 'Modificar';
					$id = $_POST['id'];
						echo "Valor de accion: $accion $id";
					break;

			case 'Cancelar':
					break;
			}
	}
	
	if(isset($id) && isset($accion)){
		switch ($accion){
			case 'Borrar':
				
				$sql = "DELETE FROM Usuarios WHERE Email='$id'";
				$result = $conn->query($sql);		
				break;
		}
	}
	
	$sql = "select count(Email) from Usuarios";
	$result = $conn->query($sql);
	$row=$result->fetch_array(MYSQLI_NUM);
	$nRows=$row[0];
	$pageSize=600;
	if(isset($_GET['pageSize'])){
	$pageSize=$_GET['pageSize'];
	}
	$page=0;
	if(isset($_GET['page'])){
	$page=$_GET['page'];
	}
	$pos=$page*$pageSize;
	$pos=($pos>$nRows)?$nRows:$pos;
	$sql = "SELECT * FROM Usuarios order by Nombre";
	$result = $conn->query($sql);
	
	
			
	
	
	
	if ($result->num_rows > 0) {
	echo "<table border='2'>
	<tr>
	<th>Nombre</th><th>Apellidos</th><th>Email</th><th>Clave</th><th>Tipo de usuario</th><th>Accion</th>
	</tr>
	";
	while($row = $result->fetch_assoc()) {
		echo "<tr>";
		echo "<td>".$row["Nombre"]."</td>";
		echo "<td>".$row["Apellidos"]."</td>";
		echo "<td>".$row["Email"]."</td>";
		echo "<td>".$row["Contrasenia"]."</td>";
		echo "<td>".$row["Tipo"]."</td>";
		echo "<td><form action='panel-control.php' method='POST'>
			<input type='hidden' name='id'  value='{$row['Email']}' />
			<input type='submit' name='accion' value='Modificar' />
			<input type='submit' name='accion' value='Borrar' />
		</form></td>";
		echo "</tr>";
		$contador++;
	}
	echo "</tr>\n</table>";
	} else {
	echo "No hay usuarios que mostrar";
	}
	$conn->close();

?>


<br><br>
<a href=logout.php>Cerrar Sesion X </a>
</body>
</html>


