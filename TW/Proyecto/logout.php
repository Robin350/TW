<?php
session_start();
unset ($_SESSION['email']);
session_destroy();

header("Location: ".$_SERVER['HTTP_REFERER']);

?>