<!DOCTYPE>
<html>
    <head>
        <title> Formulario </title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <strong> Sus datos han sido enviados correctamente </strong>
        <?php
        	session_start();

					echo	"<p>Variables Formulario: </p>";
					echo"<ul>";
					echo $_SESSION['nombre'];
					echo"</ul>";
				?>
    </body>
</html> 
