<?php

//Definimos la codificación de la cabecera.
header('Content-Type: text/html; charset=utf-8');

//Importamos el archivo con las validaciones.
require_once 'functions/validations.php';
require_once 'functions/db_operations.php';
require_once 'functions/admin_functions.php';
require_once 'functions/content.php';
require_once 'functions/header.php';
//Guarda los valores de los campos en variables, siempre y cuando se haya enviado el formulario, sino se guardará null.
$name = isset($_POST['name']) ? $_POST['name'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$surname = isset($_POST['surname']) ? $_POST['surname'] : null;
$telephone = isset($_POST['telephone']) ? $_POST['telephone'] : null;
$adress = isset($_POST['adress']) ? $_POST['adress'] : null;
$Payment = isset($_POST['Payment']) ? $_POST['Payment'] : null;
$cardnum = isset($_POST['cardnum']) ? $_POST['cardnum'] : null;
$expmonth = isset($_POST['expmonth']) ? $_POST['expmonth'] : null;
$expyear = isset($_POST['expyear']) ? $_POST['expyear'] : null;
$cvc = isset($_POST['cvc']) ? $_POST['cvc'] : null;

//Este array guardará los errors de validación que surjan.
$errors = array();

$con = dbConnection();

$links=['', '', ''];
$pagina=4;

printHeader($pagina, $links);

echo "
<section id='main-container'>"; 

//Pregunta si está llegando una petición por POST, lo que significa que el usuario envió el formulario.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Valida que el campo name no esté vacío.
    
    if(isset($_POST['Payment'])){
    	if($_POST['Payment']=='Card'){
        if($cardnum==""){
            $errors[] = 'Card number';
    		}
    		if($expyear==""){
            $errors[] = 'Expire year';
        }
        if($expmonth==""){
       			$errors[] = 'Expire month';
    		}
    		if($cvc==""){
       			$errors[] = 'Security code';
    		}
    	}
    }
    if(!$errors){
		  //Valida que el campo email sea correcto.
		  if (!validateEmail($email)) {
		      $errors[] = 'Wrong email.';
		  }
		  
		  if(!validateText($name)){
		  		$errors[] = 'Name can only contain [A-Z][a-z] or spaces.';
		  }
		  
		  if(!validateText($surname)){
		  		$errors[] = 'Surname can only contain [A-Z][a-z] or spaces.';
		  }
		  
      if(isset($_POST['Payment'])){
    		if($_POST['Payment']=='Card'){

				   if(!preg_match("/^5[1-5][0-9]{14}$/",$cardnum)){
				            $errors[] = 'Wrong card number';
				   }

		      if(preg_match("/^[0-9]*$/",$expmonth)){
		          if($expmonth>12){
		              $errors[] = 'Wrong expiration month';
		          }
		      }
		      if(preg_match("/^[0-9]*$/",$expyear)){
		          if($expyear>2018){
		          	$errors[] = 'Wrong expiration year';
		          }
		      }
          if(preg_match("/[0-9]{3}/",$post['cvc'])){
		             $errors[] = 'Wrong security code';
		      }
		     
		   	}
		   }

		  //Verifica si ha encontrado errors y de no haber redirige a la página con el mensaje de que pasó la validación.
		  if(!$errors){
					$sql = "INSERT INTO `Orders`(`Name`,`Surname`,`Email`,`Telephone`,`Adress`,`Payment`,`Card Number`,`Expire`,`Security Code`, `Album`, `Number`)
									VALUES('$name','$surname','$email','$telephone','$adress','$Payment','$cardnum','$expmonth''$expyear','$cvc','".$_POST['Album']."',NULL)";
		      header('Location: Complete.php');
		      die();
		  }
		}
}

	if ($errors):
		echo "<ul style='color: #f00;'>";
				foreach ($errors as $error):
					echo "<li> $error </li>";
					endforeach;
				echo "</ul>";
	endif;

	echo "<form method='post' action='ILLENIUMshop.php'>
				<fieldset>
					<legend>Personal data:</legend>
						<label> Name </label>
						<br />
						<input type='text' name='name' value='$name' required/>
						<br />
						
						<label> Surname </label>
						<br />
						<input type='text' name='surname' value='$surname' required/>
						<br />
						
						<label> Adress </label>
						<br />
						<input type='text' name='adress' value='$adress' required/>
						<br />   
						
						<label> E-mail </label>
						<br />
						<input type='text' name='email' value='$email' required/>
						<br />
						
						<label> Telephone </label>
						<br />
						<input type='number' name='telephone' value='$telephone' />
						<br />
						
				</fielset>  
		
				<fieldset>
					<legend>Purchase data: </legend>
						Selected Album:<br>";
						echo	"<input type='radio' name='Album' value='Ashes'> Ashes
							<input type='radio' name='Album' value='Awaken'> Awaken
							<input type='radio' name='Album' value='Awaken Piano'> Awaken Piano
							<input type='radio' name='Album' value='Zeds Remixes'> Zeds Remixes";

						
						echo "<fieldset>
						<legend>Payment method: </legend>
							<input type='radio' name='Payment' value='Card'"; if(isset($_POST['Payment']) and 'Card' == $_POST['Payment']) echo 'checked'; echo "> Card<br>
							<input type='radio' name='Payment' value='In Hand'"; if(isset($_POST['Payment']) and 'In Hand' == $_POST['Payment']) echo 'checked'; echo"> In Hand<br>

								<span>Card Number</span><input type='number' name='cardnum'";
									if(isset($_POST['cardnum']))
													echo " value='".$_POST['cardnum']."'";
								
								echo "/><br/><span>Expire month</span><input type='number' name='expmonth'";
								if(isset($_POST['expmonth']))
									echo " value='".$_POST['expmonth']."'";
			
								echo "/><span>Expire year</span><input type='number' name='expyear'";
								if(isset($_POST['expyear']))
									echo " value='".$_POST['expyear']."'";
								
								echo "/><span>Security code</span><input type='number' name='cvc'";
								if(isset($_POST['cvc']))
									echo " value='".$_POST['cvc']."'";
								echo "/>";
							echo "</fieldset>";

		echo "<input type='submit' value='Done' />
			</form>";

			echo "
			<div id='Footer'>";
	
			printFooter();
	
			echo "
			</div>";
	
	echo "
	</section>
	</body>
	</html>";

