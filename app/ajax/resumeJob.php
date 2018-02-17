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
	public $status;
}
include_once 'ajax_common.php';
include_once 'job_common.php';

if(!is_ajax()){
	die("Not Ajax");
}

if(!isset($_POST['id'])){
	die("No id.");
}
$id = $_POST['id'];
include_once 'db.php';


$qry_find_0 = "SELECT TB_APP_RITIRO.ID_DONAZIONE AS ID FROM TB_APP_RITIRO WHERE ID_DONAZIONE = '$id'";
$res_find_0 = mysqli_query($db,$qry_find_0);

if($res_find_0){
	if(mysqli_num_rows($res_find_0) > 0){
		$qry_get_offers = "SELECT TB_APP_RITIRO.ID_DONAZIONE AS ID, TB_APP_RITIRO.ID_NEG AS ID_NEG, TB_APP_RITIRO.ID_ASS AS ID_ASS,
				TB_APP_RITIRO.QTA AS QTY, TB_APP_RITIRO.TIPO AS TYPE, TB_APP_RITIRO.CELL AS CELL, TMP_0.NOME AS NOME_ASS,
				TMP_0.GPS_X AS GPS_X_ASS, TMP_0.GPS_Y AS GPS_Y_ASS, TMP_1.NOME AS NOME_NEG, TMP_1.GPS_X AS GPS_X_NEG, TMP_1.GPS_Y AS GPS_Y_NEG,
				TMP_0.TELEFONO_STRUTTURA AS CELL_ASS, TMP_1.TELEFONO_STRUTTURA AS CELL_NEG
				FROM TB_APP_RITIRO, 
				(SELECT * FROM TB_NEG_ASS WHERE FLAG_AREA_NEG_ASS = 'A') AS TMP_0, 
				(SELECT * FROM TB_NEG_ASS WHERE FLAG_AREA_NEG_ASS = 'N') AS TMP_1
				WHERE TB_APP_RITIRO.ID_DONAZIONE = '$id' AND TMP_0.ID_NEG_ASS = TB_APP_RITIRO.ID_ASS AND TMP_1.ID_NEG_ASS = TB_APP_RITIRO.ID_NEG";
		$status = JOB_STATUS_GATHERING;
	}else{
		$qry_find_1 = "SELECT TB_APP_CONSEGNA.ID_DONAZIONE AS ID FROM TB_APP_CONSEGNA WHERE ID_DONAZIONE = '$id'";
		$res_find_1 = mysqli_query($db,$qry_find_1);
		if($res_find_1){
			if(mysqli_num_rows($res_find_1) > 0){
				$qry_get_offers = "SELECT TB_APP_CONSEGNA.ID_DONAZIONE AS ID, TB_APP_CONSEGNA.ID_NEG AS ID_NEG, TB_APP_CONSEGNA.ID_ASS AS ID_ASS,
					TB_APP_CONSEGNA.QTA AS QTY, TB_APP_CONSEGNA.TIPO AS TYPE, TB_APP_CONSEGNA.CELL AS CELL, TMP_0.NOME AS NOME_ASS,
					TMP_0.GPS_X AS GPS_X_ASS, TMP_0.GPS_Y AS GPS_Y_ASS, TMP_1.NOME AS NOME_NEG, TMP_1.GPS_X AS GPS_X_NEG, TMP_1.GPS_Y AS GPS_Y_NEG,
					TMP_0.TELEFONO_STRUTTURA AS CELL_ASS, TMP_1.TELEFONO_STRUTTURA AS CELL_NEG
					FROM TB_APP_CONSEGNA, 
					(SELECT * FROM TB_NEG_ASS WHERE FLAG_AREA_NEG_ASS = 'A') AS TMP_0, 
					(SELECT * FROM TB_NEG_ASS WHERE FLAG_AREA_NEG_ASS = 'N') AS TMP_1
					WHERE TB_APP_CONSEGNA.ID_DONAZIONE = '$id' AND TMP_0.ID_NEG_ASS = TB_APP_CONSEGNA.ID_ASS AND TMP_1.ID_NEG_ASS = TB_APP_CONSEGNA.ID_NEG";
				$status = JOB_STATUS_DELIVERING;
			}else{
				mysqli_close($db);
				die("Not found");
			}
		}else{
			//if($doDebug)
				echo("Error: " . mysqli_error($db));
			//}
			mysqli_close($db);
			die("Failed");
		}
	}
}else{
	//if($doDebug)
		echo("Error: " . mysqli_error($db));
	//}
	mysqli_close($db);
	die("Failed");
}

$res_get_offers = mysqli_query($db,$qry_get_offers);
if(!$res_get_offers){
	//if($doDebug){
		echo("Error: " . mysqli_error($db));
	//}
	mysqli_close($db);
	die("Failed");
}

if(mysqli_num_rows($res_get_offers) < 1){
	mysqli_close($db);
	die("Not found");
}

$row = mysqli_fetch_array($res_get_offers);

$rvl = new retVal();
$rvl->offer_id = $row['ID'];
$rvl->start_gps_x = $row['GPS_X_NEG'];
$rvl->start_gps_y = $row['GPS_Y_NEG'];
$rvl->end_gps_x = $row['GPS_X_ASS'];
$rvl->end_gps_y = $row['GPS_Y_ASS'];
$rvl->qty = $row['QTY'];
$rvl->type = $row['TYPE'];
$rvl->neg_name = $row['NOME_NEG'];
$rvl->neg_tel = $row['CELL_NEG'];
$rvl->assoc_tel = $row['CELL_ASS'];
$rvl->assoc_name = $row['NOME_ASS'];
$rvl->assoc_id = $row['ID_ASS'];
$rvl->neg_id = $row['ID_NEG'];
$rvl->status = $status;

mysqli_close($db);

$rvl_json = json_encode($rvl);
set_sizes($rvl_json);
echo($rvl_json);

?>