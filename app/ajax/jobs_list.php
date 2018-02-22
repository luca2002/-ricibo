<?php


class retVal{
	public $start_gps_x;
	public $start_gps_y;
	public $end_gps_x;
	public $end_gps_y;
	public $qty;
	public $type;
	public $neg_name;
	public $neg_tel;
	public $assoc_name;
	public $assoc_id;
	public $assoc_tel;
	public $offer_id;
	public $neg_id;
}
include_once 'ajax_common.php';

if(!is_ajax()){
	die("Not Ajax");
}

if(!isset($_POST['numb'])){
	die("Missing_numb");
}

$id = $_POST['numb'];

include_once 'db.php';
$qry_get_area = "SELECT TB_AREA.ID_AREA FROM TB_AREA, TB_PERSONA, TB_CELLULARI
					WHERE TB_CELLULARI.CELL = '$id' AND TB_PERSONA.ID_PERSONA = TB_CELLULARI.ID_PERSONA
					AND TB_AREA.ID_AREA = TB_PERSONA.ID_AREA";
$res_get_area = mysql_query($qry_get_area);

if(!$res_get_area){
	//if($doDebug){
		echo("Error: " . mysql_error);
	//}
	mysql_close();
	die("Failed");
}

$area = mysql_fetch_assoc($res_get_area)['ID_AREA'];

$qry_get_offers = "SELECT TB_APP_DONAZIONE.*,TB_NEG_ASS.ID_NEG_ASS AS NEG_ID, TB_NEG_ASS.GPS_X AS GPS_X, TB_NEG_ASS.NOME AS NAME, TB_NEG_ASS.TELEFONO_STRUTTURA AS TEL, TB_NEG_ASS.GPS_Y AS GPS_Y FROM TB_APP_DONAZIONE, TB_NEG_ASS WHERE TB_APP_DONAZIONE.ID_NEG = TB_NEG_ASS.ID_NEG_ASS
	AND TB_NEG_ASS.ID_AREA = '$area'";
$res_get_offers = mysqL_query($qry_get_offers);
if(!$res_get_offers){
	//if($doDebug){
		echo("Error: " . mysql_error());
	//}
	mysql_close();
	die("Failed");
}

$qry_get_assocs = "SELECT * FROM TB_NEG_ASS WHERE FLAG_AREA_NEG_ASS = 'A'
	AND TB_NEG_ASS.ID_AREA = '$area'";
$res_get_assocs = mysql_query($qry_get_assocs);
if(!$res_get_assocs){
	//if($doDebug){
		echo("Error: " . mysql_error());
	//}
	mysql_close();
	die("Failed");
}
$assocs = array();
while($row_asscs = mysql_fetch_array($res_get_assocs)){
	array_push($assocs, $row_asscs);
}

$rvl = array();
while($row_offer = mysql_fetch_array($res_get_offers)){
	foreach($assocs as $assoc){
		$curr_rvl = new retVal();
		$curr_rvl->start_gps_x = $row_offer['GPS_X'];
		$curr_rvl->start_gps_y = $row_offer['GPS_Y'];
		$curr_rvl->qty = $row_offer['QTA'];
		$curr_rvl->type = $row_offer['TIPO'];
		$curr_rvl->neg_name = $row_offer['NAME'];
		$curr_rvl->neg_tel = $row_offer['TEL'];
		$curr_rvl->offer_id = $row_offer['ID_DONAZIONE'];
		$curr_rvl->assoc_id = $assoc['ID_NEG_ASS'];
		$curr_rvl->assoc_name = $assoc['NOME'];
		$curr_rvl->end_gps_x = $assoc['GPS_X'];
		$curr_rvl->end_gps_y = $assoc['GPS_Y'];
		$curr_rvl->assoc_tel = $assoc['TELEFONO_STRUTTURA'];
		$curr_rvl->neg_id = $row_offer['NEG_ID'];
		array_push($rvl, $curr_rvl);
	}
}
$json_rvl = json_encode($rvl);
set_sizes($json_rvl);
echo($json_rvl);
mysql_close();
?>
