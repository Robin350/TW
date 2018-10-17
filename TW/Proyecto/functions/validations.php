<?php 

function validateText($valor){
   if(!preg_match("/^[a-zA-Z ]*$/",$valor)){
     return false;
   }
   else{
     return true;
   }			

}
function validateInteger($valor, $opciones=null){
  if(filter_var($valor, FILTER_VALIDATE_INT, $opciones) === FALSE){
     return false;
  }else{
     return true;
  }
}
function validateEmail($valor){
  if(filter_var($valor, FILTER_VALIDATE_EMAIL) === FALSE){
     return false;
  }else{
     return true;
  }
}

function validateCard($valor){

}

?>
