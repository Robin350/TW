<?php

session_start();

require_once 'functions/header.php';
require_once 'functions/content.php';
require_once 'functions/admin_functions.php';

$id=isset($_POST['id'])? $_POST['id']:null;
$action=isset($_POST['action'])? $_POST['action']:null;

$links=['', '', ''];
$pagina=2;

printHeader($pagina, $links);

echo "
<section id='main-container'>"; 

    if(isset($_SESSION['login'])){
        if($_SESSION['type']=='admin'){
            echo "<div id='admin-tools'><h2 class='admintitle'>Administrative tools</h2>";
            list($action, $id) = checkActionConcerts($id, $action, "ILLENIUMconcerts.php");
            
            echo "</div>";
        }
    }
		echo "
		<h2> Concerts </h2>
    <div id='Concerts'>";

    printConcerts();

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
?>