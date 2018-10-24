<?php

session_start();

require_once 'functions/header.php';
require_once 'functions/content.php';
require_once 'functions/admin_functions.php';

$id=isset($_POST['id'])? $_POST['id']:null;
$action=isset($_POST['action'])? $_POST['action']:null;

$links=['', '', ''];
$pagina=3;

printHeader($pagina, $links);

echo "
<section id='main-container'>"; 

    if(isset($_SESSION['login'])){
        if($_SESSION['type']=='admin'){
            echo "<div id='admin-tools'><h2 class='admintitle'>Administrative tools</h2>";
            list($action, $id) = checkActionMusic($id, $action, "ILLENIUMmusic.php");
            
            echo "</div>";
        }
    }
    echo "
    <h2> Albums </h2>
    <div id='Albums'>";

    printAlbums();

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