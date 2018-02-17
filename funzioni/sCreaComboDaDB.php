<?php
function sCreaComboDaDB($sSql, $MessInit, $NomeCmb, $NomeID, $NomeCampo,$db) {
// VUOLE: SQL di select, Mess-iniziale, NomeCombo, nome-campo-ID, nome-campo-valore (i 2 nomi campi sono quelli della select)
// SE C'E' SOLO UN VALORE, IMPOSTA DIRETTAMENTE QUELLO
	$sHtml = "<select name=\"$NomeCmb\">";
	$sHtml2 = "";
	if (isset($MessInit)) {
		if ($MessInit != "") {
			$sHtml2 = "<option value=\"\" disabled selected>$MessInit</option>";
		}
	}
	
// echo "</br> sql=" . $sSql;
	$result = @mysqli_query($db,$sSql);
// echo "</br> result=" . $result;
	$i = 0;
	$sHtml3 = "";
	if($result != false){
		while($riga=mysqli_fetch_array($result)){
			++$i;
			$cmbID=$riga[$NomeID];
			$cmbValore=$riga[$NomeCampo];
			$sHtml3 .= "<option value='$cmbID'>$cmbValore</option>";
		}
	}
	if ($i > 1) { $sHtml .= $sHtml2; }
	$sHtml .= $sHtml3 . "</select>";
	return $sHtml;	
}
?>
