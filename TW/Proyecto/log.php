<?php

session_start();

require_once 'functions/header.php';
require_once 'functions/content.php';
require_once 'functions/admin_functions.php';

if(isset($_SESSION['type'])&&($_SESSION['type']=='admin')){
	$links=array();
	$pagina=99;
	printHeader($pagina, $links);

	echo "
	<section id='main-container'>"; 

			echo "
			<div id='Log'>";

			$con = dbConnection();
			$sql = "SELECT * FROM Log";

			$result = $con->query($sql);
			echo "<table><tr><th>Date</th><th>Content</th></tr>";
			while($row = $result->fetch_assoc()){
				echo "<tr><td>".$row['Date']."</td><td>".$row['Content']."</td></tr>";
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