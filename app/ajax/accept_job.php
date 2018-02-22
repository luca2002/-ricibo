<?php
include_once 'ajax_common.php';

if(!is_ajax()){
	die("Not Ajax");
}

include_once 'db.php';

if(!isset($_REQUEST['offer_id'])){
	die("No offer");
}

if(!isset($_REQUEST['assoc_id'])){
	die("No Assoc");
}

if(!isset($_REQUEST['type'])){
	die("No type");
}

if(!isset($_REQUEST['qty'])){
	die("No qty");
}

if(!isset($_REQUEST['cell'])){
	die("No cell");
}

if(!isset($_REQUEST['store_id'])){
	die("No store");
}

$offer_id = $_REQUEST['offer_id'];
$assoc_id = $_REQUEST['assoc_id'];
$type = $_REQUEST['type'];
$qty = $_REQUEST['qty'];
$cell = $_REQUEST['cell'];
$store_id = $_REQUEST['store_id'];


$add_delivery_query = "INSERT INTO TB_APP_RITIRO(ID_DONAZIONE, ID_NEG, ID_ASS, QTA, TIPO, CELL) VALUES('$offer_id', '$store_id', '$assoc_id', '$qty', '$type', '$cell')";
$res_delivery_query = mysql_query($add_delivery_query, $db);
if(!$res_delivery_query){
	//if($doDebug){
		echo($add_delivery_query . "\n");
		echo("Error: " . mysql_error($db));
	//}
	mysql_close();
	die("Insertion Failed.");
}

$rem_offer_query = "DELETE FROM TB_APP_DONAZIONE WHERE ID_DONAZIONE = '$offer_id'";
$res_offer_query = mysql_query($rem_offer_query, $db);
if(!$res_offer_query){
	//if($doDebug){
		echo("Error: " . mysql_error($db));
	//}
	mysql_close();
	die("Removal Failed.");
}


mysql_close();
echo("OK");
?>