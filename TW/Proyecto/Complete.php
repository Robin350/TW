<?php

session_start();

require_once 'functions/header.php';
require_once 'functions/content.php';
require_once 'functions/admin_functions.php';

	$links=array();
	$pagina=99;
	printHeader($pagina, $links);

	echo "
	<section id='main-container'>"; 
	echo "<h2>Purchase complete</h2>";
		

			echo "
			<div id='Footer'>";

			printFooter();

			echo "
			</div>";

	echo "
	</section>
	</body>
	</html>";



?>

