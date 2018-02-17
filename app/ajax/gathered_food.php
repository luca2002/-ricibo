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
$move_res = mysqli_query($db,$move_query);
if(!$move_res){
	//if(doDebug){
		echo("Error: " . mysqli_error($db));
	//}
	mysqli_close($db);
	die("Error");
}else{
	$delete_query = "DELETE FROM TB_APP_RITIRO WHERE ID_DONAZIONE = '$id'";
	$delete_res = mysqli_query($db,$delete_query);
	if(!$delete_res){
		//if(doDebug){
			echo("Error2: " . mysqli_error($db));
		//}
		mysqli_close($db);
		die("Error");
	}
}
$rvl = "ok";
mysqli_close($db);
set_sizes($rvl);
echo($rvl);
?>