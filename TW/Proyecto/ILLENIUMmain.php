<?php
  session_start();

  require_once 'functions/header.php';
  require_once 'functions/content.php';
  require_once 'functions/admin_functions.php';

  $id=isset($_POST['id'])? $_POST['id']:null;
  $action=isset($_POST['action'])? $_POST['action']:null;


  $links=['Intro', 'Media'];
  $pagina=1;
  
  printHeader($pagina, $links);

  echo "
  <section id='main-container' class='shadow'>";

  if(isset($_SESSION['login'])&&($_SESSION['type']=='admin')){
    echo "<div id='admin-tools'><h2 class='admintitle'>Administrative tools</h2>";
    list($action, $id) = checkActionHome($action, $id, "ILLENIUMmain.php");
    
    echo "</div>";
  }
  echo "<h2> Introduction </h2>
    <div id='Intro'>";

  printIntro($action,$id);

  echo "
    </div>";

  echo "
    <h2> Media </h2>
    <div id='Media'>";

    printMedia();

  echo "
    </div>";

  /*echo "
    <h2> Merch </h2>
    <div id='Merch'>";

    printMerch();

  echo "
    </div>";*/

  echo "
    <div id='Footer' class='shadow'>";

    printFooter();

  echo "
    </div>";
    
  echo "
  </section>
</body>
</html>";
?>

 



