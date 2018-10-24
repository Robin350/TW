<?php
    require_once 'login.php';

    function printHead(){
        echo "
                    <head>
                        <title>ILLENIUM</title>
                        <link rel='stylesheet' type='text/css' href='ILLENIUMstyle.css'>
                        <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
                        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
                        <link rel='shortcut icon' href='favicon.ico' type='image/x-icon'>
                        <link rel='icon' type='image/png' href='favicon.png' />
                        <meta charset='utf-8'>
                    </head>";
    }

    function printPagenav($links){
        echo    "<nav class='page-nav'>
                    <ul class='nav-container'>";
        foreach($links as $link){
                echo "<a href='#$link'><li>$link</li></a>";
        }
        echo    "  </ul>
                </nav>";
    }

    function printHeader($active, $links){
        echo"   
                <!DOCTYPE html>
                <html>";

                    printHead();
                    printNavbar($active,$links);
                    printLogo();
                    printPagenav($links);
            
        echo "<body>";
    }


    function printNavbar($active,$links){

        echo "  <ul class='top-nav nav-container'>
                    <a ";

        if($active==1)
            echo "class='active' ";
        echo    "href='ILLENIUMmain.php'><i class='fa fa-home'></i> Home</a>
                    <a ";

        if($active==2)
            echo "class='active' ";
        echo    "href='ILLENIUMconcerts.php'><i class='fa fa-book'></i> Concerts</a>
                    <a ";

        if($active==3)
            echo "class='active' ";                
        echo    "href='ILLENIUMmusic.php'><i class='fa fa-music'></i> Music</a>
                    <a ";

        if($active==4)
            echo "class='active' ";           
        echo    "href='ILLENIUMshop.php'><i class='fa fa-shopping-cart'></i> Shop</a>";

        if(!isset($_SESSION['login'])){
            echo    "<a class='dropbtn'><i class='fa fa-user'></i>Log in
                    <div class='dropdown-content'>";
            printLoginform();
            echo    "</div></a>";
        }
        else{
            echo "<a href='logout.php'>Log out session as " . $_SESSION['type'] . ": " . $_SESSION['email'] . "</a>";
        }

        if(isset($_SESSION['type'])&&($_SESSION['type']=='admin')){
            echo "<a href='log.php' class='special-nav'>Page Log</a>";
        }

        if(isset($_SESSION['type'])&&($_SESSION['type']=='shop manager')){
            echo "<a href='orders.php' class='special-nav'>Orders</a>";
        }
        echo    "</ul>";



    }

    function printLogo(){            
        echo "  
                    <header>
                        <a name='inicio' href='ILLENIUMmain.php'>
                            <img src='pics/illenium-logo.png'>
                        </a>
                    </header>";
    }


?>

