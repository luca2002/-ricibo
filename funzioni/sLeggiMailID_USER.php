<?php
function sLeggiMailID_USER($ID_USER,$db) {
// VUOLE LA CONNESSIONE AL DB APERTA
// echo("</br> ID_USER=" . $ID_USER);
$sql = "SELECT MAIL FROM TB_MAIL WHERE (ID_USER=$ID_USER);";
//echo("</br> sql=" . $sql);
$result = mysqli_query($db,$sql);
$MAIL = "";
if ($result != false) {
	while ($riga = mysqli_fetch_array($result)) { $MAIL = $riga["MAIL"]; }
}
return $MAIL;	
}
?>
