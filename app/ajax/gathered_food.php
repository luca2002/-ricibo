<?php

include_once 'ajax_common.php';
include_once 'job_common.php';
include_once 'db.php';

if(!is_ajax()){
	die("Not ajax");
}

if(!isset($_POST['id'])){
	die("No id");
}

$id = $_POST['id'];

$move_query = "INSERT INTO TB_APP_CONSEGNA SELECT * FROM TB_APP_RITIRO WHERE ID_DONAZIONE = '$id';";
$move_res = mysql_query($move_query, $db);
if(!$move_res){
	//if(doDebug){
		echo("Error: " . mysql_error($db));
	//}
	mysql_close();
	die("Error");
}else{
	$delete_query = "DELETE FROM TB_APP_RITIRO WHERE ID_DONAZIONE = '$id'";
	$delete_res = mysql_query($delete_query, $db);
	if(!$delete_res){
		//if(doDebug){
			echo("Error2: " . mysql_error($db));
		//}
		mysql_close();
		die("Error");
	}
}
$rvl = "ok";
mysql_close();
set_sizes($rvl);
echo($rvl);
?>