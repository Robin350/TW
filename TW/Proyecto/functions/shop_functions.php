<?php
	require_once "db_operations.php";
	require_once "admin_functions.php";
	
	function processPurchase($picked){
		if(isset($_POST['purchase'])){
			setcookie('picked', $picked);
			header("Location: ILLENIUMshop.php");
		}
	}

?>