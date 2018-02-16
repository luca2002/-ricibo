<?php
function sLeggiMailID_USER($ID_USER) {
// VUOLE LA CONNESSIONE AL DB APERTA
// echo("</br> ID_USER=" . $ID_USER);
$sql = "SELECT MAIL FROM TB_MAIL WHERE (ID_USER=$ID_USER);";
//echo("</br> sql=" . $sql);
$result = mysql_query($sql);
$MAIL = "";
if ($result != false) {
	while ($riga = mysql_fetch_array($result)) { $MAIL = $riga["MAIL"]; }
}
return $MAIL;	
}
?>
