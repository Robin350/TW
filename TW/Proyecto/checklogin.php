<?php
session_start();

require_once "functions/db_operations.php";
require_once "functions/admin_functions.php";

if(!isset($_POST['email'])){
	header("Location: ILLENIUMmain.php");
}

$con = dbConnection();

$email = $_POST['email'];
$password = $_POST['password'];
 
$sql = "SELECT * FROM Users WHERE Email = '$email'";

$result = $con->query($sql);
checkDBquery($con, $sql);

if ($result->num_rows > 0) {     
 $row = $result->fetch_array(MYSQLI_ASSOC);
 if ($password == $row['Password']) { 

    $_SESSION['login'] = true;
    $_SESSION['email'] = $email;
    $_SESSION['type'] = $row['Type'];
    logToDB($con,"Login succeded: $email");
    mysqli_close($con); 
    header("Location: ".$_SERVER['HTTP_REFERER']);
 } else { 
   echo "Wrong Username or Password .";
   logToDB($con,"Login failed: $email");
   echo "<br><a href='ILLENIUMmain.php'>Go back</a>";
 }
}
else{
  echo "That user does not exist.";
  logToDB($con,"Login failed: $email");
  echo "<br><a href='".$_SERVER['HTTP_REFERER']."'>Try again</a>";
}

 ?>
