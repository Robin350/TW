<?php
		if($_COOKIE['nombre']===null || $_COOKIE['talla']===null){
			header('Location: cookies1.php');
	}
?>

<!DOCTYPE>
<html>
	<head>
			<title> Comprar ropa </title>
		  <meta http-equiv="Content-Type" content="text/html"; charset=utf-8"/>
	</head>
	<body>
		<h2>Son correctos los datos?</h2>
		<?php
			echo "<b>Nombre:</b>".$_COOKIE['nombre'];
			echo "<br/><b>Prenda:</b>".$_COOKIE['prenda'];
			echo "<br/><b>Talla:</b>".$_COOKIE['talla'];
			echo "<br/><b>Color:</b>".$_COOKIE['color'];
		?>
		
		<form action="cookies3.php">
			<input type="submit" name="finalizar" value="finalizar"/>
		</form>
		<?php
			if($_GET){
				if(isset($_GET['finalizar'])){
					finalizar();
				}
			}
			
			function finalizar(){
				setcookie("nombre","",time()-3600);
				setcookie("prenda","",time()-3600);
				setcookie("talla","",time()-3600);
				setcookie("color","",time()-3600);
				echo "<h3>compra finalizada, cookies borradas</h3>";
			}
		?>
	</body>
</html>
