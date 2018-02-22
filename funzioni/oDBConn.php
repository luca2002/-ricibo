<?php
function oDBConn() {
	// INFO DB
	$DBhost = "localhost";  // "93.46.220.3";
	$DBuser = "ricibo??";
	$DBpass = "ricibo??";
	$DBName = "ricibo??";
	$codUscita = 0;
	$codUscita = mysql_connect($DBhost, $DBuser, $DBpass);
	if (!$codUscita) { $codUscita = 1; } // Errore: connessione al DB fallita
	else {
		$ris = mysql_select_db($DBName);
		if (!$ris) {  // Errore: DB non trovato
			mysql_close($codUscita);
			$codUscita = 2;
		}
	}
	return $codUscita;
}
?>
