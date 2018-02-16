<?php
function oDBConn() {
	// INFO DB
	$DBhost = "localhost";  // "93.46.220.3";
	$DBName = "ricibo";
	$codUscita = 0;
	$codUscita = mysqli_connect($DBhost,'root','',$DBName);
	if (!$codUscita) { $codUscita = 1; } // Errore: connessione al DB fallita

	return $codUscita;
}
?>
