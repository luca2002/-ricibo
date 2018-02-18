<?php
function oDBConn() {
	// INFO DB
	$DBhost = "localhost";  // "93.46.220.3";
	$DBuser = "root";
	$DBpass = "";
	$DBName = "ricibo";
	$codUscita = 0;
	$codUscita = mysqli_connect($DBhost,$DBuser,$DBpass,$DBName);
	if (!$codUscita) { $codUscita = 1; } // Errore: connessione al DB fallita
	else{return $codUscita;}
}
?>
