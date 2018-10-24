<?php


function dbConnection(){

	$host_db = "localhost";
	$user_db = "robinloja971718";
	$pass_db = "yFAxVJLS";
	$db_name = "robinloja971718";

	$conexion = new mysqli($host_db, $user_db, $pass_db, $db_name);

	if ($conexion->connect_error) {
		die("La conexion falló: " . $conexion->connect_error);
	}

	return $conexion;

}

function getTableContent($conexion, $tbl_name){
	$sql = "SELECT * FROM $tbl_name";

	$result = $conexion->query($sql);

	return $result;
}

?>