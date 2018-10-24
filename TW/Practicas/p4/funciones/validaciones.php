<?php 
 function validarRequerido($valor){
    if(trim($valor) == ''){
       return false;
    }else{
       return true;
    }
 }
 function validarTexto($valor){
 		if(!preg_match("/^[a-zA-Z ]*$/",$valor)){
 			return false;
 		}
 		else{
 			return true;
 		}			
 
 }
 function validarEntero($valor, $opciones=null){
    if(filter_var($valor, FILTER_VALIDATE_INT, $opciones) === FALSE){
       return false;
    }else{
       return true;
    }
 }
 function validarEmail($valor){
    if(filter_var($valor, FILTER_VALIDATE_EMAIL) === FALSE){
       return false;
    }else{
       return true;
    }
 }
 function validarPostal($valor){
 		if(preg_match("/^[0-9]{5}$/i",$valor)){
 			return true;
 		}
 		else{
 			return false;
 		}
 }
?>
