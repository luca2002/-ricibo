<?php
function oDBConn() {
	// INFO DB
	$DBhost = "localhost";  // "93.46.220.3";
	$nomeUtente = substr($_SESSION['PATH'],2);
	$DBuser = $nomeUtente;
	$DBpass = $nomeUtente;
	$DBName = $nomeUtente;
	$codUscita = 0;
	$codUscita = mysqli_connect($DBhost,$DBuser,$DBpass,$DBName);
	if (!$codUscita) { $codUscita = 1; } // Errore: connessione al DB fallita
	else{return $codUscita;}
}
?>

