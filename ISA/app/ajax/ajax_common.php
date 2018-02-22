<?php

function is_ajax(){
	return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

function set_sizes($string){
	$len = strlen($string) + 1;    
	header('Content-Length: '.$len);
	header("Content-Range: 0-".($len-1)."/".$len);
}

$doDebug = false;

if(isset($_REQUEST['dbg']) && $_REQUEST['dbg'] == "all_the_food"){
	$doDebug = true;
}

?>