<?php

session_start();

require_once 'functions/header.php';
require_once 'functions/content.php';
require_once 'functions/admin_functions.php';

if(isset($_SESSION['type'])&&($_SESSION['type']=='shop manager')){
	$links=array();
	$pagina=99;
	printHeader($pagina, $links);

	echo "
	<section id='main-container'>"; 

			echo "
			<div class='concerts-container'>";

			$con = dbConnection();
			$sql = "SELECT * FROM Orders ORDER BY `State`";

			$result = $con->query($sql);
			echo "<table><tr><th>Name</th><th>Surname</th><th>Email</th><th>Telephone</th><th>Adress</th><th>Payment</th><th>Card Number</th><th>Expire</th><th>Security Code</th><th>Album</th><th>Number</th><th>Action</th></tr>";
			while($row = $result->fetch_assoc()){
				$fields = getColumnNames($con, 'Orders');
				echo "<tr>";
				foreach($fields as $field){
					echo"<td>".$row[$field]."</td>";
				}
				echo "<td><form action='orders.php' method='post' > 
										<input type='submit' name='action' value='Accept'/>
										<input type='submit' name='action' value='Deny'/>
										</form></td></tr>"; 
			}

			echo "</table>";

			echo "
			</div>";
			

			echo "
			<div id='Footer'>";

			printFooter();

			echo "
			</div>";

	echo "
	</section>
	</body>
	</html>";

}
else{
	echo "You shall not pass";
}
?>