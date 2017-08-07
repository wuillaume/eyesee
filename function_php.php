<?php

function checkInt($var) {

	if( ! filter_var($var, FILTER_VALIDATE_INT) ){
 return false;
}
else{
	return true;
}
}

function IsNullOrEmptyString($question){
    return (!isset($question) || trim($question)==='');
}
?>

