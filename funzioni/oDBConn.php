<?php
function oDBConn() {
	// INFO DB
	$DBhost = "localhost";  // "93.46.220.3";
	$DBuser = "ricibo14";
	$DBpass = "ricibo14";
	$DBName = "ricibo14";
	$codUscita = 0;
	$codUscita = mysqli_connect($DBhost,$DBuser,$DBpass,$DBName);
	if (!$codUscita) { $codUscita = 1; } // Errore: connessione al DB fallita
	else{return $codUscita;}
}
?>
